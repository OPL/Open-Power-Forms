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

class Opf_Form_Sequence extends Opf_Form
{
	/**
	 * The placeholder used to retrieve the forms.
	 * @var string
	 */
	private $_placeholder = 'default';

	/**
	 * The tracker used to track the data between
	 * the sequence steps.
	 * @var Opf_Tracker_Interface
	 */
	private $_tracker = null;

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
	 * @param Opf_Tracker_Interface $tracker The new tracker
	 */
	public function setTracker(Opf_Tracker_Interface $tracker)
	{
		$this->_tracker = $tracker;
	} // end setTracker();

	/**
	 * Returns the current tracker. If the tracker is not set yet,
	 * it attempts to create a new default tracker.
	 * @return Opf_Tracker_Interface
	 * @throws Opf_InvalidObjectType_Exception
	 */
	public function getTracker()
	{
		if($this->_tracker === null)
		{
			$opf = Opl_Registry::get('opf');
			$className = $opf->defaultTracker;
			$class = new $className;
			if(!$class instanceof Opf_Tracker_Interface)
			{
				throw new Opf_InvalidObjectType_Exception(get_class($class), 'Opf_Tracker_Interface');
			}
			$this->_tracker = $tracker;
		}
		return $this->_tracker;
	} // end getTracker();

	/**
	 * Recognizes the form types and does not allow to append any other item
	 * types to it.
	 * @param Opf_Item $item The item to test.
	 * @param string $placeholder The optional placeholder.
	 * @return boolean
	 */
	protected function _isItemAllowed(Opf_Item $item, $placeholder = 'default')
	{
		return ($item instanceof Opf_Form);
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
		if($_SERVER['REQUEST_METHOD'] == $this->_method && isset($data['opf_form_info']) && $data['opf_form_info'] == $this->_name)
		{
			$step = 0;
			if(isset($data['opf_step']))
			{
				$step = $data['opf_step'];
			}
			$tracker = $this->getTracker();
			$current = 0;
			while($current <= $step)
			{
				// Get the current form and advance the placeholder pointer.
				$form = current($this->_items[$this->_placeholder]);
				next($this->_items[$this->_placeholder]);

				// Attempt to ensure that the tracked data are still valid.
				$formData = $tracker->retrieve($data, $current);




				$current++;
			}
			
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

		$this->_state = self::RENDER;
		$this->_onRender();
		$this->invokeEvent('preRender');
		$this->onRender();
		$this->invokeEvent('postRender');
		return $this->_state;
	} // end execute();

} // end Opf_Form_Sequence;