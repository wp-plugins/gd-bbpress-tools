<?php

if (!defined('ABSPATH')) exit;

class gdbbTls_Admin {
    function __construct() {
        add_action('after_setup_theme', array($this, 'load'));
    }

    public function load() {
        add_action('admin_init', array(&$this, 'admin_init'));

        if (d4p_bbt_o('admin_disable_active') == 1 && !d4p_bbt_is_role('admin_disable')) {
            add_action('bbp_init', array($this, 'admin_disable_access'), 8);
        }
    }

    public function admin_init() {
        if (isset($_POST['gdbb-tools-submit'])) {
            global $gdbbpress_tools;
            check_admin_referer('gd-bbpress-tools');

            $gdbbpress_tools->o['toolbar_active'] = isset($_POST['toolbar_active']) ? 1 : 0;
            $gdbbpress_tools->o['toolbar_super_admin'] = isset($_POST['toolbar_super_admin']) ? 1 : 0;
            $gdbbpress_tools->o['admin_disable_active'] = isset($_POST['admin_disable_active']) ? 1 : 0;
            $gdbbpress_tools->o['admin_disable_super_admin'] = isset($_POST['admin_disable_super_admin']) ? 1 : 0;
            $gdbbpress_tools->o['toolbar_roles'] = (array)$_POST['toolbar_roles'];
            $gdbbpress_tools->o['admin_disable_roles'] = (array)$_POST['admin_disable_roles'];

            update_option('gd-bbpress-tools', $gdbbpress_tools->o);
            wp_redirect(add_query_arg('settings-updated', 'true'));
            exit();
        }

        if (isset($_GET['page'])) {
            $this->admin_plugin = $_GET['page'] == 'gdbbpress_attachments';
        }

        if ($this->admin_plugin) {
            wp_enqueue_style('gd-bbpress-attachments', GDBBPRESSATTACHMENTS_URL."css/gd-bbpress-attachments_admin.css", array(), GDBBPRESSATTACHMENTS_VERSION);
        }
    }

    /** Based on the code by John James Jacoby from 'bbPress - No Admin' plugin:
     *  http://wordpress.org/extend/plugins/bbpress-no-admin/
     */
    public function admin_disable_access() {
        remove_action('admin_menu', 'bbp_admin_separator');
        remove_action('custom_menu_order', 'bbp_admin_custom_menu_order');
        remove_action('menu_order', 'bbp_admin_menu_order');

        add_filter('bbp_register_forum_post_type', array($this, 'admin_disable_post_type'));
        add_filter('bbp_register_topic_post_type', array($this, 'admin_disable_post_type'));
        add_filter('bbp_register_reply_post_type', array($this, 'admin_disable_post_type'));
    }

    public function admin_disable_post_type($args) {
        $args['show_in_nav_menus'] = false;
        $args['show_ui'] = false;
        $args['can_export'] = false;
        $args['capability_type'] = null;

        return $args;
    }
}

global $gdbbpress_tools_admin;
$gdbbpress_tools_admin = new gdbbTls_Admin();

?>