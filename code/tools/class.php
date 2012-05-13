<?php

if (!defined('ABSPATH')) exit;

class gdbbPressTools {
    private $wp_version;
    private $plugin_path;
    private $plugin_url;

    public $l;
    public $o;

    public $mod = array('a' => null, 's' => null, 'q' => null, 't' => null);

    function __construct() {
        $this->_init();
    }

    private function _upgrade($old, $new) {
        foreach ($new as $key => $value) {
            if (!isset($old[$key])) $old[$key] = $value;
        }

        $unset = array();
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

        add_action('setup_theme', array($this, 'mods'));
        add_action('setup_theme', array($this, 'load'));
    }

    public function mods() {
        if (is_admin() && $this->o['admin_disable_active'] == 1 && !d4p_bbt_is_role('admin_disable')) {
            require_once(GDBBPRESSTOOLS_PATH.'code/mods/access.php');

            $this->mod['a'] = new gdbbTls_Access();
        }

        if ($this->o['bbcodes_active'] == 1) {
            require_once(GDBBPRESSTOOLS_PATH.'code/mods/shortcodes.php');

            $this->mod['s'] = new gdbbTls_Shortcodes(
                    $this->o['bbcodes_bbpress_only'] == 1, 
                    !d4p_bbt_is_role('bbcodes_special'));
        }

        if ($this->o['quote_active'] == 1) {
            require_once(GDBBPRESSTOOLS_PATH.'code/mods/quote.php');

            $this->mod['q'] = new gdbbTls_Quote(
                    $this->o['quote_location'], 
                    $this->o['quote_method'], 
                    d4p_bbt_is_role('quote'));
        }

        if (GDBBPRESSTOOLS_WPV > 32 && $this->o['toolbar_active'] == 1 && d4p_bbt_is_role('toolbar')) {
            require_once(GDBBPRESSTOOLS_PATH.'code/mods/toolbar.php');

            $this->mod['t'] = new gdbbTls_Toolbar();
        }
    }

    public function load() {
        add_action('init', array(&$this, 'load_translation'));

        if (is_admin()) {
            require_once(GDBBPRESSTOOLS_PATH.'code/admin.php');
        } else {
            require_once(GDBBPRESSTOOLS_PATH.'code/tools/front.php');
        }
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