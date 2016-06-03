<?php
/**
 * -------------------------------------------------------------------------------------------------
 * General Helpers Class
 * -------------------------------------------------------------------------------------------------
 * A static Class with general functions in it that don't fit in to other classes
 *
 * @author David Fravigar <david.fravigar@me.com>
 * @version 0.0.1
 * -------------------------------------------------------------------------------------------------
 */

/**
 * -------------------------------------------------------------------------------------------------
 * Stop Direct Access
 * -------------------------------------------------------------------------------------------------
 */

/**
 * -------------------------------------------------------------------------------------------------
 * The class
 * -------------------------------------------------------------------------------------------------
 */
class Co_GeneralHelpers
{
	/**
	 * -----------------------------------------------------------------------------------------------
	 * If array key exists
	 * -----------------------------------------------------------------------------------------------
	 */
	public static function inArray($key, $array)
	{
		if(array_key_exists($key, $array)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * -----------------------------------------------------------------------------------------------
	 * Modify String Function
	 * -----------------------------------------------------------------------------------------------
	 * Use the built in php string functions
	 * @param  string $string 					The string to change
	 * @param  string $method 					The method to use
	 * @return string $changedString    The modified String
	 * -----------------------------------------------------------------------------------------------
	 */
	public static function modifyString($string, $method)
	{
		$changedString = '';

		switch ($method) {
			case 'lowercase':
				$changedString = strtolower($string);
				break;
			case 'uppercase':
				$changedString = lcfirst($string);
				break;
			case 'ucfirst':
				$changedString = strtoupper($string);
				break;
			case 'ucwords':
				$changedString = ucwords($string);
				break;
			default:
			break;
		}

		return $changedString;
	}//end modify_string

	/**
	 * -----------------------------------------------------------------------------------------------
	 * Replace Function
	 * -----------------------------------------------------------------------------------------------
	 * @param  string $string the string we want to change
	 * @param  string $with 	what we want to replace
	 * @param  string $what 	what to replace with
	 * @return string
	 * -----------------------------------------------------------------------------------------------
	 */
	public static function replace($string, $with, $what)
	{
		return $string = str_replace($with, $what, $string);
	}

	/**
	 * ---------------------------------------------------------------------------
	 * [ugliy_string description]
	 * @param  [type] $string [description]
	 * @param  [type] $method [description]
	 * @return [type]         [description]
	 * ---------------------------------------------------------------------------
	 */
	public static function ugliyString($string, $method)
	{
		$string = self::modifyString($string, 'lowercase');

		switch($method) {
			case 'param':
				$string = self::replace($string, ' ', '_');
				$string = self::replace($string, '_', '_');
			break;
			case 'url':
				$string = self::replace($string, ' ', '-');
				$string = self::replace($string, '_', '-');
			break;
		}
		return $string;
	}

	/**
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 * @param  [type] $string [description]
	 * @return [type]         [description]
	 * -----------------------------------------------------------------------------------------------
	 */
	public static function handsomeString($string)
	{
		$string = self::replace($string, '-', ' ');
		$string = self::replace($string, '_', ' ');
		$string = self::modifyString($string, 'ucwords');
		return $string;
	}

	/**
	 * -----------------------------------------------------------------------------------------------
	 * [puralise description]
	 * -----------------------------------------------------------------------------------------------
	 * @param  [type] $string [description]
	 * @return [type]         [description]
	 * -----------------------------------------------------------------------------------------------
	 */
	public static function puralise($string)
	{
		$string = $string . 's';
		return $string;
	}

	/**
	 * -----------------------------------------------------------------------------------------------
	 * [getDataBetween description]
	 * -----------------------------------------------------------------------------------------------
	 * @param  [type] $string [description]
	 * @param  [type] $start  [description]
	 * @param  [type] $end    [description]
	 * @return [type]         [description]
	 * -----------------------------------------------------------------------------------------------
	 */
	public static function getDataBetween($string, $start, $end)
	{
		$sp = strpos($string, $start)+strlen($start);
    $ep = strpos($string, $end)-strlen($start);
    $data = trim(substr($string, $sp, $ep));
    return trim($data);
	}

	/**
	 * -----------------------------------------------------------------------------------------------
	 * [createSlug description]
	 * -----------------------------------------------------------------------------------------------
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 * -----------------------------------------------------------------------------------------------
	 */
	public static function createSlug($name, $prefix='co_')
	{
		$name = self::ugliyString($prefix . $name, 'url');
		return $name;
	}

	/**
	 * -----------------------------------------------------------------------------------------------
	 * 
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 */
	public static function includeFiles($sourceFolder, $extension='.php')
	{
		if(!is_dir($sourceFolder)) {
        die ("Invalid directory.\n\n");
    }
    //$path = rtrim($extension, '/');
    $extension = '*'.$extension;
    $FILES = glob("$sourceFolder/{$extension}", GLOB_BRACE);
		foreach($FILES as $key => $file) {
			require_once($file);
		}
	}

}//end class