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
 * $Id: Leaf.php -1   $
 */

/**
 * Represents a leaf node of a form tree, unsually a form field.
 */
class Opf_Leaf extends Opf_Item
{

	/**
	 * The leaf initial value.
	 * @var mixed
	 */
	protected $_value = null;

	/**
	 * The list of data filters
	 * @var array
	 */
	protected $_filters = array();

	/**
	 * Creates a new leaf item.
	 * @param string $name The item name.
	 */
	public function __construct($name)
	{
		$this->setName($name);
	} // end __construct();

	/**
	 * Populates the item with the data.
	 * @param mixed &$data The data used to populate the item
	 */
	public function populate(&$data)
	{
		$this->_value = $data;
	} // end populate();

	/**
	 * Adds a new data filter to the item. Implements fluent
	 * interface.
	 *
	 * @param Opf_Filter_Interface $filter The new filter.
	 * @return Opf_Leaf
	 */
	public function addFilter(Opf_Filter_Interface $filter)
	{
		$this->_filters[] = $filter;

		return $this;
	} // end addFilter();

	/**
	 * Returns all the data filters currently assigned to the item.
	 *
	 * @return array
	 */
	public function getFilters()
	{
		return $this->_filters;
	} // end getFilter();

	/**
	 * Returns true, if the item uses the specified filter.
	 *
	 * @return boolean
	 */
	public function hasFilter(Opf_Filter_Interface $filter)
	{
		foreach($this->_filters as $scanned)
		{
			if($scanned === $filter)
			{
				return true;
			}
		}
		return false;
	} // end hasFilter();

	/**
	 * Removes an existing filter from an item. The filter can be determined
	 * either by its index number or the object.
	 *
	 * @param integer|Opf_Filter_Interface $filter The filter to remove.
	 */
	public function removeFilter($filter)
	{
		if(is_integer($filter))
		{
			if(isset($this->_validators[$filter]))
			{
				unset($this->_validators[$filter]);
			}
		}
		elseif($filter instanceof Opf_Filter_Interface)
		{
			foreach($this->_filters as $id => $obj)
			{
				if($obj === $filter)
				{
					unset($this->_filters[$id]);
				}
			}
		}
	} // end removeFilter();

	/**
	 * Sets the item value.
	 * @param mixed $value The new value.
	 */
	public function setValue($value)
	{
		if($this->_filter !== null)
		{
			$this->_value = $this->_filter->toPublic($value);
		}
		else
		{
			$this->_value = $value;
		}
	} // end setValue();

	/**
	 * Returns the item value.
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->_value;
	} // end getValue();

	/**
	 * Validates the field against the registered validators.
	 * @param mixed $data The data to validate.
	 */
	protected function _validate(&$data, Opf_Item $errorClass = null)
	{
		foreach($this->_filters as $filter)
		{
			$data = $filter->toInternal($data);
		}
		return parent::_validate($data, $errorClass);
	} // end _validate();
} // end Opf_Leaf;