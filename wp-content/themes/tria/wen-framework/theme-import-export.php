<?php
add_action( 'admin_menu', 'wf_ie_menu' );

function wf_ie_menu(){

  add_theme_page( 'Import/Export Theme Options', 'Import/Export', 'manage_options', 'wf-export-import', 'wf_ie_callback' );
}

add_action( 'load-appearance_page_wf-export-import', 'wf_action_import_theme_options' );

function wf_action_import_theme_options(){
  if ( ! empty( $_POST ) && check_admin_referer( 'wf_ie_import', 'wf_ie_import_nonce' ) ) {

    $wf_to_import = stripslashes( $_POST['wf_to_import'] );
    $wf_options = json_decode( base64_decode( $wf_to_import), true ) ;
    if ( ! empty( $wf_options ) ) {
      update_option('wen_theme_options', $wf_options );
    }
    $red_url = admin_url('themes.php');
    $red_url = add_query_arg( array( 'page' => 'wf-export-import', 'wf-updated' => 'true' ), $red_url );
    wp_redirect( $red_url );
    exit;

  }


}


add_action( 'admin_notices', 'wf_ie_admin_notice' );

function wf_ie_admin_notice() {

  if ( isset($_REQUEST['wf-updated']) && 'true' == $_REQUEST['wf-updated'] ) {
    ?>
    <div class="updated">
        <p><?php _e( 'Imported successfully !' ); ?></p>
    </div>
    <?php
  }
}

function wf_ie_callback(){
  if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <div class="wrap">

      <h2><?php echo __('Import / Export Theme Options');  ?></h2>

      <div id="poststuff">

        <div id="post-body" class="metabox-holder columns-2">

          <!-- main content -->
          <div id="post-body-content">

            <div class="meta-box-sortables ui-sortable">

              <div class="postbox">

                <h3><span><?php echo __('Import');  ?></span></h3>
                <div class="inside">
                  <form method="post">

                    <?php wp_nonce_field( 'wf_ie_import', 'wf_ie_import_nonce' ); ?>

                    <p><?php echo __('Paste exported code and click <strong>Import</strong>.'); ?></p>

                    <textarea name="wf_to_import" id="wf_to_import" cols="30" rows="10" class="widefat"></textarea>

                    <?php submit_button( __( 'Import') ); ?>

                  </form>

                </div> <!-- .inside -->

              </div> <!-- .postbox -->

            </div> <!-- .meta-box-sortables .ui-sortable -->
            <div class="meta-box-sortables ui-sortable">

              <div class="postbox">

                <h3><span><?php echo __('Export');  ?></span></h3>
                <div class="inside">
                <?php $currect_options = get_option( 'wen_theme_options' ); ?>
                  <textarea name="wf_to_export" id="wf_to_export" cols="30" rows="10" class="widefat"><?php echo base64_encode(json_encode($currect_options)); ?></textarea>
                </div> <!-- .inside -->

              </div> <!-- .postbox -->

            </div> <!-- .meta-box-sortables .ui-sortable -->

          </div> <!-- post-body-content -->

          <!-- sidebar -->
          <div id="postbox-container-1" class="postbox-container" style="display:none;">

            <div class="meta-box-sortables">

              <div class="postbox">

                <h3><span>WebExperts Nepal</span></h3>
                <div class="inside">
                  Kathmandu, Nepal
                </div> <!-- .inside -->

              </div> <!-- .postbox -->

            </div> <!-- .meta-box-sortables -->

          </div> <!-- #postbox-container-1 .postbox-container -->

        </div> <!-- #post-body .metabox-holder .columns-2 -->

        <br class="clear">
      </div> <!-- #poststuff -->

    </div> <!-- .wrap -->


<?php
}
