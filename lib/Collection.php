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
 * $Id$
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

	public function removeItem($item, $placeholder = 'default')
	{

	} // end removeItem();

	public function replaceItem($newItem, $oldItem, $placeholder = 'default')
	{

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
		// TODO: Add sub-collection support.
		if(isset($this->_collection[$name]))
		{
			return $this->_collection[$name];
		}
		return NULL;
	} // end findItem();

	protected function _isItemAllowed(Opf_Item $item, $placeholder = 'default')
	{
		return true;
	} // end _isItemAllowed();
} // end Opf_Collection;