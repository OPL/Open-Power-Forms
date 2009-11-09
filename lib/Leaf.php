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

	public function setFullyQualifiedName($name)
	{
		parent::setFullyQualifiedName($name);
	}

	/**
	 * Sets the item value.
	 * @param mixed $value The new value.
	 */
	public function setValue($value)
	{
		$this->_value = $value;
	} // end setValue();

	/**
	 * Returns the item value.
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->_value;
	} // end getValue();
} // end Opf_Leaf;