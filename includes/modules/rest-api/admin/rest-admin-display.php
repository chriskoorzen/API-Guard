<?php
/**
 * Admin Display options for REST-API module
 */
?>

<div class="api_guard sub_menu">
    <h2 class="api_guard sub_menu">REST API Settings</h2>
    <form class="api_guard">
        
        <?php wp_nonce_field( $form_nonce ) ?>

        <div class="api_guard menu_item">
            <div class="api_guard boolean_option">
                <input class="api_guard" type="checkbox" id="disable_public_rest" name="disable_public_rest">
                <label class="api_guard" for="disable_public_rest">Disable Public REST API access</label>
            </div>
            <p class="api_guard menu_item_description">Prevents unauthorized anonymous access to your public API in case an attacker or malicious actor scrapes the content of your site for their own gain and use against your wishes</p>
        </div>

        <input class="api_guard confirm_button" type="submit" value="Save Changes">
    </form>
</div>