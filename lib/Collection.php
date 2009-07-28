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
 * The class represents a collection of items and provides services to manage
 * them.
 */
abstract class Opf_Collection extends Opf_Item
{

	public function appendItem(Opf_Item $item)
	{

	} // end appendItem();

	public function prependItem(Opf_Item $item)
	{
		
	} // end prependItem();

	public function getItem($item)
	{

	} // end getItem();

	public function removeItem($item)
	{

	} // end removeItem();

	public function replaceItem($newItem, $oldItem)
	{

	} // end replaceItem();

	protected function _isItemAllowed(Opf_Item $item)
	{

	} // end _isItemAllowed();
} // end Opf_Collection;