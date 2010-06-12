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
 */

/**
 * The class represents the string length applied as a rule to a
 * form field.
 * @package Validators
 */
class Opf_Validator_Length implements Opf_Validator_Interface
{
	/**
	 * The length represented by the validator.
	 * @var integer
	 */
	private $_length = 0;

	/**
	 * Constructs the length constraint object.
	 *
	 * @param integer $length The string length
	 */
	public function __construct($length)
	{
		$this->_length = (int)$length;
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
		return 'failed_validation_length';
	} // end getError();

	/**
	 * Returns the data for the error message.
	 * @return array
	 */
	public function getErrorData()
	{
		return array(0 => $this->_length);
	} // end getErrorData();

	/**
	 * Validates the value length.
	 * @param mixed $value The value to validate.
	 * @return boolean
	 */
	public function validate(Opf_Item $item, $value)
	{
		return (strlen($value) == $this->_length);
	} // end validate();
} // end Opf_Validator_Length;