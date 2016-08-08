<?php 
class Input
{
	/**
	 * Check if a given value was passed in the request
	 *
	 * @param string $key index to look for in request
	 * @return boolean whether value exists in $_POST or $_GET
	 */
	public static function has($key)
	{
		if (isset($_REQUEST[$key])) {
			return true;
		} else {
			return false;
		}
	}

	public static function getString($key)
	{
		$value = Self::get($key);
		if (!is_string($value))
		{
			throw new exception ('The value of $key should be a string');
		}
		return trim($value);
	}
	public static function getNumber($key, $default = 0)
	{
		$value = Self::get($key, $default);
		if (!is_numeric($key))
		{
			throw new exception ('The value of $key should be a number');
		}
		return floatval($value);
	}
	public static function isPost()
	{
		return !empty($_POST);
	}
	/**
	 * Get a requested value from either $_POST or $_GET
	 *
	 * @param string $key index to look for in index
	 * @param mixed $default default value to return if key not found
	 * @return mixed value passed in request
	 */
	public static function get($key, $default = null)
	{
		//checks for the value of $key and requests that value returning null if none.
		return self::has($key) ? $_REQUEST[$key] : $default;
	}


	///////////////////////////////////////////////////////////////////////////
	//                      DO NOT EDIT ANYTHING BELOW!!                     //
	// The Input class should not ever be instantiated, so we prevent the    //
	// constructor method from being called. We will be covering private     //
	// later in the curriculum.                                              //
	///////////////////////////////////////////////////////////////////////////
	private function __construct() {}
}