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
 * The class represents a collection widget.
 * @package Widgets
 */
class Collection extends Component
{
	/**
	 * Returns the unique component type name.
	 * @return string
	 */
	public function getComponentName()
	{
		return 'collection';
	} // end getComponentName();

	/**
	 * Displays the input component.
	 *
	 * @param array $attributes The opt:display attribute list.
	 */
	public function display($attributes = array())
	{
		/* todo: add view creation here */
	} // end display();
} // end Collection;
