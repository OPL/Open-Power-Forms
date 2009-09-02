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
 * $Id$
 */

/**
 * The general exception class for OPF
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
 */
class Opf_OptNotInitialized_Exception extends Opf_Exception
{
	protected $_message = 'OPF requires Open Power Template to be initialized.';
} // end Opf_OptNotInitialized_Exception;

/**
 * Unknown HTTP method exception
 */
class Opf_UnknownMethod_Exception extends Opf_Exception
{
	protected $_message = 'Unknown HTTP method: %s';
} // end Opf_UnknownMethod_Exception;

/**
 * Unknown event exception
 */
class Opf_UnknownEvent_Exception extends Opf_Exception
{
	protected $_message = 'Unknown item event: %s';
} // end Opf_UnknownEvent_Exception;

/**
 * "Item already exists" exception
 */
class Opf_ItemAlreadyExists_Exception extends Opf_Exception
{
	protected $_message = 'The %s %s already exists in OPF.';
} // end Opf_ItemAlreadyExists_Exception;

/**
 * "Item does not exist" exception
 */
class Opf_ItemNotExists_Exception extends Opf_Exception
{
	protected $_message = 'The %s %s does not exist in OPF.';
} // end Opf_ItemNotExists_Exception;

/**
 * "Cannot display a generic widget" exception
 */
class Opf_CannotDisplay_Exception extends Opf_Exception
{
	protected $_message = 'Cannot display a generic widget.';
} // end Opf_CannotDisplay_Exception;