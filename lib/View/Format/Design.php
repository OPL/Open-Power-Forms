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
 * $Id: Form.php 220 2009-09-01 10:24:06Z zyxist $
 */

/**
 * A data format for Opf_Design.
 */
class Opf_View_Format_Design extends Opt_Compiler_Format
{
	/**
	 * The supported elements.
	 * @var array
	 */
	protected $_supports = array(
		'variable'
	);

	/**
	 * The data format properties.
	 * @var array
	 */
	protected $_properties = array(
		'variable:captureAll' => true,
		'variable:assign' => true,
		'variable:useReference' => false,
	);

	/**
	 * Build a PHP code for the specified hook name.
	 *
	 * @param String $hookName The hook name
	 * @return String The output PHP code
	 */
	protected function _build($hookName)
	{
		switch($hookName)
		{
			case 'variable:capture':
				$ns = $this->_getVar('items');
				if(sizeof($ns) < 2)
				{
					throw new Opf_InvalidDesignCall_Exception(implode('.', $ns));
				}
				// Remove the unnecessary items
				$last = end($ns);
				array_shift($ns);
				if($last == 'valid' || $last == 'invalid')
				{
					$method = ($last == 'valid' ? 'getValidClass' : 'getInvalidClass');
					array_pop($ns);
				}
				else
				{
					$method = 'getValidClass';
				}
				return 'Opf_Design::'.$method.'(\''.implode('.', $ns).'\')';
			case 'variable:captureAssign':
				$ns = $this->_getVar('items');
				if(sizeof($ns) < 2)
				{
					throw new Opf_InvalidDesignCall_Exception(implode('.', $ns));
				}
				// Remove the unnecessary items
				$last = end($ns);
				array_shift($ns);
				if($last == 'valid' || $last == 'invalid')
				{
					$method = ($last == 'valid' ? 'setValidClass' : 'setInvalidClass');
					array_pop($ns);
				}
				else
				{
					$method = 'setValidClass';
				}
				return 'Opf_Design::'.$method.'(\''.implode('.', $ns).'\', '.$this->_getVar('value').')';
		}
	} // end _build();
} // end Opf_View_Format_Design;