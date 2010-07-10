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

namespace Opf\Widget;

/**
 * The generic widget is used to collect the data about the
 * widget that are later rewritten to the proper widget.
 * It cannot be displayed.
 * @package Widgets
 */
class Generic extends Component
{
	/**
	 * The option list.
	 * @var array
	 */
	protected $_options = array();

	/**
	 * Allows to set the options. Implements the fluent interface.
	 * @param array $options The option list.
	 * @return Opf\Widget\Component
	 */
	public function setOptions($options)
	{
		$this->_options = $options;
		return $this;
	} // end setOptions();

	/**
	 * Displays the input component.
	 *
	 * @param array $attributes The opt:display attribute list.
	 */
	public function display($attributes = array())
	{
		throw new \RuntimeException('Generic widget cannot be displayed.');
	} // end display();
} // end Generic;