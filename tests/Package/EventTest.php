<?php
/**
 * The tests for Opf_Event.
 *
 * @author Tomasz "Zyx" Jędrzejewski
 * @copyright Copyright (c) 2009 Invenzzia Group
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class Package_EventTest extends PHPUnit_Framework_TestCase
{
	protected $backupStaticAttributesBlacklist = array(
		'Opl_Loader' => array('_initialized')
	);

	/**
	 * @covers Opf_Event::__construct
	 * @covers Opf_Event::getItem
	 */
	public function testSettingItem()
	{
		$mock = $this->getMock('Opf_Item');

		$event = new Opf_Event($mock, 'foo');

		$this->assertSame($mock, $event->getItem());
	} // end testSettingItem();

	/**
	 * @covers Opf_Event::getEvent
	 */
	public function testSettingEvent()
	{
		$mock = $this->getMock('Opf_Item');

		$event = new Opf_Event($mock, 'foo');
		$this->assertEquals('foo', $event->getEvent());
	} // end testSettingEvent();

} // end Package_EventTest;