<?php
/*
 *  OPEN POWER LIBS <http://www.invenzzia.org>
 *
 * This file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. It is also available through
 * WWW at this URL: <http://www.invenzzia.org/license/new-bsd>
 *
 * Copyright (c) Invenzzia Group <http://www.invenzzia.org>
 * and other contributors. See website for details.
 */

namespace Opf\Validator;

use Opf\Item\Collection;

/**
 * The class represents the allowed field length validator.
 * 
 * @package Validators
 */
class Length implements ValidatorInterface
{
	/**
	 * The length represented by the validator.
	 * @var integer
	 */
	private $_length = 0;

	/**
	 * The list of fields.
	 * @var array
	 */
	private $_fields;

	/**
	 * Constructs length constraint object.
	 *
	 * @param integer $length Maximum string length
	 */
	public function __construct($length, $fields)
	{
		$this->_length = (int)$length;

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
			throw new Exception('Invalid configuration for Length validator.');
		}
	} // end __construct();

	/**
	 * Validates the value in a specified type.
	 *
	 * @param Opf\Item\Collection $collection The collection to validate
	 * @return boolean
	 */
	public function validate(Collection $collection)
	{
		$valid = true;
		foreach($this->_fields as $field)
		{
			$item = $collection->findItemStrict($field);
			$value = $item->getValue();
			if($value === null && $item->getRequired() === false)
			{
				continue;
			}
			if(strlen($value) != $this->_length)
			{
				$valid = false;
				$item->addErrorMessage('The field must be '.$this->_length.' characters long.');
				$item->invalidate();
			}
		}
		return $valid;
	} // end validate();
} // end Length;
