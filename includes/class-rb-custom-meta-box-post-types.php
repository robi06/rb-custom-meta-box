<?php

class Rb_CustomMetaBox_Post_Types {

  public function __construct( ){

         include_once( RB_CUSTOM_META_BOX_DIR . '/includes/vendor/cuztom/cuztom.php' );
          add_action( 'init', array($this,'create_post_type') );
          $this->option_key = 'more_meta_fields';
          $this->data =  is_array(get_option($this->option_key))? get_option($this->option_key):array();
  }
  public function create_post_type( ){

    if(!isset($_GET['post_type'])){
      $post_id = isset($_GET['post'])?$_GET['post']:0;
      $page =  get_post_type( $post_id);
    }else{
      $page = $_GET['post_type'];
    }
    $p = register_cuztom_post_type($page);

    foreach ( $this->data as $key => $value ) {
      if( $key == "" || ( !is_array( $this->data[ $key ][ 'post_type' ] ) || !isset( $this->data[ $key ][ 'post_type' ] ) ) ) continue;

      foreach ( $this->data[ $key ][ 'post_type' ] as $key1 => $value1 ) {
        if( $value1 != $page ) continue;
                  $array = array_values($this->data[ $key ][ 'fields' ]);

                            $p->add_meta_box(
                        $this->data[ $key ][ 'index' ],      // Unique ID
                       esc_html__( $this->data[ $key ][ 'label' ]),    // Title
                        $array
                  );

                }
    }
  }

}

new Rb_CustomMetaBox_Post_Types();
