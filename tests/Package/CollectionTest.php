<?php
/**
 * The tests for Opf_Class.
 *
 * @author Tomasz "Zyx" Jędrzejewski
 * @copyright Copyright (c) 2009 Invenzzia Group
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

class Package_CollectionTest extends PHPUnit_Framework_TestCase
{
	protected $backupStaticAttributesBlacklist = array(
		'Opl_Loader' => array('_initialized')
	);

	/**
	 * The collection mock.
	 * @var Extra_Mock_Collection
	 */
	protected $_collectionMock;

	/**
	 * Sets up the collection mock.
	 */
	public function setUp()
	{
		$this->_collectionMock = new Extra_Mock_Collection;
	} // end setUp();

	/**
	 * Removes the collection mock after the test.
	 */
	public function tearDown()
	{
		unset($this->_collectionMock);
	} // end tearDown();

	/**
	 * @covers Opf_Collection::appendItem
	 */
	public function testAppendingToDefaultPlaceholder()
	{
		$items = array(0 =>
			new Opf_Leaf('foo'),
			new Opf_Leaf('bar'),
			new Opf_Leaf('joe')
		);

		foreach($items as $item)
		{
			$this->_collectionMock->appendItem($item);
		}

		$returned = $this->_collectionMock->getItems();

		$this->assertEquals($items, $returned);
	} // end testAppendingToDefaultPlaceholder();

	/**
	 * @covers Opf_Collection::prependItem
	 */
	public function testPrependingToDefaultPlaceholder()
	{
		$items = array(0 =>
			new Opf_Leaf('foo'),
			new Opf_Leaf('bar'),
			new Opf_Leaf('joe')
		);

		foreach($items as $item)
		{
			$this->_collectionMock->prependItem($item);
		}

		$returned = $this->_collectionMock->getItems();

		$this->assertEquals(array_reverse($items), $returned);
	} // end testPrependingToDefaultPlaceholder();

} // end Package_CollectionTest;