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
 * $Id: Design.php -1   $
 */

/**
 * Manages the CSS class set used by the widgets. It is
 * available both for the script and the templates through
 * a special wrapper.
 */
class Opf_Design
{
	/**
	 * The list of CSS classes for valid elements.
	 * @var array
	 */
	static private $_valid = array();

	/**
	 * The list of CSS classes for invalid elements.
	 * @var array
	 */
	static private $_invalid = array();

	/**
	 * Registers a new CSS class for the specified element
	 * for the valid or neutral case.
	 *
	 * @static
	 * @param string $element The element type name
	 * @param string $class The CSS class name
	 */
	static public function setValidClass($element, $class)
	{
		self::$_valid[(string)$element] = (string)$class;
	} // end setValidClass();

	/**
	 * Registers a new CSS class for the specified element for
	 * the invalid fill case.
	 *
	 * @static
	 * @param string $element The element type name
	 * @param string $class The CSS class name
	 */
	static public function setInvalidClass($element, $class)
	{
		self::$_invalid[(string)$element] = (string)$class;
	} // end setInvalidClass();

	/**
	 * Returns the valid class for the specified element.
	 *
	 * @return string|null
	 */
	static public function getValidClass($element)
	{
		if(isset(self::$_valid[(string)$element]))
		{
			return self::$_valid[(string)$element];
		}
		return null;
	} // end getValidClass();

	/**
	 * Returns the invalid class for the specified element.
	 * If the invalid class is not specified, it attempts to
	 * return the valid class.
	 *
	 * @return string|null
	 */
	static public function getInvalidClass($element)
	{
		if(isset(self::$_invalid[(string)$element]))
		{
			return self::$_invalid[(string)$element];
		}
		return self::getValidClass($element);
	} // end getInvalidClass();

	/**
	 * Returns the CSS class for the specified element. The
	 * optional attribute controls, whether we should return
	 * the invalid or valid name.
	 *
	 * @param boolean $valid Should we return valid class?
	 * @return string|null
	 */
	static public function getClass($element, $valid = true)
	{
		if(!$valid)
		{
			if(isset(self::$_invalid[(string)$element]))
			{
				return self::$_invalid[(string)$element];
			}
		}
		if(isset(self::$_valid[(string)$element]))
		{
			return self::$_valid[(string)$element];
		}
		return null;
	} // end getClass();
} // end Opf_Design;