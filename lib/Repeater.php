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
	 * The number of repetitions.
	 * @var integer
	 */
	protected $_repetitions = 0;

	/**
	 * The data wrappers.
	 * @var array
	 */
	protected $_wrappers;

	/**
	 * The minimum number of required items.
	 * @var integer
	 */
	protected $_minRequired = 0;

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

		$this->_wrappers = array();
		for($i = 0; $i < $repetitions; $i++)
		{
			$this->_wrappers[] = new Opf_Wrapper($item);
		}
	} // end __construct();

	/**
	 * Sets the number of repetitions.
	 *
	 * @param integer $repetitions The number of repetitions.
	 * @todo change the number of wrapper objects
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
	 * Sets the minimum number of required items.
	 * @param integer $minRequired The minimum number of required items.
	 */
	public function setMinRequired($minRequired)
	{
		$this->_minRequired = (int)$minRequired;
	} // end setMinRequired();

	/**
	 * Returns the minimum number of required items.
	 * @return integer
	 */
	public function getMinRequired()
	{
		return $this->_minRequired;
	} // end setMinRequired();

	/**
	 * Sets the item to repeat.
	 *
	 * @param Opf_Item $item The new item to repeat.
	 */
	public function setItem(Opf_Item $item)
	{
		$this->_item = $item;
		$this->setName($item->getName());

		foreach($this->_wrappers as $wrapper)
		{
			$wrapper->setItem($item);
		}
	} // end setItem();

	/**
	 * Returns the repeated items represented by the repeater. The returned
	 * objects are of type Opf_Wrapper and contain a reference to the wrapped
	 * item.
	 *
	 * @param string $placeholder Ignored argument - for compliance with collections
	 * @return array
	 */
	public function getItems($placeholder = 'default')
	{
		return $this->_wrappers;
	} // end getItems();

	/**
	 * Returns the repeater value.
	 *
	 * @return array
	 */
	public function getValue()
	{
		$data = array();
		foreach($this->_wrappers as $wrapper)
		{
			$value = $wrapper->getValue();
			if(!empty($value))
			{
				$data[] = $value;
			}
		}
		return $data;
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
	protected function _validate(&$data, Opf_Item $errorClass = null)
	{
		if(!is_array($data))
		{
			$this->addErrorMessage('field_validation_initial');
		}
		$acceptedItems = 0;
		foreach($this->_wrappers as $id => $item)
		{
			if(!isset($data[$id]))
			{
				continue;
			}
			if(!Opf_Item::isEmpty($data[$id]))
			{
				if($item->_validate($data[$id], $item))
				{
					$acceptedItems++;
				}
			}
		}

		if($acceptedItems < $this->_minRequired)
		{
			$this->addErrorMessage('field_validation_minimal_not_matched');
			return $this->_valid = false;
		}
		else
		{
			return $this->_valid = true;
		}
	} // end _validate();

	/**
	 * Registers the item wrappers in the template as a placeholder.
	 *
	 * @param Opt_View $view The view the form is rendered in
	 * @internal
	 */
	protected function _onRender(Opt_View $view)
	{
		$view->setFormat($this->_item->getName(), 'FormRepeater/Form');
	} // end _onRender();
} // end Opf_Repeater;