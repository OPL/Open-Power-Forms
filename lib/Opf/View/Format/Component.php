<?php
/*
 *  OPEN POWER LIBS <http://www.invenzzia.org>
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 */

namespace Opf\View\Format;

/**
 * A data format for component hosting.
 *
 * @author Tomasz Jędrzejewski
 * @copyright Invenzzia Group <http://www.invenzzia.org/> and contributors.
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Component extends \Opt_Format_Abstract
{
	/**
	 * The list of supported hook types.
	 * @var array
	 */
	protected $_supports = array(
		'component'
	);

	/**
	 * Build a PHP code for the specified hook name.
	 *
	 * @internal
	 * @param string $hookName The hook name
	 * @return string The output PHP code
	 */
	protected function _build($hookName)
	{
		switch($hookName)
		{
			case 'component:init':
				return ' '.$this->_getVar('variable').'->setView($this); ';
			case 'component:done':
				return '';
			case 'component:valid':
				return ' '.$this->_getVar('variable').' instanceof Opt_Component_Interface';
			case 'component:build':
				$attributes = 'array(';
				foreach($this->_getVar('attributes') as $name => $value)
				{
					$attributes .= '\''.$name.'\' => '.$value.', ';
				}
				$attributes .= ')';
				return ' '.$this->_getVar('variable').' = $_form->_widgetFactory(\''.$this->_getVar('className').'\', \''.$this->_getVar('tagName').'\', '.$attributes.'); ';
			case 'component:datasource':
				return ' '.$this->_getVar('variable').'->setDatasource('.$this->_getVar('datasource').'); ';
			case 'component:event-open':
				return ' if('.$this->_getVar('variable').'->processEvent('.$this->_getVar('eventName').')){ ';
			case 'component:event-close':
				return ' } ';
			case 'component:display':
				$attrs = $this->_getVar('attributes');
				$subCode = '';
				if(sizeof($attrs) > 0)
				{
					$subCode = 'array(';
					foreach($attrs as $name => $value)
					{
						$subCode .= '\''.$name.'\' => '.$value.',';
					}
					$subCode .= ')';
				}
				return ' '.$this->_getVar('variable').'->display('.$subCode.'); ';
			case 'component:inject-open':
				return ' '.$this->_getVar('variable').'->setInjection(';
			case 'component:inject-close':
				return '); ';
			case 'component:manage-attributes':
				$attrs = $this->_getVar('attributes');
				$subCode = 'array()';
				if(sizeof($attrs) > 0)
				{
					$subCode = 'array(';
					foreach($attrs as $name => $value)
					{
						$subCode .= '\''.$name.'\' => '.$value.',';
					}
					$subCode .= ')';
				}

				return ' $out = '.$this->_getVar('variable').'->manageAttributes(\''.$this->_getVar('tag').'\', '.$subCode.'); ';
			case 'component:manage-attributes-apply':
				return ' if(is_array($out)){ foreach($out as $name=>$value){ echo \' \'.$name.\'="\'.$value.\'"\'; } } ';
			case 'component:set':
				return ' '.$this->_getVar('variable').'->__set('.$this->_getVar('name').', '.$this->_getVar('value').') ';
			case 'component:get':
				return ' '.$this->_getVar('variable').'->__get('.$this->_getVar('name').') ';
		}
	} // end _build();
} // end Component;