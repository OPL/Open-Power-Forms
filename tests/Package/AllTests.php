<?php
/**
 * The test suite file that configures the execution of the test cases.
 *
 * @author Tomasz "Zyx" Jędrzejewski
 * @copyright Copyright (c) 2009 Invenzzia Group
 * @license http://www.invenzzia.org/license/new-bsd New BSD License
 */

require_once('ClassTest.php');
require_once('EventTest.php');
require_once('ItemTest.php');
require_once('CollectionTest.php');

class Package_AllTests extends PHPUnit_Framework_TestSuite
{
	protected $backupStaticAttributesBlacklist = array(
		'Opl_Loader' => array('_initialized')
	);
	/**
	 * Configures the suite object.
	 *
	 * @return Suite
	 */
	public static function suite()
	{
		$suite = new Package_AllTests('Package');
		$suite->addTestSuite('Package_ClassTest');
		$suite->addTestSuite('Package_EventTest');
		$suite->addTestSuite('Package_ItemTest');
		$suite->addTestSuite('Package_CollectionTest');

		return $suite;
	} // end suite();

	/**
	 * Initializes the test procedure.
	 */
	protected function setUp()
	{
		/* currently null */
	} // end setUp();

	/**
	 * Shuts down the test procedure.
	 */
	protected function tearDown()
	{
		/* currently null */
	} // end tearDown();

} // end Package_AllTests;