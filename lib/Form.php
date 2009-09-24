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
	 * The list of internal data passed as HIDDEN fields.
	 * @var array
	 */
	protected $_internals = array();

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
	 * Extendable fluent interface - here, it returns
	 * THIS object, the extending classes may overwrite
	 * it for some other purposes.
	 *
	 * @return Opf_Form
	 */
	public function fluent()
	{
		return $this;
	} // end fluent();

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
			default:
				throw new Opf_UnknownMethod_Exception($method);
				break;
		}
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
	 * Sets the internal value. It may overwrite the existing one.
	 *
	 * @param string $name The name of the internal value.
	 * @param scalar $value The value.
	 * @throws BadMethodCallException
	 */
	public function setInternal($name, $value)
	{
		if(!is_scalar($value))
		{
			throw new BadMethodCallException('The second argument in Opf_Form::setInternal() must be scalar.');
		}
		$this->_internals[(string)$name] = $value;
	} // end setInternal();

	/**
	 * Returns the internal value. If the value does not exist, it
	 * returns NULL.
	 *
	 * @param string $name The internal value name.
	 * @return scalar
	 */
	public function getInternal($name)
	{
		if(!isset($this->_internals[(string)$name]))
		{
			return NULL;
		}
		return $this->_internals[(string)$name];
	} // end getInternal();

	/**
	 * Returns the list of internal values.
	 * @return array
	 */
	public function getInternals()
	{
		return $this->_internals;
	} // end getInternals();

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
	public function getValue()
	{
		$data = array();
		foreach($this->_collection as $name => $item)
		{
			$data[$name] = $item->getValue();
		}
		return $data;
	} // end getValue();

	/**
	 * Sets the form value - populates the form.
	 * @param array $data The form value.
	 */
	public function setValue($data)
	{
		$this->populate($data);
	} // end setValue();

	/**
	 * Populates the form with the initial data.
	 *
	 * @param Array $data The reference to the data array.
	 */
	public function populate(&$data)
	{
		foreach($this->_collection as $name => $item)
		{
			if(isset($data[$name]))
			{
				$item->populate($data[$name]);
			}
		}
	} // end populate();

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
	 * Executes the form. The result is the overall result of the
	 * form processing process.
	 *
	 * @return boolean
	 */
	public function execute()
	{
		$opf = Opl_Registry::get('opf');

		$this->invokeEvent('preInit');
		$this->onInit();
		$this->invokeEvent('postInit');

		// Validate the input data.
		$data = $this->_retrieveData();

		// Decide, if the form has been sent to us.
		if($_SERVER['REQUEST_METHOD'] == $this->_method && isset($data[$opf->formInternalId]))
		{
			// Get the internal data and remove them from the "official" scope.
			$internals = $data[$opf->formInternalId];
			unset($data[$opf->formInternalId]);

			// The names must match.
			if(isset($internals['name']) && $internals['name'] == $this->_name)
			{
				// The form has been sent!
				$state = $this->_validate($data);
				if(!$state)
				{
					$this->_state = self::ERROR;
					$this->populate($data);
					$this->_onRender();
					$this->invokeEvent('preRender');
					$this->onRender();
					$this->invokeEvent('postRender');
					return $this->_state;
				}
				$this->_state = self::ACCEPTED;
				$this->invokeEvent('preAccept');
				$this->onAccept();
				$this->invokeEvent('postAccept');
				return $this->_state;
			}
		}
		
		$this->_state = self::RENDER;
		$this->_onRender();
		$this->invokeEvent('preRender');
		$this->onRender();
		$this->invokeEvent('postRender');
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
	 * This method is used internally by the templates to initialize
	 * statically deployed widgets. It looks for the item that the widget
	 * should be assigned to, creates the widget and assigns to the item.
	 * 
	 * @internal
	 * @param string $className The widget class name
	 * @param string $tagName The component tag name for debug purposes
	 * @param array $attributes The component attribute list
	 * @return Opf_Widget_Component
	 * @throws Opf_AttributeNotDefined_Exception
	 * @throws Opf_ItemNotExists_Exception
	 * @throws Opf_InvalidWidget_Exception
	 */
	public function _widgetFactory($className, $tagName, Array $attributes)
	{
		if(!isset($attributes['name']))
		{
			throw new Opf_AttributeNotDefined_Exception('name', $tagName);
		}
		$item = $this->getItem($attributes['name']);
		if($item === null)
		{
			throw new Opf_ItemNotExists_Exception('item', $attributes['name']);
		}
		if(!$item instanceof Opf_Leaf)
		{
			throw new Opf_InvalidItem_Exception($attributes['name']);
		}
		$widget = new $className();

		if(!$widget instanceof Opf_Widget_Component)
		{
			throw new Opf_InvalidWidget_Exception($className);
		}
		$item->setWidget($widget);
		return $widget;
	} // end _widgetFactory();

	/**
	 * Validates the form fields.
	 * @internal
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
				if($item->getRequired())
				{
					$state = false;
					$item->addErrorMessage('failed_validation_required');
				}
				else
				{
					$item->setValue(null);
				}
			}
			if(!$item->_validate($data[$name]))
			{
				$state = false;
			}
			else
			{
				$item->populate($data[$name]);
			}

		}
		$this->invokeEvent('preValidate');
		$state = $this->_valid = $state && $this->onValidate();
		$this->invokeEvent('postValidate');

		return $state;
	} // end _validate();

	/**
	 * Retrieves the data from the input.
	 * @return &boolean
	 */
	protected function &_retrieveData()
	{
		switch($this->_method)
		{
			case 'POST':
				$data = &$_POST;
				break;
			case 'GET':
				$data = &$_GET;
				break;
		}
		return $data;
	} // end _retrieveData();

	/**
	 * The private rendering utility that performs all the basic
	 * rendering tasks, such as registering the data formats for
	 * the placeholders.
	 *
	 * @internal
	 */
	protected function _onRender()
	{
		$this->setInternal('name', $this->_name);
		foreach($this->_items as $placeholder => &$void)
		{
			$this->_view->setFormat($placeholder, 'Form/Form');
		}
	} // end _onRender();
} // end Opf_Form;
