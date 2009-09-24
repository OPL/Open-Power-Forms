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
 * $Id: Class.php 227 2009-09-03 20:44:43Z megawebmaster $
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
	 * Tracks the data to the
	 * @param <type> $data
	 * @param <type> $step
	 */
	public function track(&$data, $step)
	{
		$this->_data[$step] = $data;
		$this->_sequence->setInternal('sequence', serialize($this->_data));
		$this->_sequence = null;
	} // end track();

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