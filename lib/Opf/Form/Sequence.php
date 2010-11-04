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

namespace Opf\Form;

use Opf\Item\AbstractItem;
use Opf\Tracker\TrackerInterface;
use Opf\Exception;
 
class Sequence extends Form
{
	/**
	 * The placeholder used to retrieve the forms.
	 * @var string
	 */
	private $_placeholder = 'default';

	/**
	 * The tracker used to track the data between
	 * the sequence steps.
	 * @var Opf\Tracker\TrackerInterface
	 */
	private $_tracker = null;

	/**
	 * The currently analyzed sub-form
	 * @var Opf\Form\Form
	 */
	private $_current = null;

	/**
	 * The current step number.
	 * @var integer
	 */
	private $_step = 0;

	/**
	 * Returns the currently processed subform.
	 *
	 * @return Opf\Form\Form
	 */
	public function fluent()
	{
		return $this->_current;
	} // end fluent();

	/**
	 * Sets the new placeholder that the forms are read from
	 * when resolving the steps.
	 * @param string $placeholder The placeholder name
	 */
	public function setPlaceholder($placeholder)
	{
		$this->_placeholder = (string)$placeholder;
		
		// Reset the array to ensure that we begin the iteration from the beginning.
		if(isset($this->_items[$this->_placeholder]))
		{
			reset($this->_items[$this->_placeholder]);
		}
	} // end setPlaceholder();

	/**
	 * Returns the current placeholder.
	 * @return string
	 */
	public function getPlaceholder()
	{
		return $this->_placeholder;
	} // end getPlaceholder();

	/**
	 * Sets the new data tracker for this sequence.
	 * @param Opf\Tracker\TrackerInterface $tracker The new tracker
	 */
	public function setTracker(TrackerInterface $tracker)
	{
		$this->_tracker = $tracker;
	} // end setTracker();

	/**
	 * Returns the concatenated values of all the sub-forms.
	 * @return array
	 */
	public function getValue()
	{
		$data = array();
		foreach($this->_collection as $subform)
		{
			foreach($subform->_collection as $name => $item)
			{
				$data[$name] = $item->getValue();
			}
		}
		return $data;
	} // end getValue();

	/**
	 * Returns the current tracker. If the tracker is not set yet,
	 * it attempts to create a new default tracker.
	 * @return Opf\Tracker\TrackerInterface
	 * @throws Opf\InvalidObjectTypeException
	 */
	public function getTracker()
	{
		if($this->_tracker === null)
		{
			$className = $this->_core->defaultTracker;
			$tracker = new $className;
			if(!$tracker instanceof TrackerInterface)
			{
				throw new Exception('Invalid object type('.get_class($tracker).'), should be Opf\Tracker\TrackerInterface');
			}
			$this->_tracker = $tracker;
		}
		return $this->_tracker;
	} // end getTracker();

	/**
	 * Returns the current sub-form in a sequence and advances the internal pointer.
	 *
	 * @return Opf\Form\Form
	 */
	public function getNextSubform()
	{
		$this->_current = current($this->_items[$this->_placeholder]);
		next($this->_items[$this->_placeholder]);

		if(is_object($this->_current))
		{
			$this->_current->setView($this->_view);
			$this->_current->invokeEvent('preInit');
			$this->_current->onInit();
			$this->_current->invokeEvent('postInit');
		}
		return $this->_current;
	} // end getNextSubform();

	/**
	 * Recognizes the form types and does not allow to append any other item
	 * types to it.
	 * @param Opf\Item\AbstractItem $item The item to test.
	 * @param string $placeholder The optional placeholder.
	 * @return boolean
	 */
	protected function _isItemAllowed(AbstractItem $item, $placeholder = 'default')
	{
		return ($item instanceof Form);
	} // end _isItemAllowed();

	/**
	 * Executes the form sequence.
	 */
	public function execute()
	{
		$this->invokeEvent('preInit');
		$this->onInit();
		$this->invokeEvent('postInit');

		// Validate the input data.
		$data = $this->_retrieveData();

		// Decide, if the form has been sent to us.
		if($_SERVER['REQUEST_METHOD'] == $this->_method && isset($data[$this->_core->formInternalId]))
		{
			// Get the internal data and remove them from the "official" scope.
			$internals = $data[$this->_core->formInternalId];
			unset($data[$this->_core->formInternalId]);

			// The names must match.
			if(isset($internals['name']) && $internals['name'] == $this->_name)
			{
				$this->_step = 0;
				if(isset($internals['step']))
				{
					$this->_step = (integer)$internals['step'];
				}
				$tracker = $this->getTracker();
				$tracker->setSequence($this);
				$current = 0;
				while($current < $this->_step)
				{
					// Get the current form and advance the placeholder pointer.
					$form = $this->getNextSubform();

					// Attempt to ensure that the tracked data are still valid.
					$formData = $tracker->retrieve($internals, $current);
					$current++;

					$state = $form->_validate($formData);
					if(!$state)
					{
						$this->_step = $current;
						$this->_state = $form->_state = self::ERROR;
						$form->populate($data);
						$form->_onRender($this->_view);
						$this->_onRender($this->_view);
						$this->invokeEvent('preRender');
						$form->invokeEvent('preRender');
						$form->onRender();
						$form->invokeEvent('postRender');
						$this->invokeEvent('postRender');
						return $this->_state;
					}
				}
				$form = $this->getNextSubform();
				// Now, the currently displayed form.
				$state = $form->_validate($data);
				if(!$state)
				{
					$this->_state = $form->_state = self::ERROR;
					$form->populate($data);
					$form->_onRender($this->_view);
					$form->invokeEvent('preRender');
					$form->onRender();
					$form->invokeEvent('postRender');
					return $this->_state;
				}
				else
				{
					$tracker->track($data, $current);
					$form->_state = self::ACCEPTED;
				}
				// Decide, what to do next: display another form or return
				$this->_step++;
				if(($form = $this->getNextSubform()) === false)
				{
					$this->_state = self::ACCEPTED;
					$this->invokeEvent('preAccept');
					$this->onAccept();
					$this->invokeEvent('postAccept');
					return $this->_state;
				}
				else
				{
					$this->_state = $form->_state = self::RENDER;
					$form->_onRender($this->_view);
					$this->_onRender($this->_view);
					$form->invokeEvent('preRender');
					$form->onRender();
					$form->invokeEvent('postRender');
					return $this->_state;
				}
			}
		}
		$form = $this->getNextSubform();
		$this->_state = $form->_state = self::RENDER;
		$form->_onRender($this->_view);
		$this->_onRender($this->_view);
		$form->invokeEvent('preRender');
		$form->onRender();
		$form->invokeEvent('postRender');
		return $this->_state;
	} // end execute();

	/**
	 * The private rendering utility - it does nothing.
	 *
	 * @internal
	 */
	protected function _onRender(\Opt_View $view)
	{
		$this->setInternal('name', $this->_name);
		$this->setInternal('step', $this->_step);
	} // end _onRender();
} // end Sequence;
