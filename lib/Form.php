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
 * Represents a form. Because forms are treated as items, they can
 * be parts of other forms.
 */
class Opf_Form extends Opf_Collection
{
	/**
	 * The view used to render the form.
	 *
	 * @param Opt_View $view
	 */
	protected $_view = null;

	/**
	 * Initializes the form processor.
	 *
	 * @param String $name The form name.
	 */
	public function __construct($name)
	{
		$this->_name = $name;
	} // end __construct();

	/**
	 * Sets the form view.
	 *
	 * @param Opt_View $view
	 */
	public function setView(Opt_View $view)
	{
		$this->_view = $view;
	} // end setView();

	/**
	 * Returns the form view.
	 * @return Opt_View
	 */
	public function getView()
	{
		return $this->_view;
	} // end getView();

	public function getValues()
	{

	} // end getValues();

	public function populate()
	{

	} // end populate();

	public function execute()
	{

	} // end execute();
} // end Opf_Form;
