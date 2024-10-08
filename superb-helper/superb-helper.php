<?php
/*
Plugin Name: Superb Helper
Description: Superb Helper is your personal WordPress assistant.
Version: 1.2.0
Author: SuPlugins
Author URI: https://superbthemes.com/
Author URI:
License: GPL2
*/


namespace spbhlpr;

if (!defined('WPINC')) {
    die;
}

if (!defined('SUPERBHELPER_BASE_PATH')) {
    define('SUPERBHELPER_BASE_PATH', __FILE__);
}

if (!defined('SUPERBHELPER_PATH')) {
    define('SUPERBHELPER_PATH', untrailingslashit(plugins_url('', SUPERBHELPER_BASE_PATH)));
}
if (!defined('SUPERBHELPER_PLUGIN_DIR')) {
    define('SUPERBHELPER_PLUGIN_DIR', untrailingslashit(dirname(SUPERBHELPER_BASE_PATH)));
}


//Autoload
require_once SUPERBHELPER_PLUGIN_DIR . '/vendor/autoload.php';

use spbhlpr_plugin;
use spbhlpr\Notices\NoticeController;

$spbhlpr = spbhlpr::GetInstance();
$spbhlpr->init();






class spbhlpr
{
    /// name, prefix, version
    private $plugin_info = array('Superb Helper', 'spbhlpr', '1.2.0');
    private static $instance;

    public static function GetInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        require_once plugin_dir_path(__FILE__) . 'inc/plugin.php';
        $this->spbhlpr_setupPlugin();
        add_filter('plugin_row_meta', array($this, 'spbhlpr_add_plugin_meta_links'), 10, 2);
        new NoticeController();
    }

    public function spbhlpr_setupPlugin()
    {
        $base = array(plugin_dir_url(__FILE__), plugin_dir_path(__FILE__), plugin_dir_path(__DIR__));
        $plugin_instance = new spbhlpr_plugin($this->plugin_info, $base);
        register_deactivation_hook(__FILE__, array($this, 'spbhlpr_deactivate'));

        add_action('customize_register', array($this, 'spbhlpr_customize_register'));
    }

    public function spbhlpr_deactivate()
    {
        NoticeController::CleanUp();
    }

    public function spbhlpr_add_plugin_meta_links($meta_fields, $file)
    {
        if (plugin_basename(__FILE__) == $file) {
            $meta_fields[] = "<a href='" . admin_url('admin.php?page=' . $this->plugin_info[1]) . "'><strong>Guides & Plugins</strong></a>";
        }

        return $meta_fields;
    }

    public function spbhlpr_customize_register($manager)
    {
        $manager->add_section('spbhlpr_install_plugins', array(
            'title'      => __('Get Started', 'spbhlpr'),
            'priority'   => 0,
            'capability' => 'edit_theme_options',
        ));

        $manager->add_setting('spbhlpr_get_started', array(
            'default' => 0,
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $manager->add_control('spbhlpr_get_started', array(
            'label'    => __('', 'spbhlpr'),
            'description'    => __('Get started by installing the recommended plugins & read relevant guides and tutorials!', 'spbhlpr'),
            'section'  => 'spbhlpr_install_plugins',
            'priority' => 1,
            'settings' => array(),
            'type'     => 'button',
            'input_attrs' => array(
                'value' => __('Install Plugins', 'spbhlpr'),
                'onclick' => "window.open('" . admin_url('admin.php?page=' . $this->plugin_info[1]) . "')",
                'class' => 'button button-primary',
                'style' => 'margin-top:20px;text-align: center; font-size: 14px; font-weight: bold; padding: 4px; float: none; width: 100%; background: #1fc76e; border-color: #1fc76e;height: 40px;box-shadow: 0px 0px 0px;text-shadow: 0px 0px 0px;-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;',
            ),
        ));


        $manager->add_setting('spbhlpr_get_started_guides', array(
            'default' => 0,
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $manager->add_control('spbhlpr_get_started_guides', array(
            'label'    => __('', 'spbhlpr'),
            'section'  => 'spbhlpr_install_plugins',
            'priority' => 1,
            'settings' => array(),
            'type'     => 'button',
            'input_attrs' => array(
                'value' => __('Read Guides', 'spbhlpr'),
                'onclick' => "window.open('" . admin_url('admin.php?page=' . $this->plugin_info[1]) . "')",
                'class' => 'button button-primary',
                'style' => 'margin-top:5px;text-align: center; font-size: 14px; font-weight: bold; padding: 4px; float: none; width: 100%; background: #1fc76e; border-color: #1fc76e;height: 40px;box-shadow: 0px 0px 0px;text-shadow: 0px 0px 0px;-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;',
            ),
        ));
    }
}
