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

/**
 * The class provides listening capabilities for items managed by OPF.
 *
 * Event listeners can be used as plugins for forms. They can implement
 * various extra functionalities, for example "tag management", or modify
 * extra behaviour, i.e. automatic movement of the inserted data to the
 * Doctrine model.
 */
abstract class EventListener
{
	public function preInit(Event $event)
	{
		/* null */
	} // end preInit();

	public function postInit(Event $event)
	{
		/* null */
	} // end postInit();

	public function preRender(Event $event)
	{
		/* null */
	} // end preRender();

	public function postRender(Event $event)
	{
		/* null */
	} // end postRender();

	public function preValidate(Event $event)
	{
		/* null */
	} // end preValidate();

	public function postValidate(Event $event)
	{
		/* null */
	} // end postValidate();

	public function preAccept(Event $event)
	{
		/* null */
	} // end preAccept();

	public function postAccept(Event $event)
	{
		/* null */
	} // end postAccept();
} // end EventListener;
