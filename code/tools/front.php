<?php

if (!defined('ABSPATH')) exit;

class gdbbMod_Front {
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
                    wp_editor: <?php echo d4p_bbpress_version() > 20 ? (bbp_use_wp_editor() ? 1 : 0) : 0; ?>
                };

                <?php if (d4p_bbt_o('include_js') == 1) { ?>
                    var gdbbPressTools={storage:{},get_selection:function(){var t='';if(window.getSelection){t=window.getSelection()}else if(document.getSelection){t=document.getSelection()}else if(document.selection){t=document.selection.createRange().text}return jQuery.trim(t.toString())},init:function(){jQuery(".d4p-bbt-quote-link").live("click",function(e){e.preventDefault();if(jQuery("#bbp_reply_content").length>0){var qout=gdbbPressTools.get_selection();var id=jQuery(this).attr("href").substr(1);var quote_id='#d4p-bbp-quote-'+id;if(qout==''){qout=jQuery(quote_id).html()}qout=qout.replace(/&nbsp;/g," ");qout=qout.replace(/<p>/g,"");qout=qout.replace(/<\/\s*p>/g,"\n");if(gdbbPressToolsInit.quote_method=='bbcode'){qout="[quote="+id+"]"+qout+"[/quote]"}else{var title='<div class="d4p-bbp-quote-title"><a href="'+jQuery(this).attr("bbp-url")+'">';title+=jQuery(this).attr("bbp-author")+' '+gdbbPressToolsInit.quote_wrote+':</a></div>';qout='<blockquote class="d4pbbc-quote">'+title+qout+'</blockquote>'}if(gdbxRender_Data.wp_editor==1&&!jQuery("#bbp_reply_content").is(":visible")){tinyMCE.execInstanceCommand("bbp_reply_content","mceInsertContent",false,qout)}else{var txtr=jQuery("#bbp_reply_content");var cntn=txtr.val();if(jQuery.trim(cntn)!=''){qout="\n\n"+qout}txtr.val(cntn+qout)}var old_ie=jQuery.browser.msie&&parseInt(jQuery.browser.version)<9;if(!old_ie){jQuery("html, body").animate({scrollTop:jQuery("#new-post").offset().top},1000)}else{document.location.href="#new-post"}}})}};jQuery(document).ready(function(){gdbbPressTools.init()});
                <?php } ?>
                /* ]]> */
            </script>
        <?php }
    }
}

global $gdbbpress_tools_front;
$gdbbpress_tools_front = new gdbbMod_Front();

?>