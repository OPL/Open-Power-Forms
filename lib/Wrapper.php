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
 * This is a wrapper for another item that serves as a pattern.
 * A group of patterns created for the same item shares the name,
 * validation and display settings but differ in the values they
 * keep.
 */
class Opf_Wrapper extends Opf_Item implements Opf_Collection_Interface
{
	/**
	 * The item pattern.
	 * @var Opf_Item
	 */
	protected $_item;

	/**
	 * The item value.
	 * @var mixed
	 */
	protected $_value;

	/**
	 * Creates a new wrapper with the specified item as a pattern.
	 *
	 * @param Opf_Item $item The pattern item.
	 */
	public function __construct(Opf_Item $item)
	{
		$this->_item = $item;
		$this->setName($item->getName());
	} // end __construct();

	/**
	 * Sets the item to repeat.
	 *
	 * @param Opf_Item $item The new item to repeat.
	 */
	public function setItem(Opf_Item $item)
	{
		$this->_item = $item;
		$this->setName($item->getName());
	} // end setItem();

	/**
	 * Returns the repeated item.
	 *
	 * @return Opf_Item
	 */
	public function getItem()
	{
		return $this->_item;
	} // end getItem();

	/**
	 * From Opf_Collection_Interface - works only, if the wrapped item
	 * supports it.
	 *
	 * @param string $placeholder The placeholder name
	 */
	public function getItems($placeholder = 'default')
	{
		if(!$this->_item instanceof Opf_Collection_Interface)
		{
			throw new Opf_NotSupported_Exception('getItems(): the wrapped item does not support Opf_Collection_Interface');
		}
		return $this->_item->getItems($placeholder);
	} // end getItems();

	/**
	 * From Opf_Collection_Interface - works only, if the wrapped item
	 * supports it.
	 *
	 * @param string $placeholder The item name to find
	 */
	public function findItem($name)
	{
		if(!$this->_item instanceof Opf_Collection_Interface)
		{
			throw new Opf_NotSupported_Exception('findItem(): the wrapped item does not support Opf_Collection_Interface');
		}
		return $this->_item->findItem($name);
	} // end findItem();

	/**
	 * An interface for forms.
	 * 
	 * @param <type> $className
	 * @param <type> $tagName
	 * @param array $attributes 
	 */
	public function _widgetFactory($className, $tagName, Array $attributes)
	{
		if(!$this->_item instanceof Opf_Form)
		{
			throw new Opf_NotSupported_Exception('_widgetFactory(): the wrapped item does not support Opf_Form');
		}
		return $this->_item->_widgetFactory($className, $tagName, $attributes);
	} // end _widgetFactory();

	/**
	 * Appends the new listener to the list of item listeners.
	 *
	 * @param Opf_EventListener $listener The listener.
	 */
	public function appendListener(Opf_EventListener $listener)
	{
		$this->_item->appendListener($listener);
	} // end appendListener();

	/**
	 * Prepends the new listener to the list of item listeners.
	 *
	 * @param Opf_EventListener $listener The listener.
	 */
	public function prependListener(Opf_EventListener $listener)
	{
		$this->_item->prependListener($listener);
	} // end prependListener();

	/**
	 * Returns the list of registered listeners.
	 *
	 * @return Array
	 */
	public function getListeners()
	{
		return $this->_item->getListeners();
	} // end getListeners();

	/**
	 * Returns true, if the item has any listeners.
	 *
	 * @return Boolean
	 */
	public function hasListeners()
	{
		return $this->_item->hasListeners();
	} // end hasListeners();

	/**
	 * Invokes the event on the registered event handlers.
	 * @param string $eventName The event name
	 * @throws Opf_UnknownEvent_Exception
	 */
	public function invokeEvent($eventName)
	{
		return $this->_item->invokeEvent($eventName);
	} // end invokeEvent();

	/**
	 * Adds a new validator to the item.
	 * @param Opf_Validator_Interface $validator The new validator to add.
	 * @param string $customError A custom error message used with this validator.
	 */
	public function addValidator(Opf_Validator_Interface $validator, $customError = null)
	{
		$this->_item->addValidator($validator, $customError);
	} // end addValidator();

	/**
	 * Removes an existing validator from an item. The validator can be determined
	 * either by its index number or the object.
	 *
	 * @param integer|Opf_Validator_Interface $validator The validator to remove.
	 */
	public function removeValidator($validator)
	{
		$this->_item->removeValidator($validator);
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
		return $this->_item->hasValidator($validator);
	} // end hasValidator();

	/**
	 * Sets the item value.
	 * @param mixed $value The new value.
	 */
	public function setValue($value)
	{
		$this->_value = $value;
	} // end setValue();

	/**
	 * Returns the item value.
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->_value;
	} // end getValue();
} // end Opf_Pattern;