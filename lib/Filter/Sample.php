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
 * $Id: Class.php 257 2009-11-09 08:30:15Z zyxist $
 */

/**
 * A sample data filter. It will not be a part of the final
 * release.
 */
class Opf_Filter_Sample implements Opf_Filter_Interface
{
	/**
	 * Converts the publicly entered value to the internal format.
	 *
	 * @param mixed $value The entered value
	 * @return mixed
	 */
	public function toInternal($value)
	{
		if(is_scalar($value) && preg_match('/-?[0-9]+/', $value))
		{
			return (string)(-(int)$value);
		}
		return $value;
	} // end toInternal();

	public function toPublic($value)
	{
		
	} // end toInternal();
} // end Opf_Filter_Sample;