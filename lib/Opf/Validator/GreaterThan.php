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
 * The class represents a "greater than number" constraint for numerical
 * values.
 * 
 * @author Tomasz Jędrzejewski
 * @copyright Invenzzia Group <http://www.invenzzia.org/> and contributors.
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 * @package Validators
 */
class GreaterThan implements ValidatorInterface
{
	/**
	 * The bottom range
	 * @var integer
	 */
	private $_range = 0;

	/**
	 * The list of fields.
	 * @var array
	 */
	private $_fields;

	/**
	 * Constructs the "greater than" constraint object.
	 *
	 * @param integer $length Bottom range for the values
	 */
	public function __construct($bottomRange, $fields)
	{
		$this->_range = (int)$bottomRange;

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
			throw new Exception('Invalid configuration for GreaterThan validator.');
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
			if($value <= $this->_range)
			{
				$valid = false;
				$item->addErrorMessage('Minimum allowed value is '.($this->_range+1).'.');
				$item->invalidate();
			}
		}
		return $valid;
	} // end validate();
} // end GreaterThan;