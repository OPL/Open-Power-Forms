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
 */

namespace Opf\Item;

use Opf\Filter\FilterInterface;

/**
 * Represents a leaf node of a form tree, unsually a form field.
 */
class Leaf extends AbstractItem
{
	/**
	 * The leaf initial value.
	 * @var mixed
	 */
	protected $_value = null;

	/**
	 * The list of data filters
	 * @var Opf\Filter\FilterInterface
	 */
	protected $_filter;

	/**
	 * Creates a new leaf item.
	 * @param string $name The item name.
	 */
	public function __construct($name)
	{
		$this->setName($name);
	} // end __construct();

	/**
	 * Adds a new data filter to the item. Implements fluent
	 * interface.
	 *
	 * @param Opf\Filter\FilterInterface $filter The new filter.
	 * @return Opf\Item\Leaf
	 */
	public function setFilter(FilterInterface $filter)
	{
		$this->_filter = $filter;

		return $this;
	} // end setFilter();

	/**
	 * Returns all the data filters currently assigned to the item.
	 *
	 * @return Opf\Filter\FilterInterface
	 */
	public function getFilter()
	{
		return $this->_filter;
	} // end getFilter();

	/**
	 * Sets the item value.
	 * @param mixed $value The new value.
	 */
	public function setValue($value)
	{
		if($this->_filter !== null)
		{
			$this->_value = $this->_filter->toInternal($value);
		}
		else
		{
			$this->_value = $value;
		}
	} // end setValue();

	/**
	 * Sets the item value.
	 * @param mixed $value The new value.
	 */
	public function populate($value)
	{
		$this->_value = $value;
	} // end populate();

	/**
	 * Returns the item value.
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->_value;
	} // end getValue();

	/**
	 * Returns the item value.
	 * @return mixed
	 */
	public function getDisplayedValue()
	{
		if($this->_filter !== null && $this->_value !== null)
		{
			return $this->_filter->toPublic($this->_value);
		}
		else
		{
			return $this->_value;
		}
	} // end getDisplayedValue();
} // end Leaf;
