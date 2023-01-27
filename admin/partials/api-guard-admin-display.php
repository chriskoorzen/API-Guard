<?php
/**
 * Admin area UI for the plugin
 */
?>

<?php $current_options = get_option(API_Guard_Constants::PLUGIN_MAIN_OPTIONS); ?>

<div class="api_guard page_body">
    <h1 class="api_guard">API Guard Dashboard</h1>
    
    <div class="api_guard sub_menu">
        <h2 class="api_guard sub_menu">API Guard Basic Settings</h2>
        <form action='' method='post' target='_self' class="api_guard">
            
            <?php wp_nonce_field( $this->admin_form_nonce ) ?>

            <?php foreach ( $current_options as $module => $option ): ?>

                <div class="api_guard menu_item">
                    <div class="api_guard boolean_option">
                        <input class="api_guard" type="checkbox" <?php echo ($option) ? 'checked':'' ?> id="<?= $module ?>" name="<?= $module ?>" >
                        <label class="api_guard" for="<?= $module ?>" >Enable <?= $module::pretty_name() ?></label>
                    </div>
                    <p class="api_guard menu_item_description"><?= $module::description() ?></p>
                </div>

            <?php endforeach ?>

            <input class="api_guard confirm_button" type="submit" value="Save Changes">
        </form>
    </div>

</div>
