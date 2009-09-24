<?php
/**
 * The tests for Opf_Class.
 *
 * @author Tomasz "Zyx" Jędrzejewski
 * @copyright Copyright (c) 2009 Invenzzia Group
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class Package_ClassTest extends PHPUnit_Framework_TestCase
{
	protected $backupStaticAttributesBlacklist = array(
		'Opl_Loader' => array('_initialized')
	);

	/**
	 * The mock object for Opt_Class
	 * @var Opt_Class
	 */
	protected $_optMock;

	/**
	 * Sets up the test suite.
	 */
	protected function setUp()
	{
		$this->_optMock = $this->getMock('Opt_Class');
	} // end setUp();

	/**
	 * Tears down the test suite.
	 */
	protected function tearDown()
	{
		Opl_Registry::register('opt', null);
		Opl_Registry::register('opf', null);
		/* null */
	} // end tearDown();

	/**
	 * @covers Opf_Class::__construct
	 */
	public function testConstructorBasic()
	{
		$this->_optMock->expects($this->atLeastOnce())
			->method('register');
		Opl_Registry::register('opt', $this->_optMock);
		$opf = new Opf_Class;

		$this->assertTrue(Opl_Registry::exists('opf'));
	} // end testConstructorBasic();

	/**
	 * @covers Opf_Class::__construct
	 * @expectedException Opf_OptNotInitialized_Exception
	 */
	public function testConstructorOptMissing()
	{
		Opl_Registry::register('opt', null);
		$opf = new Opf_Class;
	} // end testConstructorOptMissing();

	/**
	 * @covers Opf_Class::setTranslationInterface
	 * @covers Opf_Class::getTranslationInterface
	 */
	public function testSettingTranslationInterface()
	{
		Opl_Registry::register('opt', $this->_optMock);
		$opf = new Opf_Class;
		$this->assertEquals(null, $opf->getTranslationInterface());

		$opf->setTranslationInterface($mock = $this->getMock('Opl_Translation_Interface'));
		$this->assertSame($mock, $opf->getTranslationInterface());

		$opf->setTranslationInterface(null);
		$this->assertEquals(null, $opf->getTranslationInterface());
	} // end testSettingTranslationInterface();

	/**
	 * @covers Opf_Class::addForm
	 * @covers Opf_Class::getForm
	 */
	public function testAddForm()
	{
		$mock = $this->getMock('Opf_Form', array(), array('foo'));
		$mock->expects($this->atLeastOnce())
			->method('getName')
			->will($this->returnValue('foo'));

		Opf_Class::addForm($mock);
		$this->assertSame($mock, Opf_Class::getForm('foo'));
	} // end testAddForm();

	/**
	 * @covers Opf_Class::getForm
	 * @expectedException Opf_ItemNotExists_Exception
	 */
	public function testGetFormMissingForm()
	{
		Opf_Class::getForm('foo');
	} // end testAddForm();

	/**
	 * @covers Opf_Class::addForm
	 * @covers Opf_Class::getForm
	 * @expectedException Opf_ItemAlreadyExists_Exception
	 */
	public function testAddFormAlreadyExists()
	{
		$mock1 = $this->getMock('Opf_Form', array(), array('foo'));
		$mock1->expects($this->atLeastOnce())
			->method('getName')
			->will($this->returnValue('foo'));

		Opf_Class::addForm($mock1);

		$mock2 = $this->getMock('Opf_Form', array(), array('foo'));
		$mock2->expects($this->atLeastOnce())
			->method('getName')
			->will($this->returnValue('foo'));

		Opf_Class::addForm($mock2);
	} // end testAddFormAlreadyExists();

	/**
	 * @covers Opf_Class::hasForm
	 * @depends testAddForm
	 */
	public function testHasForm()
	{
		$mock = $this->getMock('Opf_Form', array(), array('foo'));
		$mock->expects($this->atLeastOnce())
			->method('getName')
			->will($this->returnValue('foo'));

		Opf_Class::addForm($mock);
		$this->assertTrue(Opf_Class::hasForm('foo'));
		$this->assertFalse(Opf_Class::hasForm('bar'));
	} // end testHasForm();
} // end Package_ClassTest;