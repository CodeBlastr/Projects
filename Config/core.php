<?php 
class ProjectsConfig {

	/**
	 * Current version: [insert url here]
	 *
	 * @access public
	 * @var string
	 */
	var $version = '0.01';

	/**
	 * Settings.
	 *
	 * @access public
	 * @var array
	 */
	var $settings = array();

	/**
	 * Singleton Instance.
	 *
	 * @access private
	 * @var array
	 * @static
	 */
	private static $__instance;

	
	/**
	 * Load the settings from the ini file.
	 *
	 * @access private
	 * @return void
	 */
	function __construct() {
		if (empty($this->settings)) {
			if (defined('__PROJECTS_SETTINGS_PATH')) {
				$settingsPath = APP_DIR.__PROJECTS_SETTINGS_PATH;
			} else {
				define('__PROJECTS_SETTINGS_PATH', dirname(__FILE__) . DS);
				$settingsPath = __PROJECTS_SETTINGS_PATH;
			}
			$this->settings = __setConstants($settingsPath, true);
		}
	}

	/**
	 * Grab the current object instance.
	 * 
	 * @access public
	 * @return object
	 * @static
	 */
	public static function getInstance() {
		if (empty(self::$__instance)) {
			self::$__instance = new ProjectsConfig();
		}
		
		return self::$__instance;
	}

}
