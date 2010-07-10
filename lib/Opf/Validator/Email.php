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

namespace Opf\Validator;

use Opf\Item\Collection;

/**
 * The class represents valid e-mail string.
 * @package Validators
 */
class Email implements \ValidatorInterface
{
	private $_fields;

	/**
	 * Creates the validator.
	 *
	 * @param string|array $fields The list of fields, where the validator applies.
	 */
	public function __construct($fields)
	{
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
			throw new Exception('Invalid configuration for Email validator.');
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
			if(!is_scalar($value))
			{
				$valid = false;
				$item->invalidate();
			}
			if((bool)filter_var($value, FILTER_VALIDATE_EMAIL) === false)
			{
				$valid = false;
				$item->addErrorMessage('Not a valid e-mail address.');
				$item->invalidate();
			}
		}
		return $valid;
	} // end validate();
} // end Email;
