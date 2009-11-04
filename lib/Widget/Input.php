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
class Opf_Widget_Input extends Opf_Widget_Component
{
	/**
	 * Returns the unique component type name.
	 * @return string
	 */
	public function getComponentName()
	{
		return 'input';
	} // end getComponentName();
	/**
	 * Displays the input component.
	 *
	 * @param array $attributes The opt:display attribute list.
	 */
	public function display($attributes = array())
	{
		$attributes = array(
			'name' => $this->_item->getFullyQualifiedName(),
			'value' => $this->_item->getValue(),
			'class' => Opf_Design::getClass('input', $this->_item->isValid())
		);
		echo '<input type="text" '.Opt_Function::buildAttributes($attributes).' />';
	} // end display();
} // end Opf_Widget_Input;