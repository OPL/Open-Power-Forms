<?php
/*
 *  OPEN POWER LIBS <http://www.invenzzia.org>
 *  ------------------------------------------
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 *
 */

/**
 * The class represents a collection of items and provides services to manage
 * them.
 */
abstract class Opf_Collection extends Opf_Item implements Opf_Collection_Interface
{
	/**
	 * The item list.
	 * @var array
	 */
	protected $_items = array();

	/**
	 * The alternative collection of items without the placeholders.
	 * @var array
	 */
	protected $_collection = array();

	/**
	 * Appends a new item to a collection.
	 *
	 * @param Opf_Item $item The item to append.
	 * @param string $placeholder The placeholder name.
	 */
	public function appendItem(Opf_Item $item, $placeholder = 'default')
	{
		if(!$this->_isItemAllowed($item, $placeholder))
		{
			throw new Opf_ItemNotAllowed_Exception($item->getName(), $this->getName());
		}

		if(!isset($this->_items[$placeholder]))
		{
			$this->_items[$placeholder] = array();
		}
		$this->_collection[$item->getName()] = $item;
		$this->_items[$placeholder][] = $item;
	} // end appendItem();

	/**
	 * Prepends a new item to a collection.
	 *
	 * @param Opf_Item $item The item to append.
	 * @param string $placeholder The placeholder name.
	 */
	public function prependItem(Opf_Item $item, $placeholder = 'default')
	{
		if(!$this->_isItemAllowed($item, $placeholder))
		{
			throw new Opf_ItemNotAllowed_Exception($item->getName(), $this->getName());
		}

		if(!isset($this->_items[$placeholder]))
		{
			$this->_items[$placeholder] = array();
		}
		$this->_collection[$item->getName()] = $item;
		array_unshift($this->_items[$placeholder], $item);
	} // end prependItem();

	/**
	 * Returns the item from a collection.
	 *
	 * @param string $item The item name
	 * @return Opf_Item
	 */
	public function getItem($item)
	{
		if(!isset($this->_collection[$item]))
		{
			return null;
		}
		return $this->_collection[$item];
	} // end getItem();

	/**
	 * Removes an existing item from a collection. The item can be determined by:
	 *  - The object
	 *  - The ordered number within a placeholder
	 *  - The string name of an item
	 *
	 * Only the selected placeholder is scanned. The default placeholder is 'default'.
	 * 
	 * @param integer|string|Opf_Item $item The item to remove.
	 * @param string $placeholder The placeholder, where the item should be looked for.
	 * @return boolean
	 * @throws Opf_PlaceholderNotExists_Exception
	 */
	public function removeItem($item, $placeholder = 'default')
	{
		if(!isset($this->_items[$placeholder]))
		{
			throw new Opf_PlaceholderNotExists_Exception($placeholder, $this->getName());
		}

		// The integer call
		if(is_integer($item))
		{
			$i = 0;
			foreach($this->_items[$placeholder] as $id => $it)
			{
				if($i == $id)
				{
					unset($this->_items[$placeholder][$id]);
					unset($this->_collection[$it->_name]);
					return true;
				}
				$i++;
			}
		}
		// The string call
		elseif(is_string($item))
		{
			foreach($this->_items[$placeholder] as $id => $it)
			{
				if($item == $it->_name)
				{
					unset($this->_items[$placeholder][$id]);
					unset($this->_collection[$it->_name]);
					return true;
				}
			}
		}
		// The object call
		elseif(is_object($item))
		{
			foreach($this->_items[$placeholder] as $id => $it)
			{
				if($item === $it)
				{
					unset($this->_items[$placeholder][$id]);
					unset($this->_collection[$it->_name]);
					return true;
				}
			}
		}
		return false;
	} // end removeItem();

	/**
	 * Replaces an existing item with a new one. The item can be determined by:
	 *  - The object
	 *  - The ordered number within a placeholder
	 *  - The string name of an item
	 *
	 * Only the selected placeholder is scanned. The default placeholder is 'default'.
	 * 
	 * @param Opf_Item $newItem The new item
	 * @param integer|string|Opf_Item $oldItem The item to replace
	 * @param string $placeholder The placeholder where the item is located
	 */
	public function replaceItem(Opf_Item $newItem, $oldItem, $placeholder = 'default')
	{
		if(!isset($this->_items[$placeholder]))
		{
			throw new Opf_PlaceholderNotExists_Exception($placeholder, $this->getName());
		}

		// The integer call
		if(is_integer($oldItem))
		{
			$i = 0;
			foreach($this->_items[$placeholder] as $id => $it)
			{
				if($i == $oldItem)
				{
					$this->_items[$placeholder][$id] = $newItem;
					$this->_collection[$it->_name] = $newItem;
					return true;
				}
				$i++;
			}
		}
		// The string call
		elseif(is_string($oldItem))
		{
			foreach($this->_items[$placeholder] as $id => $it)
			{
				if($oldItem == $it->_name)
				{
					$this->_items[$placeholder][$id] = $newItem;
					$this->_collection[$it->_name] = $newItem;
					return true;
				}
			}
		}
		// The object call
		elseif(is_object($oldItem))
		{
			foreach($this->_items[$placeholder] as $id => $it)
			{
				if($oldItem === $it)
				{
					$this->_items[$placeholder][$id] = $newItem;
					$this->_collection[$it->_name] = $newItem;
					return true;
				}
			}
		}
		return false;
	} // end replaceItem();

	public function getItems($placeholder = 'default')
	{
		$result = array();
		if(!isset($this->_items[$placeholder]))
		{
			return $result;
		}
		foreach($this->_items[$placeholder] as $item)
		{
			$result[] = $item;
		}
		return $result;
	} // end getItems();

	/**
	 * Finds an item with the specified name in the entire collection.
	 * The item is also looked for in the sub-collections.
	 *
	 * @param string $name The item name
	 * @return Opf_Item
	 */
	public function findItem($name)
	{
		if(isset($this->_collection[$name]))
		{
			return $this->_collection[$name];
		}
		return NULL;
	} // end findItem();

	/**
	 * Allows to check, if the item is allowed in this particular collection.
	 * In the default implementation, the method always returns true.
	 *
	 * @param Opf_Item $item The item to test
	 * @param string $placeholder The placeholder name
	 * @return boolean
	 */
	protected function _isItemAllowed(Opf_Item $item, $placeholder = 'default')
	{
		return true;
	} // end _isItemAllowed();
} // end Opf_Collection;