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
 
/**
 * The class represents an input widget.
 * @package Widgets
 */
class Yesno extends Component
{
	/**
	 * Returns the unique component type name.
	 * @return string
	 */
	public function getComponentName()
	{
		return 'yesno';
	} // end getComponentName();

	/**
	 * Displays the input component.
	 *
	 * @todo Add procedure injection!
	 * @todo Add translations.
	 * @param array $attributes The opt:display attribute list.
	 */
	public function display($attributes = array())
	{
		$name = $this->_item->getFullyQualifiedName();
		$value = $this->_item->getValue();
		echo '<fieldset class="'.Design::getClass('yesno', $this->_item->isValid()).'">
			<label class="yes"><input type="radio" name="'.$name.'" value="1" '.($value == true ? 'checked="checked"' : '').'> Yes</label>
			<label class="no"><input type="radio" name="'.$name.'" value="0" '.($value == false ? 'checked="checked"' : '').'> No</label>
		</fieldset>';
	} // end display();
} // end Yesno;
