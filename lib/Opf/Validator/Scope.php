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
 * The class represents the scope validator.
 *
 * @package Validators
 */
class Scope implements ValidatorInterface
{
	/**
	 * The minimum value in the scope.
	 * @var integer
	 */
	private $_minRange = 0;

	/**
	 * The maximum value in the scope.
	 * @var integer
	 */
	private $_maxRange = 0;

	/**
	 * The list of fields.
	 * @var array
	 */
	private $_fields;

	/**
	 * Constructs the scope constraint object.
	 *
	 * @param integer $min The minimum available value.
	 * @param integer $max The maximum available value.
	 * @param string|array $fields The list of fields where this validator applies.
	 */
	public function __construct($min, $max, $fields)
	{
		$this->_minRange = $min;
		$this->_maxRange = $max;

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
			throw new Exception('Invalid configuration for Scope validator.');
		}
	} // end __construct();

	/**
	 * Validates the value.
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
			if($value < $this->_minRange || $value > $this->_maxRange)
			{
				$valid = false;
				$item->addErrorMessage('The field value must be choosen from values between '.$this->_minRange.' '.$this->_maxRange);
				$item->invalidate();
			}
		}
		return $valid;
	} // end validate();
} // end Scope;
