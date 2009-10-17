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
 * This item type decorates another item and causes it to be repeated
 * several times. The programmer may control the number of repetitions
 * and the number of required instances that must be filled in.
 */
class Opf_Repeater extends Opf_Wrapper
{
	/**
	 * The repeated item.
	 * @var Opf_Item
	 */
	protected $_item;

	/**
	 * The number of repetitions.
	 * @var integer
	 */
	protected $_repetitions = 0;

	/**
	 * Creates the repeater for the specified item.
	 * 
	 * @param Opf_Item $item The item to repeat.
	 * @param integer $repetitions The number of repetitions.
	 */
	public function __construct(Opf_Item $item, $repetitions = 0)
	{
		parent::__construct($item);
		$this->_repetitions = $repetitions;
	} // end __construct();

	/**
	 * Sets the number of repetitions.
	 *
	 * @param integer $repetitions The number of repetitions.
	 */
	public function setRepetitions($repetitions)
	{
		$this->_repetitions = (int)$repetitions;
	} // end setRepetitions();

	/**
	 * Returns the number of repetitions.
	 * @return integer
	 */
	public function getRepetitions()
	{
		return $this->_repetitions;
	} // end getRepetitions();

	/**
	 * Sets the item to repeat.
	 *
	 * @param Opf_Item $item The new item to repeat.
	 */
	public function setItem(Opf_Item $item)
	{
		$this->_item = $item;
		$this->setName($item->getName());
	} // end setItem();

	/**
	 * Returns the repeated item.
	 *
	 * @return Opf_Item
	 */
	public function getItem()
	{
		return $this->_item;
	} // end getItem();

	/**
	 * Returns the repeater value.
	 *
	 * @return array
	 */
	public function getValue()
	{

	} // end getValue();

	/**
	 * Sets the repeater values
	 *
	 * @param array $value The list of values for each repetition.
	 */
	public function setValue($value)
	{

	} // end setValue();

	/**
	 * Validates the field against the registered validators.
	 * @param mixed $data The data to validate.
	 */
	protected function _validate(&$data)
	{
		parent::_validate($data);

		foreach($)


	} // end _validate();
} // end Opf_Repeater;