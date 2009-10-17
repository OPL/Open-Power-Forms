<?php
/**
 * The tests for Opf_Item using the Extra_Mock_Item.
 *
 * @author Tomasz "Zyx" Jędrzejewski
 * @copyright Copyright (c) 2009 Invenzzia Group
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class Package_ItemTest extends PHPUnit_Framework_TestCase
{
	protected $backupStaticAttributesBlacklist = array(
		'Opl_Loader' => array('_initialized')
	);

	/**
	 * @covers Opf_Item::setName
	 * @covers Opf_Item::getName
	 */
	public function testSettingName()
	{
		$item = new Extra_Mock_Item;

		$item->setName('foo');
		$this->assertEquals('foo', $item->getName());

		$item->setName('bar');
		$this->assertEquals('bar', $item->getName());
	} // end testSettingName();

	/**
	 * @covers Opf_Item::setRequired
	 * @covers Opf_Item::getRequired
	 */
	public function testSettingRequired()
	{
		$item = new Extra_Mock_Item;

		$item->setRequired(true);
		$this->assertTrue($item->getRequired());

		$item->setRequired(false);
		$this->assertFalse($item->getRequired());

		$item->setRequired(true);
		$this->assertTrue($item->getRequired());

		// According to the boolean typecasting rules, this should be true.
		$item->setRequired('foo');
		$this->assertTrue($item->getRequired());
	} // end testSettingRequired();

	/**
	 * @covers Opf_Item::appendListener
	 * @covers Opf_Item::getListeners
	 */
	public function testAppendListener()
	{
		$l1 = $this->getMock('Opf_EventListener');
		$l2 = $this->getMock('Opf_EventListener');
		$l3 = $this->getMock('Opf_EventListener');

		$item = new Extra_Mock_Item;
		$item->appendListener($l1);
		$item->appendListener($l2);
		$item->appendListener($l3);

		$listeners = $item->getListeners();

		$this->assertSame($l1, $listeners[0]);
		$this->assertSame($l2, $listeners[1]);
		$this->assertSame($l3, $listeners[2]);
	} // end testAppendListener();

	/**
	 * @covers Opf_Item::prependListener
	 * @covers Opf_Item::getListeners
	 */
	public function testPrependListener()
	{
		$l1 = $this->getMock('Opf_EventListener');
		$l2 = $this->getMock('Opf_EventListener');
		$l3 = $this->getMock('Opf_EventListener');

		$item = new Extra_Mock_Item;
		$item->prependListener($l1);
		$item->prependListener($l2);
		$item->prependListener($l3);

		$listeners = $item->getListeners();

		$this->assertSame($l3, $listeners[0]);
		$this->assertSame($l2, $listeners[1]);
		$this->assertSame($l1, $listeners[2]);
	} // end testPrependListener();

	/**
	 * @covers Opf_Item::getListeners
	 */
	public function testGetListenersReturnsEmptyArray()
	{
		$item = new Extra_Mock_Item;
		$this->assertEquals(array(), $item->getListeners());
	} // end testGetListenersReturnsEmptyArray();

	/**
	 * @covers Opf_Item::invokeEvent
	 */
	public function testInvokeEventLaunchesEvents()
	{
		$l1 = $this->getMock('Extra_Mock_EventListener');
		$l1->expects($this->once())
			->method('testEvent');

		$l2 = $this->getMock('Extra_Mock_EventListener');
		$l2->expects($this->once())
			->method('testEvent');
		$item = new Extra_Mock_Item;
		$item->appendListener($l1);
		$item->appendListener($l2);

		$item->invokeEvent('testEvent');
	} // end testInvokeEventLaunchesEvents();

	/**
	 * @covers Opf_Item::invokeEvent
	 * @expectedException Opf_UnknownEvent_Exception
	 */
	public function testInvokeEventThrowsExceptionIfEventDoesNotExist()
	{
		$l1 = $this->getMock('Extra_Mock_EventListener');

		$l2 = $this->getMock('Extra_Mock_EventListener');
		$item = new Extra_Mock_Item;
		$item->appendListener($l1);
		$item->appendListener($l2);

		$item->invokeEvent('testEvent2');
	} // end testInvokeEventThrowsExceptionIfEventDoesNotExist();

	/**
	 * @covers Opf_Item::addValidator
	 * @covers Opf_Item::hasValidator
	 */
	public function testAddValidatorWithoutErrorMessage()
	{
		$validator1 = $this->getMock('Opf_Validator_Interface');
		$validator2 = $this->getMock('Opf_Validator_Interface');

		$item = new Extra_Mock_Item;
		$item->addValidator($validator1);
		$this->assertTrue($item->hasValidator($validator1));
		$this->assertFalse($item->hasValidator($validator2));
	} // end testAddValidatorWithoutErrorMessage();

	/**
	 * @covers Opf_Item::addValidator
	 * @covers Opf_Item::hasValidator
	 */
	public function testAddValidatorWithErrorMessage()
	{
		$validator = $this->getMock('Opf_Validator_Interface');
		$validator->expects($this->once())
			->method('setCustomError');

		$item = new Extra_Mock_Item;
		$item->addValidator($validator, 'Custom error message');
		$this->assertTrue($item->hasValidator($validator));
	} // end testAddValidatorWithErrorMessage();
} // end Package_ItemTest;