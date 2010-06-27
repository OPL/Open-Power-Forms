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
 * The class represents maximum string length applied as a rule to a
 * form field.
 * @package Validators
 */
class Opf_Validator_Type implements Opf_Validator_Interface
{
	const INTEGER = 0;
	const FLOAT = 1;
	const NUMBER = 2;
	const STRING = 3;
	const BOOLEAN = 4;
	const DATETIME = 5;

	/**
	 * The type to validate.
	 * @var integer
	 */
	private $_type = 0;

	/**
	 * The list of fields.
	 * @var array
	 */
	private $_fields;

	/**
	 * Constructs maximum length constraint object.
	 *
	 * @param integer $type The type to validate.
	 * @param string|array $fields The fields to validate.
	 */
	public function __construct($type, $fields)
	{
		$this->_maxLength = (int)$length;

		if(is_string($fields))
		{
			$this->_fields = array($fields);
		}
		elseif(is_array($fields))
		{
			$this->_fields = $fields;
		}
		else
		{
			throw new Opf_Validator_Exception('Invalid configuration for Opf_Validator_Email.');
		}
	} // end __construct();

	/**
	 * Validates the value in a specified type.
	 *
	 * @param Opf_Collection $collection The collection to validate
	 * @return Boolean
	 */
	public function validate(Opf_Collection $collection)
	{
		$valid = true;
		foreach($this->_fields as $field)
		{
			$item = $collection->findItem($field);
			$value = $item->getValue();
			if(!$this->_checkType($value))
			{
				$valid = false;
				$item->addErrorMessage('Invalid data type.');
				$item->invalidate();
			}
		}
		return $valid;
	} // end validate();

	/**
	 * Validates the value in a specified type.
	 *
	 * @param mixed $value The value to validate.
	 * @return boolean
	 */
	public function _checkType($value)
	{
		switch($this->_type)
		{
			case self::INTEGER:
				if(ctype_digit($value))
				{
					return true;
				}
				return false;
			case self::FLOAT:
				if(preg_match('/[0-9]+\.[0-9]+/', $value))
				{
					return true;
				}
				return false;
			case self::NUMBER:
				if(preg_match('/[0-9]+(\.[0-9]+)?/', $value))
				{
					return true;
				}
				return false;
			case self::STRING:
				if(!ctype_cntrl($value))
				{
					return true;
				}
				return false;
			case self::BOOLEAN:
				if(is_bool($value) || $value == 'true' || $value == 'false' || $value == 'yes' || $value == 'no')
				{
					return true;
				}
				return false;
			case self::DATETIME:
				return $value instanceof DateTime;
		}
		return false;
	} // end _checkType();
} // end Opf_Validator_Type;
