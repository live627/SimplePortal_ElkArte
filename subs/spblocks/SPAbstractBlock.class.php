<?php

/**
 * @package SimplePortal
 *
 * @author SimplePortal Team
 * @copyright 2014 SimplePortal Team
 * @license BSD 3-clause
 *
 * @version 2.4
 */

if (!defined('ELK'))
	die('No access...');

/**
 * Abstract Simple Portal block
 *
 * - Implements Sp_Block
 * - Sets base functionality for use in blocks
 */
abstract class SP_Abstract_Block
{
	/**
	 * Database object
	 * @var object
	 */
	protected $_db = null;

	/**
	 * Block parameters
	 * @var mixed[]
	 */
	protected $block_parameters = array();

	/**
	 * Data array for use in the blocks
	 * @var mixed[]
	 */
	protected $data = array();

	/**
	 * Name of the template function to call
	 * @var string
	 */
	protected $template = '';

	/**
	 * Class constuctor, makes db availalbe
	 *
	 * @param Database $db
	 */
	public function __construct($db = null)
	{
		$this->_db = $db;
	}

	/**
	 * Returns optional block parameters
	 *
	 * @return mixed[]
	 */
	public function parameters()
	{
		return $this->block_parameters;
	}

	/**
	 * Sets the template name that will be called via render
	 *
	 * @param string $template
	 */
	public function setTemplate($template)
	{
		$this->template = $template;
	}

	/**
	 * @todo
	 */
	abstract public function setup($parameters, $id);

	/**
	 * Renders a block with a given template and data
	 */
	public function render()
	{
		if (is_callable($this->template))
			call_user_func_array($this->template, array($this->data));
	}

	/**
	 * Validates that a user can access a block
	 *
	 * @return string[]
	 */
	public static function permissionsRequired()
	{
		return array();
	}
}