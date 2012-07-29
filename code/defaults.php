<?php

class gdbbPressTools_Defaults {
    var $default_options = array(
        'version' => '1.2.6',
        'date' => '2012.07.29.',
        'build' => 950,
        'status' => 'Stable',
        'product_id' => 'gd-bbpress-tools',
        'edition' => 'free',
        'revision' => 0,
        'include_always' => 0,
        'include_js' => 1,
        'include_css' => 1,
        'toolbar_active' => 1,
        'toolbar_super_admin' => 1,
        'toolbar_roles' => null,
        'admin_disable_active' => 0,
        'admin_disable_super_admin' => 1,
        'admin_disable_roles' => null,
        'quote_active' => 1,
        'quote_location' => 'header',
        'quote_method' => 'bbcode',
        'quote_super_admin' => 1,
        'quote_roles' => null,
        'bbcodes_active' => 1,
        'bbcodes_notice' => 1,
        'bbcodes_bbpress_only' => 0,
        'bbcodes_special_super_admin' => 1,
        'bbcodes_special_roles' => null,
        'bbcodes_special_action' => 'info',
        'signature_active' => 1,
        'signature_length' => 512,
        'signature_super_admin' => 1,
        'signature_roles' => null,
        'signature_method' => 'bbcode',
        'signature_enhanced_super_admin' => 1,
        'signature_enhanced_roles' => null,
        'view_mostreplies_active' => 1,
        'view_latesttopics_active' => 1,
        'view_searchresults_active' => 1
    );

    var $capabilities = array(
        'd4p_bbpt_toolbar',
        'd4p_bbpt_admin_disable',
        'd4p_bbpt_quote',
        'd4p_bbpt_bbcodes_special',
        'd4p_bbpt_signature',
        'd4p_bbpt_signature_enhanced'
    );

    function __construct() { }
}

?>