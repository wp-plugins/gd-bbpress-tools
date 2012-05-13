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
                    /*]]>*/
                </style>
            <?php } ?>
            <script type="text/javascript">
                /* <![CDATA[ */
                var gdbbPressToolsInit = {
                    quote_method: "<?php echo d4p_bbt_o('quote_method'); ?>",
                    quote_wrote: "<?php echo __("wrote", "gd-bbpress-tools"); ?>"
                };

                <?php if (d4p_bbt_o('include_js') == 1) { ?>
                    var gdbbPressTools={storage:{},init:function(){jQuery(".d4p-bbt-quote-link").live("click",function(e){e.preventDefault();var a=jQuery(this).attr("href").substr(1);var b='#d4p-bbp-quote-'+a;if(jQuery("#bbp_reply_content").length>0){var c=jQuery(b).html();c=c.replace(/&nbsp;/g," ");c=c.replace(/<p>/g,"");c=c.replace(/<\/\s*p>/g,"\n");if(gdbbPressToolsInit.quote_method=='bbcode'){c="[quote="+a+"]"+c+"[/quote]"}else{var d='<div class="d4p-quote-title"><a href="'+jQuery(this).attr("bbp-url")+'">';d+=jQuery(this).attr("bbp-author")+' '+gdbbPressToolsInit.quote_wrote+':</a></div>';c='<blockquote class="d4pbbc-quote">'+d+c+'</blockquote>'}var f=jQuery("#bbp_reply_content");var g=f.val();if(g.trim()!=''){c="\n\n"+c}f.val(g+c)}})}};jQuery(document).ready(function(){gdbbPressTools.init()});
                <?php } ?>
                /* ]]> */
            </script>
        <?php }
    }
}

global $gdbbpress_tools_front;
$gdbbpress_tools_front = new gdbbTls_Front();

?>