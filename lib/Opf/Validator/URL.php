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
 * The class represents valid URL.
 * @package Validators
 */
class Opf_Validator_URL implements Opf_Validator_Interface
{
	/**
	 * Constructs the validator object.
	 */
	public function __construct()
	{
	    // null
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
		return 'failed_validation_url';
	} // end getError();

	/**
	 * Returns the data for the error message.
	 * @return array
	 */
	public function getErrorData()
	{
		return array(0 => 'url');
	} // end getErrorData();

	/**
	 * Validates the value in a specified type.
	 *
	 * @param Mixed $value The value to validate.
	 * @return Boolean
	 */
	public function validate(Opf_Item $item, $value)
	{
		if(!is_scalar($value))
		{
			return false;
		}
		return (bool)filter_var($value, FILTER_VALIDATE_URL);
		
	} // end validate();
} // end Opf_Validator_URL;