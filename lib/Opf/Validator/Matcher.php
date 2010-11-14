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
 * The class compares the values of two fields.
 * @package Validators
 */
class Matcher implements ValidatorInterface
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
			throw new Exception('Invalid configuration for Matcher validator.');
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
		$previous = null;
		foreach($this->_fields as $field)
		{
			$item = $collection->findItemStrict($field);
			$value = $item->getValue();
			if($value === null && $item->getRequired() === false)
			{
				continue;
			}
			if($previous !== null && $previous !== $value)
			{
				foreach($this->_fields as $onceMore)
				{
					$onceMoreItem = $collection->findItemStrict($onceMore);
					$onceMoreItem->invalidate();
				}
				$item->addErrorMessage('The field values do not match.');
				return false;
			}
			$previous = $value;
		}
		return true;
	} // end validate();
} // end Matcher;
