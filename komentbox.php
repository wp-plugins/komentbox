<?php

require_once('wp-plugin.php');


if (!class_exists('NLPCaptcha')) {
    class NLPCaptcha extends WPPlugin {
        // member variables
        private $saved_error;
        
        // php 4 constructor
        function NLPCaptcha($options_name) {
            $args = func_get_args();
            call_user_func_array(array(&$this, "__construct"), $args);
        }
        
        // php 5 constructor
        function __construct($options_name) {
            parent::__construct($options_name);
            
            $this->register_default_options();
            
            
            // register the hooks
            $this->register_actions();
        }
        
        function register_actions() {
           
			// For front end
			if ($this->options['show_in_comments'])
				add_filter("comments_template", array(&$this, 'comments_template'));
			
			// For addintg css
			add_action('wp_head', array(&$this, 'comment_stylesheets')); // make unnecessary: instead, inform of classes for styling
			add_action('admin_head', array(&$this, 'comment_stylesheets')); // make unnecessary: shouldn't require styling in the options page
			// For admin
			add_action('admin_init', array(&$this, 'register_settings_group'));
			add_filter("plugin_action_links", array(&$this, 'show_settings_link'), 10, 2);
			add_action('admin_menu', array(&$this, 'add_settings_page'));
            add_action('admin_notices', array(&$this, 'missing_keys_notice'));
			
        }
        
		// User this for show koment box
		function comments_template($value)
		{
			return dirname(__FILE__) . '/comments.php';
		}



        
        // set the default options
        function register_default_options() {
		
			//print_r($this->options);
            if ($this->options)
               return;
           
            $option_defaults = array();
           
            $old_options = WPPlugin::retrieve_options("komentbox_options");
           
            if($old_options)
			{
               $option_defaults['publisherkey'] = $old_options['publisherkey']; // the public key for NLPCaptcha
               $option_defaults['validatekey'] = $old_options['validatekey']; // the private key for NLPCaptcha
			   $option_defaults['privatekey'] = $old_options['privatekey']; // the private key for NLPCaptcha
			   $option_defaults['show_in_comments'] = $old_options['re_comments']; // whether or not to show NLPCaptcha on the comment post
			}
			else
			{
               $option_defaults['publisherkey'] = ''; // the public key for NLPCaptcha
               $option_defaults['validatekey']='';
               $option_defaults['privatekey'] = ''; // the private key for NLPCaptcha
			   $option_defaults['show_in_comments'] = 1; // whether or not to show NLPCaptcha on the comment post
			}
            
            // add the option based on what environment we're in
            WPPlugin::add_options($this->options_name, $option_defaults);
        }
        
        
        
        // register the settings
        function register_settings_group() {
            register_setting("komentbox_options_group", 'komentbox_options', array(&$this, 'validate_options'));
        }
        
        
        /* below function for error check ans show */
        function nlpcaptcha_enabled() {
            return ($this->options['show_in_comments']);
        }
        
        function keys_missing() {
            return (empty($this->options['publisherkey']) || empty($this->options['validatekey'])|| empty($this->options['privatekey']));
        }
        
        function create_error_notice($message, $anchor = '') {
            $options_url = admin_url('options-general.php?page=wp-komentbox/komentbox.php') . $anchor;
            $error_message = sprintf(__($message . ' <a href="%s" title="WP-NLPCaptcha Options">Fix this</a>', 'nlpcaptcha'), $options_url);
            
            echo '<div class="error"><p><strong>' . $error_message . '</strong></p></div>';
        }
        
        function missing_keys_notice() {
            if ($this->nlpcaptcha_enabled() && $this->keys_missing()) {
                $this->create_error_notice('You enabled KomentBox, but some of the NLPCaptcha API Keys seem to be missing.');
            }
        }
        
        function validate_options($input) {
            // todo: keys seem to usually be 40 characters in length, verify and if confirmed, add to validation process
            $validated['publisherkey'] = trim($input['publisherkey']);
            $validated['validatekey'] = trim($input['validatekey']);
            $validated['privatekey'] = trim($input['privatekey']);
            
            $validated['show_in_comments'] = ($input['show_in_comments'] == 1 ? 1 : 0);
            return $validated;
        }
        
		/* above function for error check ans show */
		
		
        
        // add a settings link to the plugin in the plugin list
        function show_settings_link($links, $file) {
            if ($file == plugin_basename($this->path_to_plugin_directory() . '/wp-komentbox.php')) {
               $settings_title = __('Settings for this Plugin', 'komentbox');
               $settings = __('Settings', 'komentbox');
               $settings_link = '<a href="options-general.php?page=wp-komentbox/komentbox.php" title="' . $settings_title . '">' . $settings . '</a>';
               array_unshift($links, $settings_link);
            }
            
            return $links;
        }
        
        // add the settings page
        function add_settings_page() {
            // add the options page
            if ($this->environment == Environment::WordPressMU && $this->is_authority())
                add_submenu_page('wpmu-admin.php', 'WP-NLPCaptcha', 'WP-NLPCaptcha', 'manage_options', __FILE__, array(&$this, 'show_settings_page'));

            
            
            add_options_page('WP-NLPCaptcha', 'WP-NLPCaptcha', 'manage_options', __FILE__, array(&$this, 'show_settings_page'));
        }
        
        // store the xhtml in a separate file and use include on it
        function show_settings_page() {
            include("settings.php");
        }
        
        
		function comment_stylesheets() {
            $path = WPPlugin::url_to_plugin_directory() . '/komentbox.css';
                
            echo '<link rel="stylesheet" type="text/css" href="' . $path . '" />';
        }
		
        
        
       
    } // end class declaration
	
	
	function komentbox_page_identifier($post) {
    return $post->ID . ' ' . $post->guid;
}

	function komentbox_page_title($post) {
    $title = get_the_title($post);
    $title = strip_tags($title);
    return $title;
}

} // end of class exists clause

?>
