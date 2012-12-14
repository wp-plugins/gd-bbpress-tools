<div>
    <label for="signature"><?php _e("Forum Signature", "gd-bbpress-tools"); ?></label>
    <textarea name="signature" id="signature" rows="5" cols="30" tabindex="<?php bbp_tab_index(); ?>"><?php echo esc_attr($bbx_user_signature); ?></textarea><br/>
    <span class="description">
        <?php echo sprintf(__("Signature length is limited to %s characters.", "gd-bbpress-tools"), $this->max_length); ?>
    </span>
</div>
