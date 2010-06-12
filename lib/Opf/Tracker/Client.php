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
 * $Id: Client.php -1   $
 */

/**
 * This tracker passes the data of multi-step forms in hidden fields
 * of the HTML form.
 */
class Opf_Tracker_Client implements Opf_Tracker_Interface
{
	/**
	 * The processed sequence
	 * @var Opf_Form_Sequence
	 */
	protected $_sequence;

	/**
	 * The data buffer.
	 * @var array
	 */
	protected $_data;

	/**
	 * Sets the currently processed sequence.
	 * @param Opf_Form_Sequence $form The processed sequence
	 */
	public function setSequence(Opf_Form_Sequence $form)
	{
		$this->_data = null;
		$this->_sequence = $form;
	} // end setSequence();

	/**
	 * Adds the new data to the tracker from the specified step
	 * and serializes everything to the form internal data.
	 *
	 * @param array $data The data of the next step.
	 * @param integer $step The step number.
	 */
	public function track(&$data, $step)
	{
		$this->_data[$step] = $data;
		$this->_sequence->setInternal('sequence', serialize($this->_data));
		$this->_sequence = null;
	} // end track();

	/**
	 * Retrieves the data of the specified step back to the form
	 * processor and unserializes the buffer, if it has not been
	 * done yet.
	 * 
	 * @param array $data The reference to the internal data sent with the form.
	 * @param integer $step The step number.
	 * @return array
	 */
	public function retrieve(&$data, $step)
	{
		if($this->_data == null)
		{
			if(!isset($data['sequence']))
			{
				$this->_data = array();
			}
			else
			{
				$this->_data = unserialize($data['sequence']);
			}
		}
		if(isset($this->_data[$step]))
		{
			return $this->_data[$step];
		}
		return array();
	} // end retrieve();
} // end Opf_Tracker_Client;