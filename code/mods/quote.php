<?php

if (!defined('ABSPATH')) exit;

class gdbbMod_Quote {
    private $header = false;

    private $location = 'header';
    private $method = 'quote';
    private $allowed = true;

    function __construct($location, $method, $allowed) {
        $this->location = $location;
        $this->method = $method;
        $this->allowed = $allowed;

        add_action('init', array($this, 'init'));
    }

    private function _quote() {
        $id = bbp_get_reply_id();

        if (d4p_bbt_o('quote_method') == 'html') {
            $url = bbp_get_reply_url($id);
            $ath = bbp_get_reply_author_display_name($id);
            return '<a href="#'.$id.'" bbp-url="'.$url.'" bbp-author="'.$ath.'" class="d4p-bbt-quote-link">Quote</a>';
        } else {
            return '<a href="#'.$id.'" class="d4p-bbt-quote-link">Quote</a>';
        }
    }

    public function init() {
        add_filter('bbp_get_reply_content', array(&$this, 'quote_content'));

        if ($this->location == 'header' || $this->location == 'both') {
            add_filter('bbp_get_topic_admin_links', array(&$this, 'reply_links'), 10, 2);
            add_filter('bbp_get_reply_admin_links', array(&$this, 'reply_links'), 10, 2);
            add_action('bbp_theme_after_reply_admin_links', array(&$this, 'after_reply_links'));
        }

        if ($this->location == 'content' || $this->location == 'both') {
            add_filter('bbp_get_reply_content', array(&$this, 'reply_content'));
        }
    }

    public function quote_content($content) {
        return '<div id="d4p-bbp-quote-'.bbp_get_reply_id().'">'.$content.'</div>';
    }

    public function reply_links($content, $args) {
        $this->header = true;

        $after = isset($args['after']) ? $args['after'] : '</span>';
        $sep = isset($args['sep']) ? $args['sep'] : ' | ';

        return substr($content, 0, strlen($content) - strlen($after)).$sep.$this->_quote().$after;
    }

    public function after_reply_links() {
        if (!$this->header) {
            $this->header = true;

            echo '<span class="bbp-admin-links">'.$this->_quote().'</span>';
        }
    }

    public function reply_content($content) {
        return $content.'<div class="d4p-bbt-quote-block">'.$this->_quote().'</div>';
    }
}

?>