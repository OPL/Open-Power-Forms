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
 * The class represents an input widget.
 * @package Widgets
 */
class Opf_Widget_Select extends Opf_Widget_Component
{
	/**
	 * The option list.
	 * @var array
	 */
	protected $_options = array();

	/**
	 * Returns the unique component type name.
	 * @return string
	 */
	public function getComponentName()
	{
		return 'select';
	} // end getComponentName();

	/**
	 * Allows to set the options. Implements the fluent interface.
	 * @param array $options The option list.
	 * @return Opf_Widget_Component
	 */
	public function setOptions($options)
	{
		$this->_options = $options;
		return $this;
	} // end setOptions();

	/**
	 * Displays the select component.
	 *
	 * @param array $attributes The opt:display attribute list.
	 */
	public function display($attributes = array())
	{
		$attributes = array(
			'name' => $this->_name,
			'class' => Opf_Design::getClass('select', $this->_item->isValid())
		);
		$code = '<select '.Opt_Function::buildAttributes($attributes).'>';
		foreach($this->_options as $id => $option)
		{
			if($id == $this->_item->getValue())
			{
				$code .= '<option value="'.$id.'" selected="selected">'.$option.'</option>';
			}
			else
			{
				$code .= '<option value="'.$id.'">'.$option.'</option>';
			}
		}
		echo $code.'</select>';
	} // end display();
} // end Opf_Widget_Select;