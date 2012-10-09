<?php

if (!defined('ABSPATH')) exit;

class gdbbMod_Signature {
    public $max_length;
    public $enhanced;
    public $method;

    function __construct($max_length = 512, $enhanced = true, $method = 'bbcode') {
        $this->max_length = $max_length;
        $this->enhanced = $enhanced;
        $this->method = $method;

        add_action('init', array($this, 'init'));
    }

    public function init() {
        add_action('show_user_profile', array(&$this, 'editor_form_profile'));
        add_action('edit_user_profile', array(&$this, 'editor_form_profile'));

        add_action('edit_user_profile_update', array($this, 'editor_save'));
        add_action('personal_options_update', array($this, 'editor_save'));

        add_action('bbp_user_edit_after', array(&$this, 'editor_form_bbpress'));
        add_action('bbp_user_edit_signature_info', array(&$this, 'signature_info'));
        add_filter('bbp_get_reply_content', array(&$this, 'reply_content'), 10000);
    }

    public function editor_form_profile() {
        $form = apply_filters('d4p_bbpresstools_signature_editor_file', GDBBPRESSTOOLS_PATH.'forms/tools/signature_profile.php');
        include_once($form);
    }

    public function editor_form_bbpress() {
        $form = apply_filters('d4p_bbpresstools_signature_editor_file', GDBBPRESSTOOLS_PATH.'forms/tools/signature_bbpress.php');
        include_once($form);
    }

    public function signature_info() {
        if ($this->method == 'off') {
            _e("You can use only plain text. HTML and BBCode will be stripped.", "gd-bbpress-tools");
        } else if ($this->method == 'bbcode') {
            _e("You can use BBCodes. HTML will be stripped.", "gd-bbpress-tools");
        } else if ($this->method == 'html') {
            _e("You can use HTML. BBCodes will be stripped if the BBCodes support is disabled.", "gd-bbpress-tools");
        }
    }

    public function format_signature($sig) {
        if ($this->method != 'html') {
            $sig = strip_tags($sig);
        }

        if ($this->method != 'bbcode') {
            $sig = strip_shortcodes($sig);
        }

        if (strlen($sig) > $this->max_length) {
            $sig = substr($sig, 0, $this->max_length);
        }

        return trim($sig);
    }

    public function editor_save($user_id) {
        $sig = $_POST['signature'];
        $sig = $this->format_signature($sig);

        update_user_meta($user_id, 'signature', $sig);
    }

    public function reply_content($content) {
        global $post;
        $user_id = $post->post_author;

        $sig = get_user_meta($user_id, 'signature', true);
        $sig = $this->format_signature($sig);

        if ($sig != '') {
            $content.= '<div class="bbp-signature">'.do_shortcode($sig).'</div>';
        }

        return $content;
    }
}

?>