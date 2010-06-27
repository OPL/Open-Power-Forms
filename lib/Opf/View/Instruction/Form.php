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

class Opf_View_Instruction_Form extends Opt_Instruction_Abstract
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

	/**
	 * Processes the opt:form XML node.
	 *
	 * @param Opt_Xml_Node $node The recognized node.
	 */
	public function _processForm(Opt_Xml_Node $node)
	{
		$this->_nesting++;

		$params = array(
			'name' => array(0 => self::OPTIONAL, self::EXPRESSION, null),
			'from' => array(0 => self::OPTIONAL, self::EXPRESSION, null),
			'__UNKNOWN__' => array(0 => self::OPTIONAL, self::STRING)
		);
		$extra = $this->_extractAttributes($node, $params);

		if((!isset($params['name']) && !isset($params['from'])) || (isset($params['name']) && isset($params['from'])))
		{
			throw new Opf_Exception('Attributes "name" or "from" are not defined.');
		}

		$attr = 'array(\'method\' => $_form->getMethod(), \'action\' => $_form->getAction(),
			\'class\' => Opf_Design::getClass(\'form\', $_form->isValid()), ';
		foreach($extra as $name => $value)
		{
			$attr .= ' \''.$name.'\' => '.$value.',';
		}
		$attr .= ')';

		$opf = Opl_Registry::get('opf');

		$node->addAfter(Opt_Xml_Buffer::TAG_BEFORE, 'if(($_formy = Opf_Form::topOfStack()) === null)
{
	if(Opf_Class::hasForm('.$params['name'].'))
	{
		$_formx = Opf_Class::getForm('.$params['name'].');
		$_form = $_formx->fluent();
		Opf_Form::pushToStack($_form);
		echo \'<form \'.Opt_Function::buildAttributes('.$attr.').\'>\'; 
	}
}
else
{
	$_formx = '.(isset($params['from']) ? $params['from'] : '$_formy->getItemDisplay('.$params['name'].')').';
	$_form = $_formx->fluent();
	if(!$_form instanceof Opf_Form)
	{
		throw new Opf_Exception(\'Invalid form object type(\'.get_class($_formx).\'), should be Opf_Form\');
	}
	Opf_Form::pushToStack($_form);
}

if(isset($_form))
{
	foreach($_formx->getInternals() as $n => $v){ echo \'<input type="hidden" name="'.$opf->formInternalId.'[\'.$n.\']" value="\'.htmlspecialchars($v).\'" />\'; }
	self::$_vars[\'form\'] = $_form;
');
		$node->addBefore(Opt_Xml_Buffer::TAG_AFTER,' Opf_Form::popFromStack($_form);
	if((self::$_vars[\'form\'] = $_form = Opf_Form::topOfStack()) === null)
	{
		echo \'</form>\';
	}
}');
		self::_setProcessedForm($params['name']);

		$this->_compiler->setConversion('##component', '$_form->_widgetFactory(\'%CLASS%\', \'%TAG%\', %ATTRIBUTES%)');
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
				return '($_form->getState() != Opf_Form::ERROR)';
		}
	} // end processSystemVar();
} // end Opf_View_Instruction_Form;