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
 * The class provides the necessary logic for the widgets in templates,
 * using the OPT Component API.
 */
abstract class Opf_Widget_Component implements Opt_Component_Interface
{
	/**
	 * The view the widget is deployed in.
	 * @var Opt_View
	 */
	protected $_view;

	/**
	 * The form the widget is assigned to.
	 * @var Opf_Form
	 */
	protected $_form;

	/**
	 * The item the widget is assigned to.
	 * @var Opf_Item
	 */
	protected $_item;

	/**
	 * The name of the widget used to find the form item.
	 * @var string
	 */
	protected $_name = null;

	/**
	 * The widget label.
	 * @var string
	 */
	protected $_label = '';

	/**
	 * The component constructor.
	 *
	 * @param string $name The widget name.
	 */
	public function __construct($name = '')
	{
		$this->_name = $name;
	} // end __construct();

	/**
	 * Sets the widget label. Implements the fluent interface.
	 *
	 * @param string $label The new label
	 * @return Opf_Widget_Component
	 */
	public function setLabel($label)
	{
		$this->_label = $label;
		return $this;
	} // end setLabel();

	/**
	 * Allows to set the options. By default, it does nothing but
	 * implementing the fluent interface.
	 * @param array $options The option list.
	 * @return Opf_Widget_Component
	 */
	public function setOptions($options)
	{
		return $this;
	} // end setOptions();

	/**
	 * Assigns the widget to a form item.
	 * @param Opf_Item $item The item the widget is assigned to.
	 */
	public function setItem(Opf_Item $item)
	{
		// TODO: How about assigning forms here?
		$this->_item = $item;
		$this->_name = $item->getName();
	} // end setItem();

	/**
	 * Releases the widget, so that it can be used again.
	 */
	public function unsetItem()
	{
		$this->_form = null;
		$this->_item = null;
	} // end unsetItem();

	/**
	 * Returns true, if the widget is already assigned to an item.
	 * @return boolean
	 */
	public function isBound()
	{
		return $this->_item !== null;
	} // end isBound();

	/**
	 * Passes the OPT view to the widget.
	 *
	 * @param Opt_View $view The view.
	 */
	public function setView(Opt_View $view)
	{
		$this->_view = $view;

		if($this->_form === null)
		{
			$this->_form = $view->getTemplateVar('form');
			if($this->_form === null)
			{
				throw new Opf_ItemNotExists_Exception('form');
			}
		}
		if($this->_item === null)
		{
			$this->_item = $this->_form->findItem($this->_name);
		}
	} // end setView();

	/**
	 * Sets the widget datasource.
	 *
	 * @param Array $data
	 */
	public function setDatasource($data)
	{

	} // end setDatasource();

	/**
	 * Allows to set various component properties.
	 * @param string $name The property name
	 * @param mixed $value The property value
	 */
	public function set($name, $value)
	{
		switch($name)
		{
			case 'label':
				$this->_label = $value;
				break;
		}
	} // end set();

	/**
	 * Returns the component properties.
	 *
	 * @param string $name The property name.
	 * @return mixed
	 */
	public function get($name)
	{
		switch($name)
		{
			case 'errors':
				return $this->_item->getErrorMessages();
			case 'label':
				return $this->_label;
		}
		return '';
	} // end get();

	/**
	 * Returns true, if the specified property exists and is set.
	 * @param string $name The property name.
	 */
	public function defined($name)
	{

	} // end defined();

	/**
	 * Processes the widget events. Returns true, if the event template code
	 * should be shown.
	 * @param string $name The event name.
	 * @return boolean
	 */
	public function processEvent($name)
	{
		switch($name)
		{
			case 'error':
				if(!$this->_item->isValid())
				{
					// TODO: Add error messages here!
					return true;
				}
				return false;
		}
	} // end processEvent();

	public function manageAttributes($tagName, Array $attributes)
	{

	} // end manageAttributes();
} // end Opf_Widget_Component;