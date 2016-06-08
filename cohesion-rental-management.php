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
	private $postTypeGenerator;
	private $taxonomyGenerator;
	private $metaboxGenerator;

	/**
	 * -----------------------------------------------------------------------------------------------
	 * Constructor
	 * -----------------------------------------------------------------------------------------------
	 */
	function __construct()
	{
		add_action('init', array($this, 'co_constants'));
		add_action('init', array($this, 'co_includes'));
		add_action('init', array($this, 'co_checkWordpress'));
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
		define('RM_TEMPLATE_DIR', RM_FRAMEWORK_DIR . '/Templates');
		define('RM_MENU_SLUG', 'cohesion-rental-management');

		define('RENTALMANAGEMENT_URL', plugin_dir_url(__FILE__));
		define('RM_CSS_URL', RENTALMANAGEMENT_URL . 'Assets/CSS');
		define('RM_JS_URL', RENTALMANAGEMENT_URL . 'Assets/JS');
		define('RM_IMAGES_URL', RENTALMANAGEMENT_URL . 'Assets/Images');
	}//end constants

	/**
	 * -----------------------------------------------------------------------------------------------
	 * Check Wordpress
	 * -----------------------------------------------------------------------------------------------
	 */
	public function co_checkWordpress()
	{
		global $wp_version;
		if( version_compare( $wp_version, "2.9", "<" ) )
    exit( 'This plugin requires WordPress 2.9 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>' );
	}

	/**
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 */
	public function co_includes()
	{
		require_once(RM_HELPERS_DIR . '/GeneralHelpers.class.php');
		require_once(RM_HELPERS_DIR . '/WPQuery.class.php');
		CORM_GeneralHelpers::includeFiles(RM_GENERATORS_DIR, '.Generator.php');
		CORM_GeneralHelpers::includeFiles(RM_POSTTYPES_DIR, '.PostType.php');
	}//end includes

	/**
	 * -----------------------------------------------------------------------------------------------
	 *
	 * -----------------------------------------------------------------------------------------------
	 */
	public function co_init()
	{
		$this->co_postTypes();
		add_action('admin_menu', array($this, 'co_adminMenu'));
	}//end init

	public function co_postTypes()
	{
		$postTypeGenerator = new CORM_CustomPostTypeGenerator();
		$properties = new CORM_PropertyPostType();
		$postTypeGenerator->init($properties->getPostType());
	}

	public function co_adminMenu()
	{
		add_menu_page(
			 __('Rental Management', 'cohesion' ),
      __('Rental Management', 'cohesion' ),
      'manage_options',
      RM_MENU_SLUG,
      array($this, 'co_renderAdminPage'),
      'dashicons-admin-home',
     	100
		);

		add_submenu_page(
			RM_MENU_SLUG,
			__('Rental Management', 'cohesion' ),
			__('Rental Management', 'cohesion' ),
    	'manage_options',
    	RM_MENU_SLUG,
    	array($this, 'co_renderAdminPage')
    );

    add_submenu_page(
			RM_MENU_SLUG,
			__('Properties', 'cohesion' ),
			__('Properties', 'cohesion' ),
    	'manage_options',
    	RM_MENU_SLUG . '-properties',
    	array($this, 'co_renderPropertiesPage')
    );
	}

	public function co_renderAdminPage()
	{
		require_once(RM_TEMPLATE_DIR . '/admin-page.php');
	}

	public function co_renderPropertiesPage()
	{
		require_once(RM_TEMPLATE_DIR . '/properties.php');
	}

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