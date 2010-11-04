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

/**
 * A sample data filter. It will not be a part of the final
 * release.
 */
class Opf_Filter_Datetime implements Opf_Filter_Interface
{
	/**
	 * Converts the publicly entered value to the internal format.
	 *
	 * @param mixed $value The entered value
	 * @return mixed
	 */
	public function toInternal($value)
	{
		return DateTime::createFromFormat('d.m.Y, H:i', $value);
	} // end toInternal();

	public function toPublic($value)
	{
		return $value->format('d.m.Y, H:i');
	} // end toPublic();
} // end Opf_Filter_Datetime;