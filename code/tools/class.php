<?php

if (!defined('ABSPATH')) exit;

class gdbbPressTools {
    private $wp_version;
    private $plugin_path;
    private $plugin_url;

    public $l;
    public $o;

    function __construct() {
        $this->_init();
    }

    private function _upgrade($old, $new) {
        foreach ($new as $key => $value) {
            if (!isset($old[$key])) $old[$key] = $value;
        }

        $unset = Array();
        foreach ($old as $key => $value) {
            if (!isset($new[$key])) $unset[] = $key;
        }

        foreach ($unset as $key) {
            unset($old[$key]);
        }

        return $old;
    }

    private function _init() {
        global $wp_version;
        $this->wp_version = substr(str_replace(".", "", $wp_version), 0, 2);
        define("GDBBPRESSTOOLS_WPV", intval($this->wp_version));

        $gdd = new gdbbPressTools_Defaults();

        $this->o = get_option("gd-bbpress-tools");
        if (!is_array($this->o)) {
            $this->o = $gdd->default_options;
            update_option("gd-bbpress-tools", $this->o);
        }

        if ($this->o["build"] != $gdd->default_options["build"]) {
            $this->o = $this->_upgrade($this->o, $gdd->default_options);

            $this->o["version"] = $gdd->default_options["version"];
            $this->o["date"] = $gdd->default_options["date"];
            $this->o["status"] = $gdd->default_options["status"];
            $this->o["build"] = $gdd->default_options["build"];
            $this->o["revision"] = $gdd->default_options["revision"];
            $this->o["edition"] = $gdd->default_options["edition"];

            update_option("gd-bbpress-tools", $this->o);
        }

        define("GDBBPRESSTOOLS_INSTALLED", $gdd->default_options["version"]." Free");
        define("GDBBPRESSTOOLS_VERSION", $gdd->default_options["version"]."_b".($gdd->default_options["build"]."_free"));

        $this->plugin_path = dirname(dirname(dirname(__FILE__)))."/";
        $this->plugin_url = plugins_url("/gd-bbpress-tools/");

        define("GDBBPRESSTOOLS_URL", $this->plugin_url);
        define("GDBBPRESSTOOLS_PATH", $this->plugin_path);

        add_action('setup_theme', array($this, 'load'));
    }

    public function load() {
        add_action('init', array(&$this, 'load_translation'));

        if (GDBBPRESSTOOLS_WPV > 32 && $this->o['toolbar_active'] == 1 && d4p_bbt_is_role('toolbar')) {
            add_action('admin_bar_menu', array(&$this, 'admin_bar_menu'), 100);
            add_action('admin_head', array(&$this, 'admin_bar_icon'));
            add_action('wp_head', array(&$this, 'admin_bar_icon'));
        }

        if (is_admin()) {
            require_once(GDBBPRESSTOOLS_PATH.'code/admin.php');
        } else {
            require_once(GDBBPRESSTOOLS_PATH.'code/tools/front.php');
        }
        
        
    }

    public function admin_bar_icon() { ?>
        <style type="text/css">
            #wpadminbar .ab-top-menu > li.menupop.icon-gdbb-toolbar > .ab-item {
                background-image: url('<?php echo plugins_url('gd-bbpress-tools/gfx/menu.png'); ?>');
                background-repeat: no-repeat;
                background-position: 0.85em 50%;
                padding-left: 32px;
            }
        </style>
    <?php }

    public function admin_bar_menu($wp_admin_bar) {
        $wp_admin_bar->add_menu(array(
            'id'     => 'gdbb-toolbar',
            'title'  => __("Forums", "gd-bbpress-tools"),
            'href'   => get_post_type_archive_link('forum'),
            'meta'   => array('class' => 'icon-gdbb-toolbar')
        ));

        $wp_admin_bar->add_group(array(
            'parent' => 'gdbb-toolbar',
            'id'     => 'gdbb-toolbar-public'
        ));
        $wp_admin_bar->add_menu(array(
            'parent' => 'gdbb-toolbar-public',
            'id'     => 'gdbb-toolbar-forums',
            'title'  => __("Forums", "gd-bbpress-tools"),
            'href'   => get_post_type_archive_link('forum')
        ));

        $query = $forums_query = array(
			'post_parent'    => 0,
			'posts_per_page' => 24,
			'orderby'        => 'menu_order',
			'order'          => 'ASC'
                    );
        if (bbp_has_forums($query)) {
            while (bbp_forums()) {
                bbp_the_forum();

                $wp_admin_bar->add_menu(array(
                    'parent' => 'gdbb-toolbar-forums',
                    'id'     => 'gdbb-toolbar-forums-'.bbp_get_forum_id(),
                    'title'  => bbp_get_forum_title(),
                    'href'   => bbp_get_forum_permalink()
                ));
            }
        }
        
        if (bbp_get_views()) {
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-public',
                'id'     => 'gdbb-toolbar-views',
                'title'  => __("Views", "gd-bbpress-tools"),
                'href'   => get_post_type_archive_link('forum')
            ));
            foreach (bbp_get_views() as $view => $args) {
                $wp_admin_bar->add_menu(array(
                    'parent' => 'gdbb-toolbar-views',
                    'id'     => 'gdbb-toolbar-views-'.$view,
                    'title'  => bbp_get_view_title($view),
                    'href'   => bbp_get_view_url($view)
                ));
            }
        }

        if (current_user_can(GDBBPRESSTOOLS_CAP)) {
            $wp_admin_bar->add_group(array(
                'parent' => 'gdbb-toolbar',
                'id'     => 'gdbb-toolbar-admin'
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-admin',
                'id'     => 'gdbb-toolbar-new',
                'title'  => __("New", "gd-bbpress-tools"),
                'href'   => ''
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-new',
                'id'     => 'gdbb-toolbar-new-forum',
                'title'  => __("Forum", "gd-bbpress-tools"),
                'href'   => admin_url('post-new.php?post_type=forum')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-new',
                'id'     => 'gdbb-toolbar-new-topic',
                'title'  => __("Topic", "gd-bbpress-tools"),
                'href'   => admin_url('post-new.php?post_type=topic')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-new',
                'id'     => 'gdbb-toolbar-new-reply',
                'title'  => __("Reply", "gd-bbpress-tools"),
                'href'   => admin_url('post-new.php?post_type=reply')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-admin',
                'id'     => 'gdbb-toolbar-edit',
                'title'  => __("Edit", "gd-bbpress-tools"),
                'href'   => ''
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-edit',
                'id'     => 'gdbb-toolbar-edit-forums',
                'title'  => __("Forums", "gd-bbpress-tools"),
                'href'   => admin_url('edit.php?post_type=forum')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-edit',
                'id'     => 'gdbb-toolbar-edit-topics',
                'title'  => __("Topics", "gd-bbpress-tools"),
                'href'   => admin_url('edit.php?post_type=topic')
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-edit',
                'id'     => 'gdbb-toolbar-edit-replies',
                'title'  => __("Replies", "gd-bbpress-tools"),
                'href'   => admin_url('edit.php?post_type=reply')
            ));

            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-admin',
                'id'     => 'gdbb-toolbar-settings',
                'title'  => __("Settings", "gd-bbpress-tools"),
                'href'   => ''
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-settings',
                'id'     => 'gdbb-toolbar-settings-main',
                'title'  => __("bbPress Settings", "gd-bbpress-tools"),
                'href'   => admin_url('options-general.php?page=bbpress')
            ));
            $wp_admin_bar->add_group(array(
                'parent' => 'gdbb-toolbar-settings',
                'id'     => 'gdbb-toolbar-settings-third'
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-settings-third',
                'id'     => 'gdbb-toolbar-settings-third-tools',
                'title'  => __("GD bbPress Tools", "gd-bbpress-tools"),
                'href'   => admin_url('edit.php?post_type=forum&page=gdbbpress_tools')
            ));
            if (defined('GDBBPRESSATTACHMENTS_INSTALLED')) {
                $wp_admin_bar->add_menu(array(
                    'parent' => 'gdbb-toolbar-settings-third',
                    'id'     => 'gdbb-toolbar-settings-third-attachments',
                    'title'  => __("GD bbPress Attchments", "gd-bbpress-tools"),
                    'href'   => admin_url('edit.php?post_type=forum&page=gdbbpress_attachments')
                ));
            }

            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-admin',
                'id'     => 'gdbb-toolbar-tools',
                'title'  => __("Tools", "gd-bbpress-tools"),
                'href'   => ''
            ));
            $wp_admin_bar->add_menu(array(
                'parent' => 'gdbb-toolbar-tools',
                'id'     => 'gdbb-toolbar-tools-recount',
                'title'  => __("Recount", "gd-bbpress-tools"),
                'href'   => admin_url('tools.php?page=bbp-recount')
            ));
        }

        $wp_admin_bar->add_group(array(
            'parent' => 'gdbb-toolbar',
            'id'     => 'gdbb-toolbar-info',
            'meta'   => array('class' => 'ab-sub-secondary')
        ));
        $wp_admin_bar->add_menu(array(
            'parent' => 'gdbb-toolbar-info',
            'id'     => 'gdbb-toolbar-info-links',
            'title'  => __("Information", "gd-bbpress-tools")
        ));
        $wp_admin_bar->add_group(array(
            'parent' => 'gdbb-toolbar-info-links',
            'id'     => 'gdbb-toolbar-info-links-bbp',
            'meta'   => array('class' => 'ab-sub-secondary')
        ));
        $wp_admin_bar->add_group(array(
            'parent' => 'gdbb-toolbar-info-links',
            'id'     => 'gdbb-toolbar-info-links-d4p',
            'meta'   => array('class' => 'ab-sub-secondary')
        ));
        $wp_admin_bar->add_menu(array(
            'parent' => 'gdbb-toolbar-info-links-bbp',
            'id'     => 'gdbb-toolbar-bbp-home',
            'title'  => __("bbPress Homepage", "gd-bbpress-tools"),
            'href'   => 'http://bbpress.org/',
            'meta'   => array('target' => '_blank')
        ));
        
        $wp_admin_bar->add_menu(array(
            'parent' => 'gdbb-toolbar-info-links-d4p',
            'id'     => 'gdbb-toolbar-d4p-home',
            'title'  => __("Dev4Press Homepage", "gd-bbpress-tools"),
            'href'   => 'http://www.dev4press.com/',
            'meta'   => array('target' => '_blank')
        ));
    }

    public function load_translation() {
        $this->l = get_locale();

        if(!empty($this->l)) {
            load_plugin_textdomain('gd-bbpress-tools', false, 'gd-bbpress-tools/languages');
        }
    }
}

global $gdbbpress_tools;
$gdbbpress_tools = new gdbbPressTools();

?>