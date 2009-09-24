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
 * $Id: Class.php 227 2009-09-03 20:44:43Z megawebmaster $
 */

/**
 * This interface is responsible for transmitting the data
 * between the sub-pages in a multi-step form managed by
 * Opf_Form_Sequence.
 */
interface Opf_Tracker_Interface
{
	public function setSequence(Opf_Form_Sequence $form);
	public function track(&$data, $step);
	public function retrieve(&$data, $step);

} // end Opf_Tracker_Interface;