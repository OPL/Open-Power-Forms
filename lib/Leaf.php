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
 * Represents a leaf node of a form tree, unsually a form field.
 */
class Opf_Leaf extends Opf_Item
{
	/**
	 * The leaf initial value.
	 * @var mixed
	 */
	protected $_value = null;
	/**
	 * The widget associated with the element.
	 * @var Opf_Widget_Component
	 */
	protected $_widget = null;

	/**
	 * Creates a new leaf item.
	 * @param string $name The item name.
	 */
	public function __construct($name)
	{
		$this->setName($name);
	} // end __construct();

	/**
	 * Sets the widget associated with the item.
	 *
	 * @param Opf_Widget_Component $widget The new widget.
	 */
	public function setWidget(Opf_Widget_Component $widget)
	{
		if($widget->isBound())
		{
			throw new Opf_WidgetAlreadyBound_Exception($this->_name);
		}
		$widget->setItem($this);

		if($this->_widget !== null)
		{
			$this->_widget->unsetItem();
		}

		$this->_widget = $widget;
	} // end setWidget();

	/**
	 * Returns a widget associated with the form field.
	 * @return Opf_Widget_Component
	 */
	public function getWidget()
	{
		if($this->_widget === null)
		{
			$this->setWidget(new Opf_Widget_Input());
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

	public function populate(&$data)
	{
		$this->_value = $data;
	} // end populate();
} // end Opf_Leaf;