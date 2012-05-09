<?php if (isset($_GET["settings-updated"]) && $_GET["settings-updated"] == "true") { ?>
<div class="updated settings-error" id="setting-error-settings_updated"> 
    <p><strong><?php _e("Settings saved.", "gd-bbpress-tools"); ?></strong></p>
</div>
<?php } ?>

<form action="" method="post">
    <?php wp_nonce_field("gd-bbpress-tools"); ?>
    <div class="d4p-settings">
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
                    <th scope="row"><label for="toolbar_super_admin"><?php _e("Show to Super Admin", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <input type="checkbox" <?php if ($options["toolbar_super_admin"] == 1) echo " checked"; ?> name="toolbar_super_admin" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e("Show menu to", "gd-bbpress-tools") ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("Allow upload to", "gd-bbpress-tools"); ?></span></legend>
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
                    <th scope="row"><label for="admin_disable_super_admin"><?php _e("Super Admin access", "gd-bbpress-tools"); ?></label></th>
                    <td>
                        <input type="checkbox" <?php if ($options["admin_disable_super_admin"] == 1) echo " checked"; ?> name="admin_disable_super_admin" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e("Roles with access", "gd-bbpress-tools") ?></th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php _e("User Roles", "gd-bbpress-tools"); ?></span></legend>
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
    </div>
    <div class="d4p-clear"></div>
    <p class="submit"><input type="submit" value="<?php _e("Save Changes", "gd-bbpress-tools"); ?>" class="button-primary" id="gdbb-tools-submit" name="gdbb-tools-submit" /></p>
</form>
