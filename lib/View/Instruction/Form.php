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

class Opf_View_Instruction_Form extends Opt_Compiler_Processor
{
	protected $_name = 'form';

	/**
	 * The nesting level, used to detect nesting.
	 * @var integer
	 */
	private $_nesting;
	/**
	 * The currently processed form name.
	 * @static
	 * @var string
	 */
	static private $_currentName = null;

	/**
	 * Sets the processed form name.
	 * @param string $name The processed form name.
	 */
	static private function _setProcessedForm($name)
	{
		self::$_currentName = $name;
	} // end _setProcessedForm();

	/**
	 * Returns the currently processed form name.
	 * @return string|null
	 */
	static public function getProcessedForm()
	{
		return self::$_currentName;
	} // end getProcessedForm();

	/**
	 * Configures the OPT instruction processor.
	 */
	public function configure()
	{
		$this->_addInstructions('opf:form');
	} // end configure();

	public function _processForm(Opt_Xml_Node $node)
	{
		$this->_nesting++;

		if($this->_nesting > 1)
		{
			throw new Opt_CannotBeNested_Exception('opf:form', 'nesting withing itself not allowed');
		}

		$params = array(
			'name' => array(0 => self::REQUIRED, self::HARD_STRING),
			'__UNKNOWN__' => array(0 => self::OPTIONAL, self::STRING)
		);
		$extra = $this->_extractAttributes($node, $params);

		$attr = 'array(\'method\' => $_form_'.$params['name'].'->getMethod(), \'action\' => $_form_'.$params['name'].'->getAction(),
			\'class\' => Opf_Design::getClass(\'form\', $_form_'.$params['name'].'->isValid()), ';
		foreach($extra as $name => $value)
		{
			$attr .= ' \''.$name.'\' => '.$value.',';
		}
		$attr .= ')';

		$node->addAfter(Opt_Xml_Buffer::TAG_BEFORE, 'if(Opf_Class::hasForm(\''.$params['name'].'\')){ $_form_'.$params['name'].' = Opf_Class::getForm(\''.$params['name'].'\');
	echo \'<form \'.Opt_Function::buildAttributes('.$attr.').\'><input type="hidden" name="opf_form_info" value="'.$params['name'].'" />\';
	self::$_vars[\'form\'] = $_form_'.$params['name'].';
		');
		$node->addAfter(Opt_Xml_Buffer::TAG_BEFORE, '  ');
		$node->addBefore(Opt_Xml_Buffer::TAG_AFTER,' echo \'</form>\'; self::$_vars[\'form\'] = null; } ');
	
		self::_setProcessedForm($params['name']);

		$this->_compiler->setConversion('##component', '$_form_'.$params['name'].'->_widgetFactory(\'%CLASS%\', \'%TAG%\', %ATTRIBUTES%)');


		$node->set('postprocess', true);
		$this->_process($node);
	} // end _processForm();

	public function _postprocessForm(Opt_Xml_Node $node)
	{
		$this->_nesting--;
		self::_setProcessedForm(null);
	} // end _postprocessForm();

	public function processSystemVar($system)
	{
		switch($system[2])
		{
			case 'valid':
				return '($_form_'.self::getProcessedForm().'->getState() != Opf_Form::ERROR)';
		}
	} // end processSystemVar();
} // end Opf_View_Instruction_Form;