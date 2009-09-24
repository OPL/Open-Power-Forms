<?php
/**
 * The special mock object to test the abstract class Opf_Item
 *
 * @author Tomasz "Zyx" Jędrzejewski
 * @copyright Copyright (c) 2009 Invenzzia Group
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
class Extra_Mock_Item extends Opf_Item
{
	public function setValue($value)
	{
		/* null */
	} // end setValue();

	public function getValue()
	{
		return '';
	} // end getValue();
} // end Extra_Mock_Item;