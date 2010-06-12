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
 * $Id: Design.php -1   $
 */

/**
 * A data format for Opf_Design.
 */
class Opf_View_Format_Design extends Opt_Format_Abstract
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
		'variable:capture.assign' => true,
		'variable:assign' => true,
		'variable:useReference' => false,
		'variable:item.assign' => true,
		'item:item.assign' => true,
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
				$last = $this -> _getVar('item');
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
			// case 'variable:item.assign':
			case 'variable:item.assign':
				$last = $this -> _getVar('item');
				if($last == 'valid' || $last == 'invalid')
				{
					$method = ($last == 'valid' ? 'setValidClass' : 'setInvalidClass');
					array_pop($ns);
				}
				else
				{
					$method = 'setValidClass';
				}
				static $i = 0;
				return '$set' . ++$i . ' = Opf_Design::'.$method.'(\''.$this->_getVar('item') . '.' . substr($this->_getVar('value'), 1, -1) . '\', '.$this->_getVar('value') . '); $set' . $i;
		}
	} // end _build();
} // end Opf_View_Format_Design;