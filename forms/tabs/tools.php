<?php if (isset($_GET["settings-updated"]) && $_GET["settings-updated"] == "true") { ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
    <p><strong><?php _e("Settings saved.", "gd-bbpress-tools"); ?></strong></p>
</div>
<?php } ?>

<form action="" method="post">
    <?php wp_nonce_field("gd-bbpress-tools"); ?>
    <div class="d4p-settings">
        <h3><?php _e("Quote Topics and Replies", "gd-bbpress-tools"); ?></h3>
        <p><?php _e("Add button to quote content for a topic and reply with the author and link. Can use BBCode quote type.", "gd-bbpress-tools"); ?></p>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="quote_active"><?php _e("Active", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <input type="checkbox" <?php if ($options["quote_active"] == 1) echo " checked"; ?> name="quote_active" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Button Location", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <select name="quote_location" class="regular-text">
                            <option value="header"<?php if ($options["quote_location"] == "header") echo ' selected="selected"'; ?>><?php _e("Reply or Topic header", "gd-bbpress-tools"); ?></option>
                            <option value="content"<?php if ($options["quote_location"] == "content") echo ' selected="selected"'; ?>><?php _e("Reply or Topic content", "gd-bbpress-tools"); ?></option>
                            <option value="both"<?php if ($options["quote_location"] == "both") echo ' selected="selected"'; ?>><?php _e("Both header and content", "gd-bbpress-tools"); ?></option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Quote Method", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <select name="quote_method" class="regular-text">
                            <option value="bbcode"<?php if ($options["quote_method"] == "bbcode") echo ' selected="selected"'; ?>><?php _e("BBCode", "gd-bbpress-tools"); ?></option>
                            <option value="html"<?php if ($options["quote_method"] == "html") echo ' selected="selected"'; ?>><?php _e("HTML", "gd-bbpress-tools"); ?></option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e("Available to", "gd-bbpress-tools") ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("Available to", "gd-bbpress-tools"); ?></span></legend>
                            <label for="quote_super_admin">
                                <input type="checkbox" <?php if ($options["quote_super_admin"] == 1) echo " checked"; ?> name="quote_super_admin" />
                                <?php _e("Super Admin", "gd-bbpress-tools"); ?>
                            </label><br/>
                            <?php foreach ($wp_roles->role_names as $role => $title) { ?>
                            <label for="quote_roles_<?php echo $role; ?>">
                                <input type="checkbox" <?php if (!isset($options["quote_roles"]) || is_null($options["quote_roles"]) || in_array($role, $options["quote_roles"])) echo " checked"; ?> value="<?php echo $role; ?>" id="quote_roles_<?php echo $role; ?>" name="quote_roles[]" />
                                <?php echo $title; ?>
                            </label><br/>
                            <?php } ?>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3><?php _e("Toolbar Menu", "gd-bbpress-tools"); ?></h3>
        <p><?php _e("Add menu to the WordPress toolbar with quick access to both admin and front end side forum related pages.", "gd-bbpress-tools"); ?></p>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="toolbar_active"><?php _e("Active", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <input type="checkbox" <?php if ($options["toolbar_active"] == 1) echo " checked"; ?> name="toolbar_active" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e("Show menu to", "gd-bbpress-tools") ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("Allow upload to", "gd-bbpress-tools"); ?></span></legend>
                            <label for="toolbar_super_admin">
                                <input type="checkbox" <?php if ($options["toolbar_super_admin"] == 1) echo " checked"; ?> name="toolbar_super_admin" />
                                <?php _e("Super Admin", "gd-bbpress-tools"); ?>
                            </label><br/>
                            <?php foreach ($wp_roles->role_names as $role => $title) { ?>
                            <label for="toolbar_roles_<?php echo $role; ?>">
                                <input type="checkbox" <?php if (!isset($options["toolbar_roles"]) || is_null($options["toolbar_roles"]) || in_array($role, $options["toolbar_roles"])) echo " checked"; ?> value="<?php echo $role; ?>" id="toolbar_roles_<?php echo $role; ?>" name="toolbar_roles[]" />
                                <?php echo $title; ?>
                            </label><br/>
                            <?php } ?>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d4p-settings-second">
        <!-- <h3><?php _e("User Signature", "gd-bbpress-tools"); ?></h3>
        <p><?php _e("Allow users to create signatures that will be included with their replies or topics. Control length and use of HTML or BBCodes.", "gd-bbpress-tools"); ?></p>-->
        <h3><?php _e("Limit bbPress access on admin side", "gd-bbpress-tools"); ?></h3>
        <p><?php _e("Select who can see and access admin side bbPress forums, topics and reply controls. Be careful with this feature.", "gd-bbpress-tools"); ?></p>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="admin_disable_active"><?php _e("Active", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <input type="checkbox" <?php if ($options["admin_disable_active"] == 1) echo " checked"; ?> name="admin_disable_active" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e("Roles with access", "gd-bbpress-tools") ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("User Roles", "gd-bbpress-tools"); ?></span></legend>
                            <label for="admin_disable_super_admin">
                                <input type="checkbox" <?php if ($options["admin_disable_super_admin"] == 1) echo " checked"; ?> name="admin_disable_super_admin" />
                                <?php _e("Super Admin", "gd-bbpress-tools"); ?>
                            </label><br/>
                            <?php foreach ($wp_roles->role_names as $role => $title) { ?>
                            <label for="admin_disable_roles_<?php echo $role; ?>">
                                <input type="checkbox" <?php if (!isset($options["admin_disable_roles"]) || is_null($options["admin_disable_roles"]) || in_array($role, $options["admin_disable_roles"])) echo " checked"; ?> value="<?php echo $role; ?>" id="admin_disable_roles_<?php echo $role; ?>" name="admin_disable_roles[]" />
                                <?php echo $title; ?>
                            </label><br/>
                            <?php } ?>
                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <h3><?php _e("JavaScript and CSS Settings", "gd-bbpress-tools"); ?></h3>
        <p><?php _e("You can disable including styles and JavaScript by the plugin, if you want to do it some other way.", "gd-bbpress-tools"); ?></p>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="include_js"><?php _e("Include JavaScript", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <input type="checkbox" <?php if ($options["include_js"] == 1) echo " checked"; ?> name="include_js" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="include_css"><?php _e("Include CSS", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <input type="checkbox" <?php if ($options["include_css"] == 1) echo " checked"; ?> name="include_css" />
                    </td>
                </tr>
            </tbody>
        </table>
        <p><?php _e("If you use shortcodes to embed forums, and you rely on plugin to add JS and CSS, you also need to enable this option to skip checking for bbPress specific pages.", "gd-bbpress-tools"); ?></p>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row"><label for="include_always"><?php _e("Always Include", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <input type="checkbox" <?php if ($options["include_always"] == 1) echo " checked"; ?> name="include_always" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d4p-clear"></div>
    <p class="submit"><input type="submit" value="<?php _e("Save Changes", "gd-bbpress-tools"); ?>" class="button-primary" id="gdbb-tools-submit" name="gdbb-tools-submit" /></p>
</form>
