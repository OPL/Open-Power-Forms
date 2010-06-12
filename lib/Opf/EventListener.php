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
 */

/**
 * The class provides listening capabilities for items managed by OPF.
 *
 * Event listeners can be used as plugins for forms. They can implement
 * various extra functionalities, for example "tag management", or modify
 * extra behaviour, i.e. automatic movement of the inserted data to the
 * Doctrine model.
 */
abstract class Opf_EventListener
{
	public function preInit(Opf_Event $event)
	{
		/* null */
	} // end preInit();

	public function postInit(Opf_Event $event)
	{
		/* null */
	} // end postInit();

	public function preRender(Opf_Event $event)
	{
		/* null */
	} // end preRender();

	public function postRender(Opf_Event $event)
	{
		/* null */
	} // end postRender();

	public function preValidate(Opf_Event $event)
	{
		/* null */
	} // end preValidate();

	public function postValidate(Opf_Event $event)
	{
		/* null */
	} // end postValidate();

	public function preAccept(Opf_Event $event)
	{
		/* null */
	} // end preAccept();

	public function postAccept(Opf_Event $event)
	{
		/* null */
	} // end postAccept();
} // end Opf_EventListener;
