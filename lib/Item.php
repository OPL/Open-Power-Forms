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
	 * The list of errors.
	 * @var array
	 */
	protected $_errors = array();

	/**
	 * Is the item required to fill?
	 * @var boolean
	 */
	protected $_required = true;

	/**
	 * Is the item valid?
	 * @var boolean
	 */
	protected $_valid = true;

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
	 * Invokes the event on the registered event handlers.
	 * @param string $eventName The event name
	 * @throws Opf_UnknownEvent_Exception
	 */
	public function invokeEvent($eventName)
	{
		if($this->_listeners !== null)
		{
			$event = new Opf_Event($this, $eventName);

			foreach($this->_listeners as $listener)
			{
				if(method_exists($listener, $eventName))
				{
					$listener->$eventName($event);
				}
				else
				{
					throw new Opf_UnknownEvent_Exception($eventName);
				}
			}
		}
	} // end invokeEvent();

	/**
	 * Adds a new validator to the item.
	 * @param Opf_Validator_Interface $validator The new validator to add.
	 * @param string
	 */
	public function addValidator(Opf_Validator_Interface $validator, $customError = null)
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
	 * Adds a new error message to the error list.
	 * @param string $error The new error message
	 */
	public function addErrorMessage($error)
	{
		$this->_errors[] = $error;
	} // end addErrorMessage();

	/**
	 * Adds a group of the error messages to the error list.
	 * @param array $errors The error list.
	 */
	public function addErrorMessages(array $errors)
	{
		$this->_errors = array_merge($this->_errors, $errors);
	} // end addErrorMessages();

	/**
	 * Sets the new error message list.
	 * @param array $errors The error list.
	 */
	public function setErrorMessages(array $errors)
	{
		$this->_errors = $errors;
	} // end setErrorMessages();

	/**
	 * Returns true, if there are error messages assigned
	 * to the item.
	 * @return boolean
	 */
	public function hasErrors()
	{
		return sizeof($this->_errors) > 0;
	} // end hasErrors();

	/**
	 * Returns the list of error messages assigned to the item.
	 * @return array
	 */
	public function getErrorMessages()
	{
		return $this->_errors;
	} // end getErrorMessages();

	/**
	 * Sets the item value.
	 * @param mixed $value The new value.
	 */
	abstract public function setValue($value);

	/**
	 * Returns the item value.
	 * @return mixed
	 */
	abstract public function getValue();

	/**
	 * Validates the field against the registered validators.
	 * @param mixed $data The data to validate.
	 */
	protected function _validate(&$data)
	{
		$opf = Opl_Registry::get('opf');
		$tf = $opf->getTranslationInterface();
		foreach($this->_validators as $validator)
		{
			if(!$validator->validate($this, $data))
			{
				$this->_valid = false;
				if($tf === null)
				{
					$this->addErrorMessage(vsprintf($validator->getError(), $validator->getErrorData()));
				}
				else
				{
					$tf->assign($opf->translationGroup, $validator->getError(), $validator->getErrorData());
					$this->addErrorMessage($tf->_($opf->translationGroup, $validator->getError()));
				}
				return false;
			}
		}
		$this->_valid = true;
		return true;
	} // end _validate();
} // end Opf_Item;
