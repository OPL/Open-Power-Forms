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

namespace Opf;

use Opf\Form\Form;
use Opf\Exception;

/**
 * The main Open Power Forms class that manages the configuration, plugins, etc.
 */
class Core extends \Opl_Class
{
	const ENABLED = 2;
	const DETECT = 1;
	const DISABLED = 0;

	// The configuration
	public $translationGroup = 'form';
	public $defaultTracker = 'Opf\Tracker\Client';
	public $formInternalId = 'opf';

	public $useWebforms2 = self::DISABLED;

	/**
	 * Translation interface
	 * @var Opl_Translation_Interface
	 */
	protected $_tf;

	/**
	 * The list of forms available for the templates.
	 * @static
	 * @var array
	 */
	static private $_forms = array();


	/**
	 * Creates a new instance of OPF.
	 *
	 * @param Opt_Class $opt Open Power Template instance.
	 */
	public function __construct(\Opt_Class $opt)
	{
		\Opl_Registry::set('opf', $this);

		$opt->register(\Opt_Class::OPT_NAMESPACE, 'opf');
		$opt->register(\Opt_Class::OPT_INSTRUCTION, 'Form', 'Opf\View\Instruction\Form');
		$opt->register(\Opt_Class::OPT_FORMAT, 'Form', 'Opf\View\Format\Form');
		$opt->register(\Opt_Class::OPT_FORMAT, 'Design', 'Opf\View\Format\Design');
		$opt->register(\Opt_Class::OPT_FORMAT, 'FormRepeater', 'Opf\View\Format\FormRepeater');

		$opt->register(\Opt_Class::OPT_COMPONENT, 'opf:input', 'Opf\Widget\Input');
		$opt->register(\Opt_Class::OPT_COMPONENT, 'opf:password', 'Opf\Widget\Password');
		$opt->register(\Opt_Class::OPT_COMPONENT, 'opf:yesno', 'Opf\Widget\Yesno');
		$opt->register(\Opt_Class::OPT_COMPONENT, 'opf:select', 'Opf\Widget\Select');
		$opt->register(\Opt_Class::OPT_COMPONENT, 'opf:collection', 'Opf\Widget\Collection');

		\Opt_View::setFormatGlobal('design', 'Design', false);
	} // end __construct();

	/**
	 * Sets the translation interface. When called without arguments,
	 * it resets the existing interface.
	 *
	 * @param Opl_Translation_Interface $tf The new translation interface.
	 */
	public function setTranslationInterface(\Opl_Translation_Interface $tf = null)
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
	 * Adds a form to the list of forms to make it available for the
	 * templates. You do not have to use this method manually, as the
	 * forms register themselves in templates automatically.
	 *
	 * @static
	 * @param Opf\Form\Form $form The form to register.
	 * @throws Opf\Item\ItemAlreadyExistsException
	 */
	static public function addForm(Form $form)
	{
		if(isset(self::$_forms[$form->getName()]))
		{
			throw new Exception('Form '.$form->getName().' already exist.');
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
	 * @return Opf\Item\Collection
	 * @throws Opf\Item\ItemNotExistsException
	 */
	static public function getForm($name)
	{
		if(!isset(self::$_forms[(string)$name]))
		{
			throw new Exception('Form '.$name.' does not exist');
		}

		return self::$_forms[(string)$name];
	} // end getForm();
} // end Core;
