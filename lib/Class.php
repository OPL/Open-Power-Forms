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
 * The validator interface.
 */
interface Opf_Validator_Interface
{
	public function validate($value);
} // end Opf_Validator_Interface;

/**
 * The main Open Power Forms class that manages the configuration, plugins, etc.
 */
class Opf_Class extends Opl_Class
{
	/**
	 * Creates a new instance of OPF.
	 * @throws Opf_OptNotInitialized_Exception
	 */
	public function __construct()
	{
		Opl_Registry::register('opf', $this);
		
		if(!Opl_Registry::exists('opt'))
		{
			throw new Opf_OptNotInitialized_Exception();
		}
		$tpl = Opl_Registry::get('opt');
		$tpl->register(Opt_Class::OPT_NAMESPACE, 'opf');
		$tpl->register(Opt_Class::OPT_INSTRUCTION, 'Form', 'Opf_View_Instruction_Form');
		$tpl->register(Opt_Class::OPT_FORMAT, 'Form', 'Opf_View_Format_Form');
	} // end __construct();


	/**
	 * The list of forms available for the templates.
	 * @var array
	 */
	static private $_forms = array();

	/**
	 * Adds a form to the list of forms to make it available for the
	 * templates. You do not have to use this method manually, as the
	 * forms register themselves in templates automatically.
	 *
	 * @static
	 * @param Opf_Form $form The form to register.
	 * @throws Opf_ItemAlreadyExists_Exception
	 */
	static public function addForm(Opf_Form $form)
	{
		if(isset(self::$_forms[$form->getName()]))
		{
			throw new Opf_ItemAlreadyExists_Exception('form', $form->getName());
		}

		self::$_forms[$form->getName()] = $form;
	} // end addForm();

	/**
	 * Returns true, if there exists a form with the specified name.
	 * @static
	 * @param string $name The form name
	 * @return boolean
	 */
	static public function hasForm($name)
	{
		return isset(self::$_forms[(string)$name]);
	} // end hasForm();

	/**
	 * Returns a form registered in the main class.
	 *
	 * @static
	 * @param string $name The form name
	 * @return Opf_Collection
	 * @throws Opf_ItemNotExists_Exception
	 */
	static public function getForm($name)
	{
		if(!isset(self::$_forms[(string)$name]))
		{
			throw new Opf_ItemNotExists_Exception('form', $form->getName());
		}

		return self::$_forms[(string)$name];
	} // end getForm();
} // end Opf_Class;