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
 * This is a wrapper for another item that serves as a pattern.
 * A group of patterns created for the same item shares the name,
 * validation and display settings but differ in the values they
 * keep.
 */
class Opf_Wrapper extends Opf_Item
{
	/**
	 * The item pattern.
	 * @var Opf_Item
	 */
	private $_pattern;

	/**
	 * Creates a new wrapper with the specified item as a pattern.
	 *
	 * @param Opf_Item $pattern The pattern.
	 */
	public function __construct(Opf_Item $pattern)
	{
		$this->_pattern = $pattern;
		$this->setName($item->getName());
	} // end __construct();

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

} // end Opf_Pattern;