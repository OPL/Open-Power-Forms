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
 * The class represents the type of value.
 */
class Opf_Validator_Type implements Opf_Validator_Interface
{
	const INTEGER = 0;
	const FLOAT = 1;
	const NUMBER = 2;
	const STRING = 3;
	const BOOLEAN = 4;
	
	/**
	 * The represented type.
	 * 
	 * @var Integer 
	 */
	protected $_type;
	
	/**
	 * Constructs the validator object.
	 * 
	 * @param Integer $type The represented type. 
	 */
	public function __construct($type)
	{
		$this->_type = $type;
	} // end __construct();
	
	/**
	 * Returns the type represented by the validator.
	 * @return Integer
	 */
	public function getType()
	{
		return $this->_type;
	} // end getType();

	/**
	 * Validates the value in a specified type.
	 *
	 * @param Mixed $value The value to validate.
	 * @return Boolean
	 */
	public function validate($value)
	{
		if(!is_scalar($value))
		{
			return false;
		}
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
		}
		return false;
	} // end validate();
} // end Opf_Validator_Type;