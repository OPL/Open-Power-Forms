<?php
/**
 * The special mock event listener, so that the code could properly
 * detect the methods.
 *
 * @author Tomasz "Zyx" Jędrzejewski
 * @copyright Copyright (c) 2009 Invenzzia Group
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */
abstract class Extra_Mock_EventListener extends Opf_EventListener
{
	abstract public function testEvent();
} // end Extra_Mock_EventListener;