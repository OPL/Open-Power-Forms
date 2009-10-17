<?php
/**
 * The special mock object to test the collection interface.
 *
 * @author Tomasz "Zyx" Jędrzejewski
 * @copyright Copyright (c) 2009 Invenzzia Group
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Extra_Mock_Collection extends Opf_Collection
{
	public function setValue($value)
	{
		/* null */
	} // end setValue();

	public function getValue()
	{
		return '';
	} // end getValue();
} // end Extra_Mock_Collection;