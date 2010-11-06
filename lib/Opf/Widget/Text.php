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

namespace Opf\Widget;

use Opf\Design;
use Opt_Function;

/**
 * The class represents a text area widget.
 * @package Widgets
 */
class Text extends Component
{
	/**
	 * Returns the unique component type name.
	 * @return string
	 */
	public function getComponentName()
	{
		return 'text';
	} // end getComponentName();
	/**
	 * Displays the textarea component.
	 *
	 * @param array $attributes The opt:display attribute list.
	 */
	public function display($attributes = array())
	{
		$attributes = array(
			'name' => $this->_item->getFullyQualifiedName(),
			'class' => Design::getClass('input', $this->_item->isValid()),
			// TODO: Move to design or something like that.
			'rows' => 5,
			'cols' => 50
		);
		echo '<textarea '.Opt_Function::buildAttributes($attributes).'>'.$this->_item->getDisplayedValue().'</textarea>';
	} // end display();
} // end Opf_Widget_Text;