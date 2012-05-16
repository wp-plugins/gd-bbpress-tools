<?php

if (!defined('ABSPATH')) exit;

class gdbbTls_Front {
    function __construct() {
        add_action('after_setup_theme', array($this, 'load'), 10);
    }

    public function load() {
        add_action('bbp_head', array(&$this, 'bbp_head'));
    }

    public function bbp_head() { 
        if (d4p_bbt_o('include_always') == 1 || d4p_is_bbpress()) {
            wp_enqueue_script('jquery');

            if (d4p_bbt_o('include_css') == 1) { ?>
                <style type="text/css">
                    /*<![CDATA[*/
                    .d4p-bbt-quote-block { margin-top: 5px; padding-top: 5px; border-top: 1px solid #dddddd; text-align: right; }
                    .d4p-bbt-quote-title { font-weight: bold; padding-bottom: 2px; margin-bottom: 5px; border-bottom: 1px solid #dddddd; }
                    .bbp-signature { border-top: 1px solid #dddddd; margin-top: 15px; padding: 5px 0; }
                    /*]]>*/
                </style>
            <?php } ?>
            <script type="text/javascript">
                /* <![CDATA[ */
                var gdbbPressToolsInit = {
                    quote_method: "<?php echo d4p_bbt_o('quote_method'); ?>",
                    quote_wrote: "<?php echo __("wrote", "gd-bbpress-tools"); ?>",
                    bbpress_version: <?php echo d4p_bbpress_version(); ?>,
                    wp_editor: <?php echo  d4p_bbpress_version() > 20 ? (bbp_use_wp_editor() ? 1 : 0) : 0; ?>
                };

                <?php if (d4p_bbt_o('include_js') == 1) { ?>
                    var gdbbPressTools={storage:{},get_selection:function(){var t='';if(window.getSelection){t=window.getSelection()}else if(document.getSelection){t=document.getSelection()}else if(document.selection){t=document.selection.createRange().text}return t.toString().trim()},init:function(){jQuery(".d4p-bbt-quote-link").live("click",function(e){e.preventDefault();if(jQuery("#bbp_reply_content").length>0){var a=gdbbPressTools.get_selection();var b=jQuery(this).attr("href").substr(1);var c='#d4p-bbp-quote-'+b;if(a==''){a=jQuery(c).html()}a=a.replace(/&nbsp;/g," ");a=a.replace(/<p>/g,"");a=a.replace(/<\/\s*p>/g,"\n");if(gdbbPressToolsInit.quote_method=='bbcode'){a="[quote="+b+"]"+a+"[/quote]"}else{var d='<div class="d4p-bbp-quote-title"><a href="'+jQuery(this).attr("bbp-url")+'">';d+=jQuery(this).attr("bbp-author")+' '+gdbbPressToolsInit.quote_wrote+':</a></div>';a='<blockquote class="d4pbbc-quote">'+d+a+'</blockquote>'}if(gdbbPressToolsInit.wp_editor==1){tinyMCE.execInstanceCommand("bbp_reply_content","mceInsertContent",false,a)}else{var f=jQuery("#bbp_reply_content");var g=f.val();if(g.trim()!=''){a="\n\n"+a}f.val(g+a)}jQuery("html, body").animate({scrollTop:jQuery("#new-post").offset().top},1000)}})}};jQuery(document).ready(function(){gdbbPressTools.init()});
                <?php } ?>
                /* ]]> */
            </script>
        <?php }
    }
}

global $gdbbpress_tools_front;
$gdbbpress_tools_front = new gdbbTls_Front();

?>