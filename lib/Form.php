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
 * Represents a form. Because forms are treated as items, they can
 * be parts of other forms.
 */
class Opf_Form extends Opf_Collection
{
	const POST = 0;
	const GET = 1;

	const RENDER = 0;
	const ERROR = 1;
	const ACCEPTED = 2;

	/**
	 * The view used to render the form.
	 * @var Opt_View
	 */
	protected $_view = null;

	/**
	 * The sending method
	 * @var string
	 */
	protected $_method = 'POST';

	/**
	 * The form action
	 * @var string
	 */
	protected $_action = '';

	/**
	 * The form state
	 * @var integer
	 */
	protected $_state = 0;

	/**
	 * The form data.
	 * @var array
	 */
	protected $_data = array();

	/**
	 * Initializes the form processor.
	 *
	 * @param String $name The form name.
	 */
	public function __construct($name)
	{
		$this->_name = $name;

		Opf_Class::addForm($this);
	} // end __construct();

	/**
	 * Sets the form view.
	 *
	 * @param Opt_View $view
	 */
	public function setView(Opt_View $view)
	{
		$this->_view = $view;
	} // end setView();

	/**
	 * Returns the form view.
	 * @return Opt_View
	 */
	public function getView()
	{
		return $this->_view;
	} // end getView();

	/**
	 * Sets the form method.
	 * @param integer $method The new method.
	 * @throws Opf_UnknownMethod_Exception
	 */
	public function setMethod($method)
	{
		switch($method)
		{
			case self::POST:
				$this->_method = 'POST';
				break;
			case self::GET:
				$this->_method = 'GET';
				break;
		}
		throw new Opf_UnknownMethod_Exception($method);
	} // end setMethod();

	/**
	 * Returns the string representation of the currently used method.
	 * @return string
	 */
	public function getMethod()
	{
		return $this->_method;
	} // end getMethod();

	/**
	 * Sets the form action (where the form is sent).
	 * @param string $action The new action
	 */
	public function setAction($action)
	{
		$this->_action = (string)$action;
	} // end setAction();

	/**
	 * Returns the current action.
	 * @return string
	 */
	public function getAction()
	{
		return $this->_action;
	} // end getAction();

	/**
	 * Returns the current form state.
	 * @return integer
	 */
	public function getState()
	{
		return $this->_state;
	} // end getState();

	/**
	 * Returns the values entered to the form as an array.
	 *
	 * @return array
	 */
	public function getValues()
	{
		return $this->_data;
	} // end getValues();

	/**
	 * The method for user implementation called at the beginning of execution.
	 * It can be used to configure the form.
	 */
	public function onInit()
	{
		/* null */
	} // end onInit();

	/**
	 * The method called after the validation. It can be used to specify the custom
	 * validation routines.
	 * @return boolean
	 */
	public function onValidate()
	{
		return true;
	} // end onValidate();

	/**
	 * The method for user implementation called before the form rendering.
	 */
	public function onRender()
	{
		/* null */
	} // end onRender();

	/**
	 * The method for user implementation called, if the form has been correctly
	 * filled.
	 */
	public function onAccept()
	{
		/* null */
	} // end onAccept();

	/**
	 * Populates the form with the initial data.
	 *
	 * @param Array $data The reference to the data array.
	 */
	public function populate(&$data)
	{
		foreach($this->_items as $id => $value)
		{
			if(isset($data[$value->_name]))
			{
				$item->populate($data[$value->_name]);
			}
		}
	} // end populate();

	/**
	 * Executes the form. The result is the overall result of the
	 * form processing process.
	 *
	 * @return boolean
	 */
	public function execute()
	{
		$this->onInit();

		// Validate the input data.
		switch($this->_method)
		{
			case 'POST':
				$data = &$_POST;
				break;
			case 'GET':
				$data = $_GET;
				break;
		}
		// Decide, if the form has been sent to us.
		if($_SERVER['REQUEST_METHOD'] == $this->_method && isset($data['opf_form_info']) && $data['opf_form_info'] == $this->_name)
		{
			// The form has been sent!
			$state = $this->_validate($data);
			if(!$state)
			{
				$this->_state = self::ERROR;
				$this->onRender();
				return $this->_state;
			}
			$this->_state = self::ACCEPTED;
			$this->onAccept();
			return $this->_state;
		}
		
		$this->_state = self::RENDER;
		$this->onRender();
		return $this->_state;
	} // end execute();

	/**
	 * Constructs a new iem object. The method allows to use the
	 * global list of item definitions, so that they could be
	 * reused between many projects. If the item already exists
	 * in the form, the existing object is returned.
	 * 
	 * @param string $name The item name.
	 * @param string $placeholder The item placeholder.
	 * @return Opf_Leaf
	 */
	public function itemFactory($name, $placeholder = 'default')
	{
		if(($item = $this->getItem($name)) !== null)
		{
			return $item;
		}
		$item = new Opf_Leaf($name);
		$this->appendItem($item, $placeholder);

		return $item;
	} // end itemFactory();

	/**
	 * Validates the form fields.
	 * @param array $data The form data.
	 */
	protected function _validate(&$data)
	{
		$state = true;
		foreach($this->_collection as $item)
		{
			$name = $item->getName();
			if(empty($data[$name]))
			{
				if(!$item->getRequired())
				{
					$state = false;
				}
				else
				{
					$this->_data[$name] = null;
				}
			}
			if(!$item->_validate($data[$name]))
			{
				$state = false;
			}
			else
			{
				$this->_data[$name] = &$data[$name];
			}

		}
		return $this->_valid = $state && $this->onValidate();
	} // end _validate();
} // end Opf_Form;
