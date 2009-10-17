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
 * The class represents the scope of the integer field.
 * @package Validators
 */
class Opf_Validator_Scope implements Opf_Validator_Interface
{
	/**
	 * The minimum range.
	 * @var integer
	 */
	private $_minimum = 0;
	/**
	 * The maximum range.
	 * @var integer
	 */
	private $_maximum = 0;

	/**
	 * Constructs the scope constraint object.
	 *
	 * @param integer $min The minimum range
	 * @param integer $max The maximum range
	 */
	public function __construct($min, $max)
	{
		$this->_minimum = (integer)$min;
		$this->_maximum = (integer)$max;
	} // end __construct();

	/**
	 * Sets a custom error message for the validator.
	 * @param string $customError The custom error message.
	 * @todo implement
	 */
	public function setCustomError($customError)
	{

	} // end setCustomError();

	/**
	 * Returns the error message used, if the validator fails.
	 * @return string
	 */
	public function getError()
	{
		return 'failed_validation_scope';
	} // end getError();

	/**
	 * Returns the data for the error message.
	 * @return array
	 */
	public function getErrorData()
	{
		return array(0 => $this->_minimum, $this->_maximum);
	} // end getErrorData();

	/**
	 * Validates the value length.
	 * @param mixed $value The value to validate.
	 * @return boolean
	 */
	public function validate(Opf_Item $item, $value)
	{
		$value = (integer)$value;
		return ($this->_minimum < $value && $value < $this->_maximum);
	} // end validate();
} // end Opf_Validator_Scope;