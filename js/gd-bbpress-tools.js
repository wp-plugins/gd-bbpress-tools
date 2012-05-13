/*jslint regexp: true, undef: true, sloppy: true, eqeq: true, vars: true, white: true, plusplus: true, maxerr: 50, indent: 4 */

var gdbbPressTools = {
    storage: { },
    init: function() {
        jQuery(".d4p-bbt-quote-link").live("click", function(e){
            e.preventDefault();

            var id = jQuery(this).attr("href").substr(1);
            var quote_id = '#d4p-bbp-quote-' + id;

            if (jQuery("#bbp_reply_content").length > 0) {
                var qout = jQuery(quote_id).html();

                qout = qout.replace(/&nbsp;/g, " ");
                qout = qout.replace(/<p>/g, "");
		qout = qout.replace(/<\/\s*p>/g, "\n");

                if (gdbbPressToolsInit.quote_method == 'bbcode') {
                    qout = "[quote=" + id + "]" + qout + "[/quote]";
                } else {
                    var title = '<div class="d4p-bbp-quote-title"><a href="' + jQuery(this).attr("bbp-url") + '">';
                    title+= jQuery(this).attr("bbp-author") + ' ' + gdbbPressToolsInit.quote_wrote + ':</a></div>';
                    qout = '<blockquote class="d4pbbc-quote">' + title + qout + '</blockquote>';
                }

                var txtr = jQuery("#bbp_reply_content");
                var cntn = txtr.val();

                if (cntn.trim() != '') {
                    qout = "\n\n" + qout;
                }

                txtr.val(cntn + qout);
            }
        });
    }
};

jQuery(document).ready(function() {
    gdbbPressTools.init();
});