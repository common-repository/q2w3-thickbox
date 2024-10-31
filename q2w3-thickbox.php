<?php
/*
Plugin Name: Q2W3 Thickbox
Plugin URI: http://www.q2w3.ru/en/2009/11/29/748/
Description: This plugin enables thickbox pop-up window on thumbnail images. Works with standalone pictures and wordpress galleries.
Version: 1.1.2
Author: Max Bond
Author URI: http://www.q2w3.ru/
*/



if (defined('ABSPATH') && defined('WPINC')) {

	register_activation_hook(__FILE__, array('q2w3_thickbox', 'activate')); 

	register_deactivation_hook(__FILE__, array('q2w3_thickbox', 'de_activate'));

	add_action('init', array('q2w3_thickbox','reg_hooks')); // reg plugin actions
	
}

/**
 * @author Max Bond
 * 
 * Main plugin class
 *
 */
class q2w3_thickbox {

	const ID = 'q2w3_thickbox'; // plugin ID
		
	const NAME = 'Q2W3 Thickbox'; // plugin name
		
	const LANG_DIR = 'languages'; // languages folder name
	
	const TOOLTIP_DIR = 'tooltip'; // tooltip files folder
	
	const TOOLTIP_JS = 'tooltip.js'; // tooltip js
	
	const TOOLTIP_CSS = 'tooltip.css'; // tooltip css
	
	const SETTINGS_FILE = 'q2w3-thickbox-settings.php'; // settings page file
	
	const SETTINGS_AL = 8; // settings page access level // 8 for admin
	
	
	const PHP_VER = '5.0.0'; // minimal php version
	
	const WP_VER = '2.8.0'; // minimal wp version
		
	
	// default settings
	
	const CLASS_SETTER = 'jQuery(".post a img").parent("a").addClass("thickbox");';
	
	const TITLE_SETTER = 'jQuery(".post a img").each(function () {jQuery(this).parent("a").attr("title", jQuery(this).attr("alt"));});';
	
	const GALLERY_SETTER = 'jQuery(".gallery-icon a").attr("rel", "gallery");';
	
	
	public static $plugin_page;
	
	
	/**
	 * Activate plugin function
	 * Checks wp and php versions and creates plugin options in db
	 */
	public static function activate() {
	
		if (self::php_version_check() && self::wp_version_check()) {
	
			$default_options = array('class_setter'=>self::CLASS_SETTER, 'title_setter'=>self::TITLE_SETTER, 'gallery_setter'=>self::GALLERY_SETTER);
			
			add_option(self::ID, $default_options, '', 'no');
	
		}
	
	}
	
	/**
	 * PHP version check
	 * 
	 */
	public static function php_version_check() {
	
		if (version_compare(phpversion(), self::PHP_VER, '<')) {
    
			deactivate_plugins(plugin_basename(__FILE__));
    
			wp_die(__('PHP version', self::ID) . ' ('. PHP_VERSION .') ' . __('is incompatible with this plugin. You need at least version', self::ID) . ' ' . self::PHP_VER);

		} else {
		
			return true;
		
		}
	
	}
	
	/**
	 * WP version check
	 * 
	 */
	public static function wp_version_check() {
	
		global $wp_version;
		
		if (version_compare($wp_version, self::WP_VER, '<')) {
    
			deactivate_plugins(plugin_basename(__FILE__));
    
			wp_die(__('Wordpress version', self::ID) . ' ('. $wp_version .') ' . __('is incompatible with this plugin. You need at least version', self::ID) . ' ' . self::WP_VER);
		
		} else {
		
			return true;
		
		}
	
	}
	
	/**
	 * Deactivate plugin function
	 * Deletes plugin options from db
	 * 
	 */
	public static function de_activate() {
	
		delete_option(self::ID);
	
	}
	
	/**
	 * Registers plugin functions in wp core
	 * 
	 */
	public static function reg_hooks() {
	
		if (is_admin()) { // admin actions

			add_action('admin_menu', array(__CLASS__, 'reg_menu')); // creates admin menu entry

			add_filter('plugin_action_links_'.plugin_basename(__FILE__), array(__CLASS__,'reg_control_links')); // chenge default plugin links
	
			add_action('admin_init', array(__CLASS__,'reg_settings')); // registers settings
			
			self::load_language(); // language file loading

		}	else { 
		
			add_action('wp', array(__CLASS__, 'libraries'));
		
			add_action('wp_head', array(__CLASS__, 'setters'));

			add_action('wp_footer', array(__CLASS__, 'graphics_support'));
		
		}	 
	
	}
	
	/**
	 * Registers admin menu entry
	 * 
	 */
	public static function reg_menu() {
	
		$plugin_page = add_submenu_page('plugins.php', self::NAME, self::NAME, self::SETTINGS_AL, plugin_basename(__FILE__), array(__CLASS__,'settings_page')); // creates menu item under plugins section
				
		//add_options_page(self::NAME, self::NAME, self::OPTIONS_PAGE_AL, plugin_basename(__FILE__), array(__CLASS__,'settings_page')); // creates menu item under options section
		
		self::$plugin_page = $plugin_page;
		
		add_action('contextual_help_list', array(__CLASS__, 'help'));
		
		if (isset($_GET["page"]) && $_GET["page"] == plugin_basename(__FILE__)) self::settings_page_css_js();
		
	}
	
	/**
	 * Adds link to plugin home page to the Help section of settings page
	 * 
	 * @param array $help_content
	 * @return array
	 */
	public static function help($help_content) {
		
		$help_content[self::$plugin_page] = '<a href="http://www.q2w3.ru/2009/11/29/748/">'. __('Q2W3 Thickbox Homepage', self::ID) .'</a>';
		
		return $help_content;
		
	}
	
	/**
	 * Loads css and js needed by plugin settings page
	 * 
	 */
	public static function settings_page_css_js() {
	
		wp_enqueue_style(self::ID, WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)).'/'.self::TOOLTIP_DIR.'/'.self::TOOLTIP_CSS);
		
		wp_enqueue_script(self::ID, WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)).'/'.self::TOOLTIP_DIR.'/'.self::TOOLTIP_JS);
	
	}
	
	/**
	 * Chenges default plugin links
	 * 
	 * @param array $links
	 * @return array
	 */
	public static function reg_control_links($links) {
	
		$settings_link = '<a href="plugins.php?page='.plugin_basename(__FILE__).'">'. __('Settings') .'</a>';
		
		array_unshift($links,$settings_link); // before other links
		
		return $links;
	
	}
	
	/**
	 * Registers settings (needed for settings update)
	 * 
	 */
	public static function reg_settings() {
	
		register_setting(self::ID, self::ID);
  	
	}
	
	/**
	 * Loads language files
	 * 
	 */
	public static function load_language() {
	
		$currentLocale = get_locale();
	
		if (!empty($currentLocale)) {
				
			$moFile = dirname(__FILE__).'/'.self::LANG_DIR.'/'.$currentLocale.".mo";
		
			if (@file_exists($moFile) && is_readable($moFile)) load_textdomain(self::ID, $moFile);
			
		}
	
	}
	
	/**
	 * Loads jQuery and thickbox libraries
	 * 
	 */
	public static function libraries() {
	
		wp_enqueue_style('thickbox'); // inserting style sheet for Thickbox
  
		wp_enqueue_script('jquery'); // including jquery
  
		wp_enqueue_script('thickbox'); // including Thickbox javascript
		
	}
	
	/**
	 * Outputs js code for setting thickbox classes and attributes
	 * 
	 */
	public static function setters() {
	
		$options = get_option(self::ID);

		$js = PHP_EOL."<!--q2w3 thickbox :: js begin-->
<script type='text/javascript'>
jQuery(document).ready(function(){
". $options['class_setter'] ."
". $options['title_setter'] ."
". $options['gallery_setter'] ."
});
</script>
<!--q2w3 thickbox :: js end-->";

	echo $js;
	
	}
	
	/**
	 * Changes default thickbox image path to load thickbox windows images on public pages
	 * 
	 */
	public static function graphics_support() {
	
		$includes_url = includes_url();
		
		echo '<script type=\'text/javascript\'>var tb_pathToImage = "'.$includes_url.'js/thickbox/loadingAnimation.gif";var tb_closeImage = "'.$includes_url.'js/thickbox/tb-close.png";</script>';
	
	}
		
	/**
	 * Loads plugin settings page
	 * 
	 */
	public static function settings_page() {
	
		require_once(self::SETTINGS_FILE);
	
	}
	
}

?>