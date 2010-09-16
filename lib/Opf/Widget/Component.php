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

/**
 * The class provides the necessary logic for the widgets in templates,
 * using the OPT Component API.
 * @package Widgets
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
	 * Returns the unique component type name. The components should
	 * overwrite this method in order to return their own names.
	 * @return string
	 */
	public function getComponentName()
	{
		return 'default';
	} // end getComponentName();

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
	 * Copies the properties from a generic widget.
	 * @param Opf_Widget_Generic $generic The generic widget.
	 */
	public function importFromGeneric(Opf_Widget_Generic $generic)
	{
		$this->_item = $generic->_item;
		$this->_form = $generic->_form;

		// Copy the other data only if they are not already set.
		$this->_label == '' and $this->_label = $generic->_label;
		$this->_name == '' and $this->_name = $generic->_name;
		isset($this->_options) and $this->_options = $generic->_options;
	} // end importFromGeneric();

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
				throw new Opf_Exception('Item "form" not exists.');
			}
		}
	} // end setView();

	/**
	 * Sets the widget datasource.
	 *
	 * @param Array $data
	 */
	public function setDatasource($data)
	{
		if(is_array($data))
		{
			$this->setOptions($data);
		}
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
		/*	case 'name':
				$this->_name = $value;
				if($this->_item === null)
				{
					$item = $this->_form->findItem($this->_name);
					$item->setWidget($this);
					if($item === null)
					{
						throw new Opf_ItemNotExists_Exception('item', $this->_name);
					}
				}
				break; */
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
		//
	} // end defined();

	/**
	 * Alias for get.
	 */
	public function __get($name)
	{
		return $this -> get($name);
	} // end __get

	/**
	 * Alias for set.
	 */
	public function __set($name, $value)
	{
		$this -> set($name, $value);
	} // end __set

	/**
	 * Alias for defined.
	 */
	public function __isset($name)
	{
		return $this -> defined($name);
	} // end __isset

	/**
	 * Performs code injection.
	 * @param closure $injection
	 */
	public function setInjection($injection)
	{
		//;
	}// end setInjection

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
					return true;
				}
				return false;
			case 'required':
				return $this->_item->getRequired();
		}
	} // end processEvent();

	public function manageAttributes($tagName, Array $attributes)
	{
		$valid = $this->_item->isValid();
		$attributes['class'] = Opf_Design::getClass($this->getComponentName().'.field', $valid);
		if($attributes['class'] === null)
		{
			$attributes['class'] = Opf_Design::getClass('field', $valid);
		}
		return $attributes;
	} // end manageAttributes();
} // end Opf_Widget_Component;