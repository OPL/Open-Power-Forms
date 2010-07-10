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

namespace Opf\ErrorHandler;

/**
 * Implements the default error handler for OPF exceptions.
 */
class ErrorHandler extends \Opl_ErrorHandler
{
	protected $_library = 'Open Power Forms';
	protected $_context = array(
		'__UNKNOWN__' => array(
			'BasicConfiguration' => array()
		),
	);
} // end ErrorHandler;