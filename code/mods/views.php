<?php

if (!defined('ABSPATH')) exit;

class gdbbTls_Views {
    public $views;

    function __construct($views) {
        $this->views = $views;

        add_action('bbp_register_views', array(&$this, 'register_views'));
        add_filter('bbp_get_view_query_args', array(&$this, 'modify_search'), 10, 2);
    }

    public function modify_search($query, $view) {
        if ($view == 'search') {
            $search = isset($_GET['s']) ? trim($_GET['s']) : '';
            $forum = isset($_GET['f']) ? intval($_GET['f']) : '';

            if ($search != '') {
                $query['s'] = $search;

                if ($forum != '') {
                    $query['post_parent'] = $forum;
                }
            } else {
                $query['post_type'] = 'd4p_nothing_to_find_here';
            }
        }

        return $query;
    }

    public function register_views() {
        foreach ($this->views as $view => $args) {
            if ($args['active'] == 1) {
                $fnc = '_view_'.$view;
                $this->$fnc($args);
            }
        }
    }

    private function _view_mostreplies($args) {
        bbp_register_view(
                'most-replies',
                __("Topics with most replies", "gd-bbpress-tools"), 
                array('meta_key' => '_bbp_reply_count', 'orderby' => 'meta_value_num'), 
                false);
    }

    private function _view_latesttopics($args) {
        bbp_register_view(
                'latest-topics', 
                __("Latest topics", "gd-bbpress-tools"), 
                array('orderby' => 'post_date'), 
                false);
    }

    private function _view_searchresults($args) {
        bbp_register_view(
                'search', 
                __("Search Results", "gd-bbpress-tools"), 
                array(), 
                false);
    }
}

?>