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
				if(sizeof($ns) == 2)
				{
					return 'Opf_Design::getValidClass(\''.$ns[1].'\')';
				}
				elseif(sizeof($ns) == 3)
				{
					if($ns[2] == 'valid')
					{
						return 'Opf_Design::getValidClass(\''.$ns[1].'\')';
					}
					elseif($ns[2] == 'invalid')
					{
						return 'Opf_Design::getInvalidClass(\''.$ns[1].'\')';
					}
				}
				throw new Opf_InvalidDesignCall_Exception(implode('.', $ns));
				break;
			case 'variable:captureAssign':
				$ns = $this->_getVar('items');
				if(sizeof($ns) == 2)
				{
					return 'Opf_Design::setValidClass(\''.$ns[1].'\', '.$this->_getVar('value').')';
				}
				elseif(sizeof($ns) == 3)
				{
					if($ns[2] == 'valid')
					{
						return 'Opf_Design::setValidClass(\''.$ns[1].'\', '.$this->_getVar('value').')';
					}
					elseif($ns[2] == 'invalid')
					{
						return 'Opf_Design::setInvalidClass(\''.$ns[1].'\', '.$this->_getVar('value').')';
					}
				}
				throw new Opf_InvalidDesignCall_Exception(implode('.', $ns));
		}
	} // end _build();
} // end Opf_View_Format_Design;