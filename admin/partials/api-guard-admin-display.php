<?php
/**
 * Admin area UI for the plugin
 */
?>

<?php $form_nonce = 'APIG-admin-menu-nonce'; ?>
<?php $MOD_DIR = realpath( __DIR__ . '/../../includes/modules' ) ; ?>

<div class="api_guard page_body">
    <h1 class="api_guard">API Guard Dashboard</h1>
    
    <?php include( $MOD_DIR . '/rest-api/admin/rest-admin-display.php' ); ?>

    <?php include( $MOD_DIR . '/xml-rpc/admin/xmlrpc-admin-display.php' ); ?>

</div>
