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
 * Represents a single item that OPF manages.
 *
 * Item is an abstract class, because it can represent either single
 * fields, or complex structures like forms or collections. Thanks to
 * a common ancestor, they will be using the same basic features, such
 * as event handling.
 */
abstract class Opf_Item
{
	/**
	 * The item name.
	 * @var String
	 */
	protected $_name = null;

	/**
	 * The list of listeners.
	 * @var SplDoublyLinkedList
	 */
	protected $_listeners = null;

	/**
	 * The list of validators.
	 * @var array
	 */
	protected $_validators = array();

	/**
	 * Is the item required to fill?
	 * @var boolean
	 */
	protected $_required = true;

	/**
	 * Is the item valid?
	 * @var boolean
	 */
	protected $_valid = false;

	/**
	 * The validator list.
	 *
	 * @var Array
	 */

	/**
	 * Sets the item name.
	 *
	 * @param String $name
	 */
	public function setName($name)
	{
		$this->_name = $name;
	} // end setName();

	/**
	 * Returns the item name.
	 * @return String
	 */
	public function getName()
	{
		return $this->_name;
	} // end getName();

	/**
	 * Sets the required state.
	 * @param boolean $required The new state.
	 */
	public function setRequired($required)
	{
		$this->_required = (bool)$required;
	} // end setRequired();

	/**
	 * Returns the required state.
	 * @return boolean
	 */
	public function getRequired()
	{
		return $this->_required;
	} // end getRequired();

	/**
	 * Returns true, if the item is valid.
	 * @return boolean
	 */
	public function isValid()
	{
		return $this->_valid;
	} // end isValid();

	/**
	 * Appends the new listener to the list of item listeners.
	 *
	 * @param Opf_EventListener $listener The listener.
	 */
	public function appendListener(Opf_EventListener $listener)
	{
		if($this->_listeners === null)
		{
			$this->_listeners = new SplDoublyLinkedList;
		}
		$this->_listeners->push($listener);
	} // end appendListener();

	/**
	 * Prepends the new listener to the list of item listeners.
	 *
	 * @param Opf_EventListener $listener The listener.
	 */
	public function prependListener(Opf_EventListener $listener)
	{
		if($this->_listeners === null)
		{
			$this->_listeners = new SplDoublyLinkedList;
		}
		$this->_listeners->unshift($listener);
	} // end prependListener();

	/**
	 * Returns the list of registered listeners.
	 *
	 * @return Array
	 */
	public function getListeners()
	{
		if($this->_listeners !== null)
		{
			$out = array();
			foreach($this->_listeners as $listener)
			{
				$out[] = $listener;
			}
			return $out;
		}
		return array();
	} // end getListeners();

	/**
	 * Returns true, if the item has any listeners.
	 *
	 * @return Boolean
	 */
	public function hasListeners()
	{
		if($this->_listeners === null)
		{
			return false;
		}
		return $this->_listeners->count() > 0;
	} // end hasListeners();

	/**
	 * Adds a new validator to the item.
	 * @param Opf_Validator_Interface $validator The new validator to add.
	 */
	public function addValidator(Opf_Validator_Interface $validator)
	{
		$this->_validators[] = $validator;
	} // end addValidator();

	/**
	 * Removes an existing validator from an item. The validator can be determined
	 * either by its index number or the object.
	 *
	 * @param integer|Opf_Validator_Interface $validator The validator to remove.
	 */
	public function removeValidator($validator)
	{
		if(is_integer($validator))
		{
			if(isset($this->_validators[$validator]))
			{
				unset($this->_validators[$validator]);
			}
		}
		elseif($validator instanceof Opf_Validator_Interface)
		{
			foreach($this->_validators as $id => $obj)
			{
				if($obj === $validator)
				{
					unset($this->_validators[$id]);
				}
			}
		}
	} // end removeValidator();

	/**
	 * Returns true, if the specified validator is registered in the item.
	 * The validator can be determined either by its index number or the
	 * object.
	 *
	 * @param integer|Opf_Validator_Interface $validator The validator to check.
	 * @return boolean
	 */
	public function hasValidator($validator)
	{
		if(is_integer($validator))
		{
			return (isset($this->_validators[$validator]));
		}
		elseif($validator instanceof Opf_Validator_Interface)
		{
			foreach($this->_validators as $id => $obj)
			{
				if($obj === $validator)
				{
					return true;
				}
			}
			return false;
		}
	} // end hasValidator();

	/**
	 * Validates the field against the registered validators.
	 * @param mixed $data The data to validate.
	 */
	protected function _validate(&$data)
	{
		foreach($this->_validators as $validator)
		{
			if(!$validator->validate($data))
			{
				$this->_valid = false;
				return false;
			}
		}
		$this->_valid = true;
		return true;
	} // end _validate();
} // end Opf_Item;
