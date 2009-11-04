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
 * A data format for form sections in OPT templates.
 */
class Opf_View_Format_Form extends Opt_Compiler_Format
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
		'section:useReference' => false,
		'section:anyRequests' => null,
		'section:itemAssign' => false,
		'section:variableAssign' => false,
		'item:assign' => false,
		'item:useReference' => false,
	);

	/**
	 * The conversion list.
	 * @var array
	 * @static
	 */
	static protected $_conversions = array();

	/**
	 * Builds a PHP code for the specified hook name.
	 *
	 * @param String $hookName The hook name
	 * @return String The output PHP code
	 */
	protected function _build($hookName)
	{
		switch($hookName)
		{
			// Initializes the section by obtaining the list of items to display
			case 'section:init':
				$section = $this->_getVar('section');
				if($section['parent'] !== null)
				{
					$parent = Opt_Instruction_BaseSection::getSection($section['parent']);
					$parent['format']->assign('item', $section['name']);
					return '$_sect'.$section['name'].'_vals = '.$parent['format']->get('section:variable').'; ';
				}
				$form = Opf_View_Instruction_Form::getProcessedForm();
				if($section['order'] == 'desc')
				{
					return '$_sect'.$section['name'].'_vals = array_reverse($_form->getItems(\''.$section['name'].'\')); ';
				}
				return '$_sect'.$section['name'].'_vals = $_form->getItems(\''.$section['name'].'\'); ';
			// The end of the section loop.
			case 'section:endLoop':
				return ' } ';
			// The condition that should test if the section is not empty.
			case 'section:isNotEmpty':
				$section = $this->_getVar('section');
				return 'is_array($_sect'.$section['name'].'_vals) && ($_sect'.$section['name'].'_cnt = sizeof($_sect'.$section['name'].'_vals)) > 0';			// The code block after the condition
			case 'section:started':
				return '';
			// The code block before the end of the conditional block.
			case 'section:finished':
				return '';
			// The code block after the conditional block
			case 'section:done':
				$section = $this->_getVar('section');
				return '';
			// The code block before entering the loop.
			case 'section:loopBefore':
				return '';
			// The default loop for the ascending order.
			case 'section:startAscLoop':
				$section = $this->_getVar('section');
				return 'foreach($_sect'.$section['name'].'_vals as $_sect'.$section['name'].'_i => $_sect'.$section['name'].'_v){ ';
			// The default loop for the descending order.
			case 'section:startDescLoop':
				$section = $this->_getVar('section');
				return 'foreach($_sect'.$section['name'].'_vals as $_sect'.$section['name'].'_i => $_sect'.$section['name'].'_v){ ';
			// Retrieving the whole section item.
			case 'section:item':
				$section = $this->_getVar('section');
				return '$_sect'.$section['name'].'_v';
			// Retrieving a variable from a section item.
			case 'section:variable':
				$section = $this->_getVar('section');
				if($this->isDecorating())
				{
					return '$_sect'.$section['name'].'_v'.$this->_decorated->get('item:item');
				}
				return '$_sect'.$section['name'].'_v->'.$this->_getVar('item');
			// Resetting the section to the first element.
			case 'section:reset':
				$section = $this->_getVar('section');
				return 'reset($_sect'.$section['name'].'_vals);';
				break;
			// Moving to the next element.
			case 'section:next':
				$section = $this->_getVar('section');
				return '$_sect'.$section['name'].'_i++;';
			// Checking whether the iterator is valid.
			case 'section:valid':
				$section = $this->_getVar('section');
				return 'isset($_sect'.$section['name'].'_vals[$_sect'.$section['name'].'_i])';
			// Populate the current element
			case 'section:populate':
				$section = $this->_getVar('section');
				return '$_sect'.$section['name'].'_v = current($_sect'.$section['name'].'_vals); $_sect'.$section['name'].'_i = key($_sect'.$section['name'].'_vals);';
			// The code that returns the number of items in the section;
			case 'section:count':
				$section = $this->_getVar('section');
				return '$_sect'.$section['name'].'_cnt';
			// Section item size.
			case 'section:size':
				$section = $this->_getVar('section');
				return '($_sect'.$section['name'].'_v instanceof Countable ? $_sect'.$section['name'].'_v->count() : -1)';
			// Section iterator.
			case 'section:iterator':
				$section = $this->_getVar('section');
				return '$_sect'.$section['name'].'_i';
			// Testing the first element.
			case 'section:isFirst':
				return '$_sect'.$section['nesting'].'_i == 0';
			// Testing the last element.
			case 'section:isLast':
				return '$_sect'.$section['nesting'].'_i == ($_sect'.$section['name'].'_cnt-1)';
			// Testing the extreme element.
			case 'section:isExtreme':
				$section = $this->_getVar('section');
				return '(($_sect'.$section['nesting'].'_i == ($_sect'.$section['name'].'_cnt-1)) || ($_sect'.$section['nesting'].'_i == 0))';
			case 'item:item':
				switch($this->_getVar('item'))
				{
					case 'component':
					case 'widget':
						return '->getWidget()';
					case 'name':
						return '->getName()';
					case 'valid':
						return '->isValid()';
				}
				return '';
			default:
				return NULL;
		}
	} // end _build();
} // end Opf_View_Format_Form;