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
 *
 * $Id: Exception.php -1   $
 */

/**
 * The general exception class for OPF
 * @package Exceptions
 */
class Opf_Exception extends Opl_Exception
{
	/**
	 * The extra exception data
	 * @var mixed
	 */
	private $_data;

	/**
	 * Sets the exception data. Implements fulent interface.
	 * @param mixed $data The data to assign to the exception.
	 * @return Opf_Exception
	 */
	public function setData($data)
	{
		$this->_data = $data;
		return $this;
	} // end setData();

	/**
	 * Returns the data associated with the exception.
	 * @return mixed
	 */
	public function getData()
	{
		return $this->_data;
	} // end getData();
} // end Opt_Exception;

/**
 * "OPT is not initialized" exception.
 * @package Exceptions
 */
class Opf_OptNotInitialized_Exception extends Opf_Exception
{
	protected $_message = 'OPF requires Open Power Template to be initialized.';
} // end Opf_OptNotInitialized_Exception;

/**
 * Unknown HTTP method exception
 * @package Exceptions
 */
class Opf_UnknownMethod_Exception extends Opf_Exception
{
	protected $_message = 'Unknown HTTP method: %s';
} // end Opf_UnknownMethod_Exception;

/**
 * Unknown event exception
 * @package Exceptions
 */
class Opf_UnknownEvent_Exception extends Opf_Exception
{
	protected $_message = 'Unknown item event: %s';
} // end Opf_UnknownEvent_Exception;

/**
 * "Item already exists" exception
 * @package Exceptions
 */
class Opf_ItemAlreadyExists_Exception extends Opf_Exception
{
	protected $_message = 'The %s %s already exists in OPF.';
} // end Opf_ItemAlreadyExists_Exception;

/**
 * "Item does not exist" exception
 * @package Exceptions
 */
class Opf_ItemNotExists_Exception extends Opf_Exception
{
	protected $_message = 'The %s %s does not exist in OPF.';
} // end Opf_ItemNotExists_Exception;

/**
 * "Placeholder does not exist" exception
 * @package Exceptions
 */
class Opf_PlaceholderNotExists_Exception extends Opf_Exception
{
	protected $_message = 'The placeholder %s does not exist in the collection \'%s\'.';
} // end Opf_PlaceholderNotExists_Exception;

/**
 * "Cannot display a generic widget" exception
 * @package Exceptions
 */
class Opf_CannotDisplay_Exception extends Opf_Exception
{
	protected $_message = 'Cannot display a generic widget.';
} // end Opf_CannotDisplay_Exception;

/**
 * "Invalid Opf_Design call" exception
 * @package Exceptions
 */
class Opf_InvalidDesignCall_Exception extends Opf_Exception
{
	protected $_message = 'Invalid design manager call: %s';
} // end Opf_InvalidDesignCall_Exception;

/**
 * "Invalid Opf_Design call" exception
 * @package Exceptions
 */
class Opf_InvalidObjectType_Exception extends Opf_Exception
{
	protected $_message = 'Invalid object type %s: expected object of class %s';
} // end Opf_InvalidObjectType_Exception;

/**
 * "Invalid form on stack" exception
 * @package Exceptions
 */
class Opf_InvalidStackForm_Exception extends Opf_Exception
{
	protected $_message = 'Invalid form on stack found: %s, expected: %s.';
} // end Opf_InvalidStackForm_Exception;

/**
 * "Not supported" exception
 * @package Exceptions
 */
class Opf_NotSupported_Exception extends Opf_Exception
{
	protected $_message = 'Not supported: %s';
} // end Opf_NotSupported_Exception;