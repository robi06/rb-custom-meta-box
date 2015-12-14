<?php
/**
 * Plugin Name: RB Custom Meta Box
 * Plugin URI:  github.com/robi06
 * Description: Complete job management app on top of WordPress
 * Author:      Md Robiul Islam
 * Author URI:  github.com/robi06
 * Version:     0.1
 * Text Domain: rb-custom-meta-box
 * Domain Path: /languages/
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
    exit;

Class Rb_CustomMetaBox{

    public function __construct(){

      // Define constants
      define( 'RB_CUSTOM_META_BOX', '0.1' );
      define( 'RB_CUSTOM_META_BOX_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
      define( 'RB_CUSTOM_META_BOX_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
      define( 'RB_USTOM_META_BOX_PLUGIN_FILE', __FILE__ );
      if ( is_admin() ) {
        include( 'includes/class-rb-custom-meta-box-post-types.php' );
        include( 'includes/class-rb-custom-meta-box-load-template.php' );
        include( 'includes/class-rb-custom-meta-box-admin.php' );
        include( 'includes/rb-custom-meta-box-functions.php' );
      }
      
    }

    public function uc_careers_admin_notices(){
        echo '<div class="updated">

        <h1> Rb Custom Meta Box Fields Plugin Notice </h1>

        </div>';
    }

}
$GLOBALS['Rb_CMB'] = new Rb_CustomMetaBox();
