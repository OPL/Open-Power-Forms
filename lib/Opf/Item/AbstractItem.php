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
 */

namespace Opf\Item;

use Opf\Exception;
use Opf\Event\EventListener;
use Opf\Event\Event;
use Opf\Widget;

/**
 * Represents a single item that OPF manages.
 *
 * Item is an abstract class, because it can represent either single
 * fields, or complex structures like forms or collections. Thanks to
 * a common ancestor, they will be using the same basic features, such
 * as event handling.
 */
abstract class AbstractItem
{
	/**
	 * The item name.
	 * @var string
	 */
	protected $_name = null;

	/**
	 * The fully qualified name
	 * @var string
	 */
	protected $_fullyQualifiedName = '';

	/**
	 * Superior qualified name - has a priority over the normal name.
	 * @var string
	 */
	protected $_superiorQualifiedName = null;

	/**
	 * The list of listeners.
	 * @var SplDoublyLinkedList
	 */
	protected $_listeners = null;

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
	 * The widget associated with the element.
	 * @var Opf\Widget\Component
	 */
	protected $_widget = null;

	/**
	 * Sets the item name.
	 *
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->_name = $name;
	} // end setName();

	/**
	 * Returns the item name.
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	} // end getName();

	/**
	 * Sets the fully qualified name the item belongs to. Note
	 * that the $fqn does not include the item name itself.
	 *
	 * @param string $fqn The new fully qualified name
	 */
	public function setFullyQualifiedName($fqn)
	{
		$this->_fullyQualifiedName = (string)$fqn;
	} // end setFullyQualifiedName();

	/**
	 * Sets a superior qualified name that has a priority over the normal
	 * fully qualified name.
	 *
	 * @param string $name The new superior qualified name
	 */
	public function setSuperiorQualifiedName($name)
	{
		$this->_superiorQualifiedName = (string)$name;
	} // end setSuperiorQualifiedName();

	/**
	 * Returns the fully qualified name of the element.
	 * @return string
	 */
	public function getFullyQualifiedName()
	{
		if($this->_superiorQualifiedName !== null)
		{
			return $this->_superiorQualifiedName;
		}
		if($this->_fullyQualifiedName === '')
		{
			return $this->_name;
		}
		return $this->_fullyQualifiedName.'['.$this->_name.']';
	} // end getFullyQualifiedName();

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
	 * @param Opf\Event\EventListener $listener The listener.
	 */
	public function appendListener(EventListener $listener)
	{
		if($this->_listeners === null)
		{
			$this->_listeners = new \SplDoublyLinkedList;
		}
		$this->_listeners->push($listener);
	} // end appendListener();

	/**
	 * Prepends the new listener to the list of item listeners.
	 *
	 * @param Opf\Event\EventListener $listener The listener.
	 */
	public function prependListener(EventListener $listener)
	{
		if($this->_listeners === null)
		{
			$this->_listeners = new \SplDoublyLinkedList;
		}
		$this->_listeners->unshift($listener);
	} // end prependListener();

	/**
	 * Returns the list of registered listeners.
	 *
	 * @return array
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
	 * @return boolean
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
	 * 
	 * @param string $eventName The event name
	 * @throws Opf\Event\UnknownEventException
	 */
	public function invokeEvent($eventName)
	{
		if($this->_listeners !== null)
		{
			$event = new Event($this, $eventName);
			
			foreach($this->_listeners as $listener)
			{
				if(method_exists($listener, $eventName))
				{
					$listener->$eventName($event);
				}
				else
				{
					throw new Exception('Unknown event: '.$eventName);
				}
			}
		}
	} // end invokeEvent();

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
	 * Sets the widget associated with the item. Returns the
	 * assigned widget for the fluent interface purposes.
	 *
	 * @param Opf\Widget\Component $widget The new widget.
	 * @return Opf\Item\AbstractItem
	 * @throws Opf\Exception
	 */
	public function setWidget(Widget\Component $widget)
	{
		if($widget->isBound())
		{
			throw new Exception('Widget already bound: '.$this->_name);
		}
		$widget->setItem($this);

		if($this->_widget !== null)
		{
			if($this->_widget instanceof Widget\Generic)
			{
				$widget->importFromGeneric($this->_widget);
			}
			$this->_widget->unsetItem();
		}

		$this->_widget = $widget;

		return $widget;
	} // end setWidget();

	/**
	 * Returns a widget associated with the form field.
	 * @return Opf\Widget\Component
	 */
	public function getWidget()
	{
		if($this->_widget === null)
		{
			$this->setWidget(new Widget\Generic());
		}
		return $this->_widget;
	} // end getWidget();

	/**
	 * Returns true, if the user has specified a widget
	 * to the leaf.
	 * @return boolean
	 */
	public function hasWidget()
	{
		return ($this->_widget === null);
	} // end hasWidget();

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

	public function invalidate()
	{
		$this->_valid = false;
	} // end invalidate();

	/**
	 * Validates the field against the registered validators.
	 * @param mixed $data The data to validate.
	 */
	protected function _validate(&$data, AbstractItem $errorClass = null)
	{
		$opf = \Opl_Registry::get('opf');
		$tf = $opf->getTranslationInterface();

		// The complex items may overwrite this setting to redirect the error
		// messages somewhere else.
		if($errorClass === null)
		{
			$errorClass = $this;
		}

		foreach($this->_validators as $validator)
		{
			if(!$validator->validate($errorClass, $data))
			{
				$this->_valid = false;
				if($tf === null)
				{
					$errorClass->addErrorMessage(vsprintf($validator->getError(), $validator->getErrorData()));
				}
				else
				{
					$tf->assign($opf->translationGroup, $validator->getError(), $validator->getErrorData());
					$errorClass->addErrorMessage($tf->_($opf->translationGroup, $validator->getError()));
				}
				return false;
			}
		}
		$errorClass->_valid = true;
		return true;
	} // end _validate();

	/**
	 * This is the private rendering utility. It may be used to describe the complex
	 * item rendering settings.
	 *
	 * @internal
	 */
	protected function _onRender(\Opt_View $view)
	{
		/* null */
	} // end _onRender();

	public static function isEmpty(&$value)
	{
		if(is_array($value) && sizeof($value) == 0)
		{
			return true;
		}
		if(is_scalar($value) && empty($value))
		{
			return true;
		}
		return false;
	} // end isEmpty();
} // end AbstractItem;
