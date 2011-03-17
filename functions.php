<?php 
/**
 * @Author	Jonathon byrd
 * @link http://www.5twentystudios.com
 * @Package Wordpress
 * @SubPackage HTML5_Boilerplate
 * @copyright Proprietary Software, Copyright Byrd Incorporated. All Rights Reserved
 * @Since 1.0
 * 
 * 
 */

defined('ABSPATH') or die("Cannot access pages directly.");

/**
 * Initializing 
 * 
 * The directory separator is different between linux and microsoft servers.
 * Thankfully php sets the DIRECTORY_SEPARATOR constant so that we know what
 * to use.
 */
defined("DS") or define("DS", DIRECTORY_SEPARATOR);

/**
 * User Control Level
 * 
 * Allows the developer to hook into this system and set the access level for this plugin.
 * If the user does not have the capability to view this plguin, they may still be
 * able to view the default widget area. This will not cause problems with the script,
 * however the editing user will not be able to add or delete viewable pages to the 
 * widget.
 * 
 * @TODO need to set this to call get_option from the db
 * @TODO need to add this as a security check to every file
 */
defined("OMEGA_CURRENT_USER_CANNOT") or define("OMEGA_CURRENT_USER_CANNOT", (!current_user_can("edit_theme_options")) );

/**
 * Initializing 
 * 
 * The directory separator is different between linux and microsoft servers.
 * Thankfully php sets the DIRECTORY_SEPARATOR constant so that we know what
 * to use.
 */
defined("OMEGA_VERSION") or define("OMEGA_VERSION", '1.0.0');

/**
 * Bootstrapping
 * 
 * This section loads all of the necessary files to properly initialize 
 * this theme
 */
require_once dirname(__file__).DS."lib".DS."bootstrap.php";
require_once dirname(__file__).DS."lib".DS."omega.php";
require_once dirname(__file__).DS."lib".DS."template-codes.php";
require_once dirname(__file__).DS."lib".DS."widgets.php";

/**
 * Initialize the Framework
 * 
 */
omega_initialize();

