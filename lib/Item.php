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
	 *
	 * @var SplDoublyLinkedList
	 */
	protected $_listeners = null;

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

} // end Opf_Item;
