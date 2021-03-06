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
	 * Is the form executed?
	 * @var boolean
	 */
	protected $_executed = false;

	/**
	 * The returned data.
	 * @var array
	 */
	protected $_data;

	/**
	 * The validators
	 * @var array
	 */
	protected $_validators;

	/**
	 * The rendering form stack
	 * @var SplStack
	 * @static
	 */
	static protected $_stack = null;

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
	 * Clones the form.
	 *
	 * @todo Rewrite to a non-recursive version.
	 */
	public function __clone()
	{
		foreach($this->_items as &$itemList)
		{
			foreach($itemList as $name => $item)
			{
				$itemList[$name] = clone $item;
				$this->_collection[$name] = $itemList[$name];
			}
		}
	} // end __clone();

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
				throw new Opf_Exception('Unknown request method: ' . $method);
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
			throw new Opf_Exception('The second argument in Opf_Form::setInternal() must be scalar.');
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
	 * Returns the fully qualified name of the element.
	 * @return string
	 */
	public function getFullyQualifiedName()
	{
		if($this->_superiorQualifiedName !== null)
		{
			return $this->_superiorQualifiedName;
		}
		if($this->_executed)
		{
			return '';
		}
		if($this->_fullyQualifiedName === '')
		{
			return $this->_name;
		}
		return $this->_fullyQualifiedName.'['.$this->_name.']';
	} // end getFullyQualifiedName();

	/**
	 * Returns the current form state.
	 * @return integer
	 */
	public function getState()
	{
		return $this->_state;
	} // end getState();

	/**
	 * Allows to change the form state from executed to either
	 * render of error.
	 *
	 * @param int $state The new state
	 * @return boolean
	 */
	public function setState($state)
	{
		if($this->_state == self::ACCEPTED)
		{
			$this->_state = (int)$state;
			return true;
		}
		return false;
	} // end setState();

	/**
	 * Adds a new validator to the form.
	 *
	 * @throws Opf_Form_Exception
	 * @param string $name The validator name
	 * @param Opf_Validator_Interface $validator The validator.
	 * @return Opf_Form Fluent interface.
	 */
	public function addValidator($name, Opf_Validator_Interface $validator)
	{
		if(isset($this->_validators[$name]))
		{
			throw new Opf_Form_Exception('The validator with the specified name already exists.');
		}
		$this->_validators[$name] = $validator;

		return $this;
	} // end addValidator();

	/**
	 * Returns the specified validator.
	 *
	 * @throws Opf_Form_Exception
	 * @param string $name Validator name.
	 * @return array
	 */
	public function getValidator($name)
	{
		if(!isset($this->_validators[$name]))
		{
			throw new Opf_Form_Exception('The validator with the specified name does not exists.');
		}
		return $this->_validators[$name];
	} // end getValidator();

	/**
	 * Checks if the specified validator exists.
	 *
	 * @param string $name Validator name.
	 * @return boolean
	 */
	public function hasValidator($name)
	{
		return isset($this->_validators[$name]);
	} // end hasValidator();

	/**
	 * Removes the validator.
	 *
	 * @throws Opf_Form_Exception
	 * @param string $name Validator name.
	 */
	public function removeValidator($name)
	{
		if(!isset($this->_validators[$name]))
		{
			throw new Opf_Form_Exception('The validator with the specified name does not exists.');
		}
		unset($this->_validators[$name]);
	} // end removeValidator();

	/**
	 * Returns an item to be displayed by the view. Despite the standard
	 * search procedure, it performs some extra actions connected with displaying
	 * the item.
	 *
	 * @internal
	 * @param string $item The item name
	 * @return Opf_Item
	 */
	public function getItemDisplay($item)
	{
		$item = $this->getItem($item);
		$item->setFullyQualifiedName($this->getFullyQualifiedName());
		return $item;
	} // end getItemDisplay();

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
	 * @param array $data The reference to the data array.
	 */
	public function populate($data)
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
		foreach($this->_collection as $item)
		{
			if($item instanceof Opf_Form || $item instanceof Opf_Repeater)
			{
				$item->onInit();
			}
		}
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
		$this->_executed = true;
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
					return $this->_state;
				}
				$this->_data = $data;
				$this->_state = self::ACCEPTED;
				$this->invokeEvent('preAccept');
				$this->onAccept();
				$this->invokeEvent('postAccept');
				$this->clear();
				return $this->_state;
			}
		}
		
		$this->_state = self::RENDER;

		return $this->_state;
	} // end execute();

	/**
	 * Clears populated data.
	 */
	public function clear()
	{
		foreach($this->_collection as $name => $item)
		{
			$item->populate('');
		}
	} // end clear();

	/**
	 * Renders the view.
	 *
	 * @throws Opf_Exception
	 */
	public function render()
	{
	/*	if($this->_state != self::RENDER && $this->_state != self::ERROR)
		{
			throw new Opf_Exception('Cannot render the specified view: invalid state.');
		}
	 */
		$this->_onRender($this->_view);
		$this->invokeEvent('preRender');
		$this->onRender();
		$this->invokeEvent('postRender');
	} // end render();

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
			throw new Opf_Exception('Attribute "name" not defined in ' . $tagName);
		}
		$item = $this->getItem($attributes['name']);
		if($item === null)
		{
			throw new Opf_Exception('Item ' . $attributes['name'] . ' not exist.');
		}
	/*	if(!$item instanceof Opf_Leaf)
		{
			throw new Opf_InvalidItem_Exception($attributes['name']);
		}*/
		if($item->hasWidget())
		{
			$widget = $item->getWidget();

			if(!$widget instanceof Opf_Widget_Generic)
			{

				if(!is_a($widget, $className))
				{
					throw new Opf_Exception('Widget ' . $className . ' is invalid');
				}

				$item->setFullyQualifiedName($this->getFullyQualifiedName());
				return $widget;
			}
		}

		$widget = new $className();

		if(!$widget instanceof Opf_Widget_Component)
		{
			throw new Opf_Exception('Widget ' . $className . ' is invalid');
		}
		$item->setWidget($widget);
		$item->setFullyQualifiedName($this->getFullyQualifiedName());
		return $widget;
	} // end _widgetFactory();

	/**
	 * Validates the form fields.
	 * @internal
	 * @param array $data The form data.
	 */
	protected function _validate(&$data, Opf_Item $errorClass = null)
	{
		$valid = true;
		$this->invokeEvent('preValidate');
		// Check what fields are required.
		foreach($this->_collection as $item)
		{
			$name = $item->getName();
			if(empty($data[$name]) and (isset($data[$name]) and $data[$name] != '0' and is_scalar($data[$name])))
			{
				if($item->getRequired())
				{
					$valid = false;
					$item->addErrorMessage('failed_validation_required');
				}
				else
				{
					$item->setValue(null);
				}
			}
			else
			{
				$item->setValue($data[$name]);
			}
		}

		// Apply the validators
		foreach($this->_validators as $item)
		{
			if(!$item->validate($this))
			{
				$valid = false;
			}
		}
		$this->invokeEvent('postValidate');
		return $this->_valid = $valid;
	} // end _validate();

	/**
	 * Retrieves the data from the input.
	 * @return &boolean
	 */
	protected function _retrieveData()
	{
		switch($this->_method)
		{
			case 'POST':
				$data = $_POST;
				break;
			case 'GET':
				$data = $_GET;
				break;
		}
		return $data;
	} // end _retrieveData();

	/**
	 * The private rendering utility that performs all the basic
	 * rendering tasks, such as registering the data formats for
	 * the placeholders.
	 *
	 * @param Opt_View $view The view the form is rendered in.
	 * @internal
	 */
	protected function _onRender(Opt_View $view)
	{
		$this->setInternal('name', $this->_name);
		foreach($this->_items as $placeholder => &$void)
		{
			$view->setFormat($placeholder, 'Form/Form');
		}
		foreach($this->_collection as $item)
		{
			$item->_onRender($view);
		}
	} // end _onRender();

	/**
	 * Pushes the specified form into the stack.
	 *
	 * @internal
	 * @static
	 * @param Opf_Form $form The form pushed to the stack.
	 */
	static public function pushToStack(Opf_Form $form)
	{
		if(self::$_stack === null)
		{
			self::$_stack = new SplStack();
		}
		self::$_stack->push($form);
	} // end pushToStack();

	/**
	 * Pops the form from a stack. If the stack is empty, the method
	 * throws an exception.
	 *
	 * @internal
	 * @static
	 * @param Opf_Form $form The form to be popped.
	 * @return Opf_Form
	 */
	static public function popFromStack(Opf_Form $form)
	{
		if(self::$_stack === null)
		{
			self::$_stack = new SplStack();
		}
		$element = self::$_stack->pop();
		if($element !== $form)
		{
			throw new Opf_Exception('Invalid form ' . $form -> getName() . ' on stack ' . $element->getName());
		}
		return $element;
	} // end popFromStack();

	/**
	 * Returns the form stack head element. If the stack is empty,
	 * the method returns NULL.
	 *
	 * @internal
	 * @static
	 * @return Opf_Form
	 */
	static public function topOfStack()
	{
		if(self::$_stack === null)
		{
			self::$_stack = new SplStack();
		}
		if(self::$_stack->count() == 0)
		{
			return null;
		}
		return self::$_stack->top();
	} // end topOfStack();
} // end Opf_Form;
