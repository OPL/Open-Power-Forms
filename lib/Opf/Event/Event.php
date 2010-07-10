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

namespace Opf\Event;

use Opf\Item\AbstractItem;

/**
 * Represents an event in the event handling.
 */
class Event
{
	/**
	 * The item the event is called for.
	 * @var Opf\Item\AbstractItem
	 */
	private $_item;

	/**
	 * The event name
	 * @var string
	 */
	private $_name;

	/**
	 * Constructs an event object.
	 * @param Opf\Item\AbstractItem $item The item the event is called for.
	 * @param string $eventName The event name
	 */
	public function __construct(AbstractItem $item, $eventName)
	{
		$this->_item = $item;
		$this->_name = $eventName;
	} // end __construct();

	/**
	 * Returns the item the event is called for.
	 * @return Opf\Item\AbstractItem
	 */
	public function getItem()
	{
		return $this->_item;
	} // end getItem();

	/**
	 * Returns the event name.
	 * @return string
	 */
	public function getEvent()
	{
		return $this->_name;
	} // end getEvent();
} // end Event;