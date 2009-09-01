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
 */
class Opf_Widget_Select extends Opf_Widget_Component
{
	/**
	 * The option list.
	 * @var array
	 */
	protected $_options = array();

	/**
	 * Sets the "select" field options.
	 * @param array $options The option list.
	 */
	public function setOptions($options)
	{
		$this->_options = $options;
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