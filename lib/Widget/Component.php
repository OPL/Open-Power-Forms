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
 * The class provides the necessary logic for the widgets in templates,
 * using the OPT Component API.
 */
abstract class Opf_Widget_Component implements Opt_Component_Interface
{
	/**
	 * The view the widget is deployed in.
	 * @var Opt_View
	 */
	protected $_view;

	public function __construct($name = '')
	{

	} // end __construct();

	/**
	 * Passes the OPT view to the widget.
	 *
	 * @param Opt_View $view The view.
	 */
	public function setView(Opt_View $view)
	{
		$this->_view = $view;
	} // end setView();

	/**
	 * Sets the widget datasource.
	 *
	 * @param Array $data
	 */
	public function setDatasource($data)
	{

	} // end setDatasource();

	public function set($name, $value)
	{

	} // end set();

	public function get($name)
	{

	} // end get();

	public function defined($name)
	{

	} // end defined();

	public function display($attributes = array())
	{

	} // end display();

	public function processEvent($name)
	{

	} // end processEvent();

	public function manageAttributes($tagName, Array $attributes)
	{

	} // end manageAttributes();
} // end Opf_Widget_Component;