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
 * A data format for form sections in OPT templates.
 */
class Opf_View_Format_FormRepeater extends Opt_Format_Abstract
{
	/**
	 * The supported elements.
	 * @var array
	 */
	protected $_supports = array(
		'section', 'item'
	);

	/**
	 * The format properties.
	 * @var array
	 */
	protected $_properties = array(
		'section:item' => true,
		'section:useReference' => false,
		'section:anyRequests' => null,
		'section:itemAssign' => false,
		'section:variableAssign' => false,
		'item:assign' => false,
		'item:useReference' => false,
	);

	/**
	 * Builds a PHP code for the specified hook name.
	 *
	 * @param String $hookName The hook name
	 * @return String The output PHP code
	 */
	protected function _build($hookName)
	{
		if($hookName == 'section:init')
		{
			// Initializes the section by obtaining the list of items to display
			$section = $this->_getVar('section');
			$form = Opf_View_Instruction_Form::getProcessedForm();
			$code = '$_repeater = $_form->findItem(\''.$section['name'].'\'); ';

			if($section['order'] == 'desc')
			{
				return $code.' $_sect'.$section['name'].'_vals = array_reverse($_repeater->getItems(\''.$section['name'].'\')); ';
			}
			return $code.' $_sect'.$section['name'].'_vals = $_repeater->getItems(\''.$section['name'].'\'); ';
		}
		// return parent::_build($hookName);
	} // end _build();
} // end Opf_View_Format_FormWrapper;