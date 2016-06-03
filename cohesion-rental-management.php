<?php
/**
 * -------------------------------------------------------------------------------------------------
 * Wordpress
 * -------------------------------------------------------------------------------------------------
 * Plugin Name: Cohesion Rental Management
 * Plugin URI: http://davidfravigar.com/
 * Description: A plugin for administering rental and property management
 * Version: 0.0.1
 * Author: David Fravigar
 * Author URI: http://davidfravigar.com/
 * License: GNU GENERAL PUBLIC LICENSE V3
 * -------------------------------------------------------------------------------------------------
 * Developer
 * -------------------------------------------------------------------------------------------------
 * Hey hi there developer! this is a plugin that creates several custom post types, metaboxes and
 * taxonomies that are used with a frontend editor.
 *
 * This plugin has been constructed so that it is modular but you will have to get your hands dirty
 * in order to extend it past it's original state.
 *
 * Please keep this file clean as most of the heavy lifting takes place within the framework itself
 * this file is where we configure everything and send it to the framework to create.
 * @author 		David Fravigar <david.fravigar@me.com>
 * @version  	0.0.1
 * -------------------------------------------------------------------------------------------------
 */

/**
 * -------------------------------------------------------------------------------------------------
 * Stop Direct Access
 * -------------------------------------------------------------------------------------------------
 */
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * -------------------------------------------------------------------------------------------------
 * The Class
 * -------------------------------------------------------------------------------------------------
 */
class CohesionRentalManagement
{
	/**
	 * -----------------------------------------------------------------------------------------------
	 * VARS
	 * -----------------------------------------------------------------------------------------------
	 */

	/**
	 * -----------------------------------------------------------------------------------------------
	 * Constructor
	 * -----------------------------------------------------------------------------------------------
	 */
	function __construct()
	{
		add_action('init', array($this, 'co_constants'));
		add_action('init', array($this, 'co_includes'));
		add_action('init', array($this, 'co_init'));
	}//end constructor

	/**
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 */
	public function co_constants()
	{
		define('RENTALMANAGEMENT_DIR', plugin_dir_path(__FILE__));
		define('RM_FRAMEWORK_DIR', RENTALMANAGEMENT_DIR . 'Framework');
		define('RM_ADMIN_DIR', RM_FRAMEWORK_DIR . '/Admin');
		define('RM_GENERATORS_DIR', RM_FRAMEWORK_DIR . '/Generators');
		define('RM_HELPERS_DIR', RM_FRAMEWORK_DIR . '/Helpers');
		define('RM_POSTTYPES_DIR', RM_ADMIN_DIR . '/PostTypes');
		define('RM_SETTINGSPANEL_DIR', RM_ADMIN_DIR . '/SettingsPanel');

		define('RENTALMANAGEMENT_URL', plugin_dir_url(__FILE__));
		define('RM_CSS_URL', RENTALMANAGEMENT_URL . 'Assets/CSS');
		define('RM_JS_URL', RENTALMANAGEMENT_URL . 'Assets/JS');
		define('RM_IMAGES_URL', RENTALMANAGEMENT_URL . 'Assets/Images');
	}//end constants

	/**
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 */
	public function co_includes()
	{
		require_once(RM_HELPERS_DIR . '/GeneralHelpers.class.php');
		require_once(RM_HELPERS_DIR . '/WPQuery.class.php');
		Co_GeneralHelpers::includeFiles(RM_GENERATORS_DIR, '.Generator.php');
		Co_GeneralHelpers::includeFiles(RM_POSTTYPES_DIR, '.PostType.php');
	}//end includes

	/**
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 */
	public function co_init()
	{
		$postTypeGenerator = new Co_CustomPostTypeGenerator();
		$properties = new Co_PropertyPostType();

		$postTypeGenerator->init($properties->getPostType());
	}//end init

	/**
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 */
	public function co_registerPublicStylesAndScripts()
	{

	}//end registerPublicStylesAndScripts

	/**
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 */
	public function co_registerAdminStylesAndScripts()
	{

	}//end registerAdminStylesAndScripts
}//end class

/**
 * -------------------------------------------------------------------------------------------------
 * Instantiate the class
 * -------------------------------------------------------------------------------------------------
 */
new CohesionRentalManagement();