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
	public function getError();
	public function getErrorData();
	public function validate(Opf_Item $item, $value);
} // end Opf_Validator_Interface;

/**
 * The main Open Power Forms class that manages the configuration, plugins, etc.
 */
class Opf_Class extends Opl_Class
{
	// The configuration
	public $translationGroup = 'form';

	/**
	 * Translation interface
	 * @var Opl_Translation_Interface
	 */
	protected $_tf;

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

		$tpl->register(Opt_Class::OPT_COMPONENT, 'opf:input', 'Opf_Widget_Input');
		$tpl->register(Opt_Class::OPT_COMPONENT, 'opf:select', 'Opf_Widget_Select');
	} // end __construct();

	/**
	 * Sets the translation interface. When called without arguments,
	 * it resets the existing interface.
	 *
	 * @param Opl_Translation_Interface $tf The new translation interface.
	 */
	public function setTranslationInterface(Opl_Translation_Interface $tf = null)
	{
		$this->_tf = $tf;
	} // end setTranslationInterface();

	/**
	 * Returns the current translation interface registered in OPF.
	 * @return Opl_Translation_Interface
	 */
	public function getTranslationInterface()
	{
		return $this->_tf;
	} // end getTranslationInterface();


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

/**
 * Represents an event in the event handling.
 */
class Opf_Event
{
	/**
	 * The item the event is called for.
	 * @var Opf_Item
	 */
	private $_item;

	/**
	 * The event name
	 * @var string
	 */
	private $_name;

	/**
	 * Constructs an event object.
	 * @param Opf_Item $item The item the event is called for.
	 * @param string $eventName The event name
	 */
	public function __construct(Opf_Item $item, $eventName)
	{
		$this->_item = $item;
		$this->_eventName = $eventName;
	} // end __construct();

	/**
	 * Returns the item the event is called for.
	 * @return Opf_Item
	 */
	public function getItem()
	{
		return $this->_item;
	} // end getItem();

	/**
	 * Returns the event name.
	 * @return string
	 */
	public function getEvent()
	{
		return $this->_name;
	} // end getEvent();
} // end Opf_Event;