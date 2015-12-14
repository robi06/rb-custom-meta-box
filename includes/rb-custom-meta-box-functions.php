<?php

 function uou_addmorefields_admin_load_scripts($hook) {
        $post_id = isset($_GET['post'])? $_GET['post'] : 0;
        if(!isset($_GET['post_type'])){
                $page =  get_post_type( $post_id);
        }else{
          $page = $_GET['post_type'];
        }

    wp_register_style( 'bootstrap-css', RB_CUSTOM_META_BOX_URL. '/assets/css/bootstrap-admin.css', array(), false, 'all' );
    wp_enqueue_style( 'bootstrap-css' );
    wp_register_style( 'addmorefields-css', RB_CUSTOM_META_BOX_URL. '/assets/css/addmorefields.css', array(), false, 'all'  );
    wp_enqueue_style( 'addmorefields-css' );

    wp_register_style( 'ui-css', '//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css', array(), false, 'all' );
    wp_enqueue_style( 'ui-css' );

    wp_register_script( 'qui', '//code.jquery.com/ui/1.11.0/jquery-ui.js', array(), false, true );
    wp_enqueue_script( 'qui' );

    wp_enqueue_script( 'searchjs', RB_CUSTOM_META_BOX_URL. '/assets/js/admin-addmorefields-meta.js');

    wp_register_script( 'bootstrap', RB_CUSTOM_META_BOX_URL. '/assets/js/bootstrap.min.js', array(), false, true );
    wp_enqueue_script( 'bootstrap' );



    wp_localize_script('searchjs', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )  );
    wp_localize_script( 'searchjs', 'current_post_type', array('post_type'=>$page, 'post_id'=>$post_id) );
}
add_action('admin_enqueue_scripts', 'uou_addmorefields_admin_load_scripts');



function load_html_pop_backend(){

    $template_loader = new Uou_Addmorefields_Load_Template();
    ob_start();
    $template = $template_loader->locate_template( 'meta_fields.php' );

    if(is_user_logged_in() ){
        include( $template );
    }
    echo ob_get_clean();

}
add_action('admin_footer','load_html_pop_backend');
