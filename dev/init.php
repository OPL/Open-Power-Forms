<?php
// OPL Initialization
error_reporting(E_ALL | E_DEPRECATED);
$config = parse_ini_file('../paths.ini', true);
require($config['libraries']['Opl'].'Base.php');
Opl_Loader::loadPaths($config);
// Opl_Loader::setCheckFileExists(true);
Opl_Loader::register();

// Opl_Registry::setValue('opl_debug_console', true);
Opl_Registry::setValue('opl_extended_errors', true);

function profile($dump = false)
{
	$trace = debug_backtrace();
	array_pop($trace);
	$k = reset($trace);
	Opl_Debug::writeErr($k['function'].','.$k['file'].','.$k['line']);
} // end profile();