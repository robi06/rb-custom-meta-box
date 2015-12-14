<?php

if (!defined( 'ABSPATH' )) exit;


class Rb_CustomMetaBox_Admin {

	public $name, $slug,  $option_key, $data;
	public function __construct( ){

		//ajax request hook started
		add_action( "wp_ajax_nopriv_uc_add_meta", array ( $this, 'uc_add_meta' ) );
    add_action( "wp_ajax_uc_add_meta",   array ( $this, 'uc_add_meta' ) );

    add_action( "wp_ajax_nopriv_uc_delete_meta_field", array ( $this, 'uc_delete_meta_field' ) );
    add_action( "wp_ajax_uc_delete_meta_field",   array ( $this, 'uc_delete_meta_field' ) );

     add_action( "wp_ajax_nopriv_uc_delete_meta_box", array ( $this, 'uc_delete_meta_box' ) );
    add_action( "wp_ajax_uc_delete_meta_box",   array ( $this, 'uc_delete_meta_box' ) );

    add_action( "save_post",   array ( $this, 'save_post_data' ) );

    add_action( "wp_ajax_nopriv_uc_update_metabox", array ( $this, 'uc_update_metabox' ) );
    add_action( "wp_ajax_uc_update_metabox",   array ( $this, 'uc_update_metabox' ) );

    add_action( "wp_ajax_nopriv_uc_update_metabox_field", array ( $this, 'uc_update_metabox_field' ) );
    add_action( "wp_ajax_uc_update_metabox_field",   array ( $this, 'uc_update_metabox_field' ) );
		//ajax request hook ended

		//initialize metaboxes
		add_action( 'add_meta_boxes', array ( $this, 'add_more_add_meta_boxes') );
    $this->option_key = 'more_meta_fields';
    $this->data =  is_array(get_option($this->option_key))? get_option($this->option_key):array();

	}

	 /* Display the post meta box. */
	public function add_more_meta_box( $object, $box ) {
	    wp_nonce_field( basename( __FILE__ ), 'add_more_btn_nonce' );
	    ?>
	     <a id="meta-fields" data-toggle="modal" data-target="#addMoreFieldsModal">Add Meta</a>
	    <?php
	}

	/* Create one or more meta boxes to be displayed on the post editor screen. */
	public function add_more_add_meta_boxes( ) {
		//print_r($_REQUEST);
		$post_id = isset($_GET['post'])? $_GET['post'] : 0;
		if(!isset($_GET['post_type'])){
			$page =  get_post_type( $post_id);
		}else{
			$page = $_GET['post_type'];
		}
		add_meta_box(
      'add-more-meta-box',      // Unique ID
      esc_html__( 'Add More Meta Field', 'add-meta' ),    // Title
      array( $this,'add_more_meta_box' ),   // Callback function
      $page,         // Admin page (or post type)
      'side',         // Context
      'default'         // Priority
	  );
	}

	function plugin_data() {
			return get_option($this->option_key, array());
	}
	function update_data() {
			$this->data  = get_option($this->option_key, array());
	}
  public function uc_add_meta(){
			$tempoptions   = array();
		          $tempoptions	= explode(",", $_POST[ 'options' ]);
			$options	= array( );
		          $meta_box_id =  implode("_", explode(' ', trim($_POST[ 'meta-box' ])));
		          //echo  implode("_", explode(' ', $_POST[ 'meta-box' ]));exit;

		          foreach ($this->data as $metaboxkey => $metaboxvalue) {
		                      if(array_key_exists( implode( "_", explode( ' ', trim( $_POST[ 'meta-field-key' ] ) ) ), $this->data[$metaboxkey]['fields'] ) ){

		                                  if( $this->data[$metaboxkey]['post_type'][0] == $_POST[  'page' ] ){
		                                              echo json_encode( array( "success"=>0, 'msg'=>"Meta key name already exists." ) );
		                                              wp_die();
		                                  }
		                      }
		          }

			foreach ($tempoptions as $key => $value) {
				$options[$value] = $value;
			}
		if( is_array($this->data[ $meta_box_id ]) && in_array( $meta_box_id,$this->data[ $meta_box_id ] ) ){
		if( in_array( $_POST[ 'page' ],$this->data[ $meta_box_id ][ 'post_type' ] ) ) {

		$this->data[ $meta_box_id ][ 'fields'  ][ $_POST[ 'meta-field-key' ] ] = array(
		                                    'name'          => implode("_", explode(' ', trim($_POST[ 'meta-field-key' ]))),
		                                    'label'         => $_POST[ 'meta-field-title' ],
		                                    'description'   => $_POST[ 'meta-field-desc' ],
		                                    'type'          =>$_POST[ 'type' ],
		                                    'options'	=> $options
		                             		);
		} else{
		$this->data[ $meta_box_id ] = array(
				'label'=>$_POST[ 'meta-box' ],
				'position' => 'normal',
				'index'	   => $meta_box_id,
				'post_type'=>array($_POST[ 'page' ]),
		      'fields' => array(
		    		$_POST[ 'meta-field-key' ]=>array(
		            'name'          => implode("_", explode(' ', trim($_POST[  'meta-field-key'  ]))),
		            'label'         => $_POST[  'meta-field-title'  ],
		            'description'   => $_POST[  'meta-field-desc'  ],
		            'type'          =>$_POST[  'type'  ],
		             'options'	=> $options
		        	)
		  	)
			);
		}

		}else{
			$this->data[ $meta_box_id ] = array(
				'label'=>$_POST[  'meta-box' ],
				'position' => 'normal',
				'index'	   => $meta_box_id,
				'post_type'=>array($_POST[  'page' ]),
				  'fields' => array(
						$_POST[  'meta-field-key' ]=>array(
				        'name'          => implode("_", explode(' ', trim($_POST[  'meta-field-key' ]))),
				        'label'         => $_POST[  'meta-field-title' ],
				        'description'   => $_POST[  'meta-field-desc' ],
				        'type'          =>$_POST[  'type' ],
				        'options'	=> $options
				    	)
				)
			);

		}

		if(update_option($this->option_key, $this->data)){
			echo json_encode(array("success"=>1, "msg"=>"Meta Data added successfully."));
			wp_die();
		}else{
			echo json_encode(array("success"=>0, "msg"=>"Meta Data not added."));
			wp_die();
		}
	}
	function uc_delete_meta_field(){
		$meta_key = $_POST['meta_key'];
		$meta_box = $_POST['meta_box'];
		$page = $_POST['post_type'];
		delete_post_meta_by_key( $meta_key );
		$this->update_data();

		unset($this->data[$meta_box]['fields'][$meta_key]);

		update_option($this->option_key, $this->data);
		echo json_encode(array("success"=>1, "msg"=>"Deleted Successfully"));
		wp_die();

	}
	function uc_delete_meta_box(){

		$page = $_POST['post_type'];

		$this->update_data();
		$meta_box = $_POST['meta_box'];


		foreach ($this->data[$meta_box]['fields'] as $key => $value) {
			$meta_key =  "_".$meta_box."_".$key;
			delete_post_meta_by_key( $meta_key );
		}
		unset($this->data[$meta_box]);
		update_option($this->option_key, $this->data);
		echo json_encode(array("success"=>1, "msg"=>"Successfully  deleted"));
		wp_die();

	}



	function save_post_data( $post_id){
	//	echo "<pre>";print_r($this->data);echo "</pre>";
		$page =  get_post_type( $post_id);
		foreach ($this->data as $metaboxkey => $metaboxvalue) {
			global $wpdb;
			if($metaboxvalue['post_type'][0] != $page) continue;
			foreach ($metaboxvalue['fields'] as $key => $value) {
				$meta_key =  "_".$metaboxkey."_".$key;

				$new_meta_value = ( isset( $_POST['cuztom'][$meta_key] ) ? sanitize_html_class( $_POST['cuztom'][$meta_key] ) : '' );
				$meta_value = get_post_meta( $post_id, $meta_key, true );

				if ( $new_meta_value && '' == $meta_value )
						add_post_meta( $post_id, $meta_key, $new_meta_value, true );
				elseif ( $new_meta_value && $new_meta_value != $meta_value )
					update_post_meta( $post_id, $meta_key, $new_meta_value );
				elseif ( '' == $new_meta_value && $meta_value )
					delete_post_meta( $post_id, $meta_key, $meta_value );
			}
		}
	}
	function uc_update_metabox(){

		$old_meta_box_id = trim($_POST['old-meta-box']);
		$new_meta_box_id = implode("_", explode(' ', trim($_POST['new-meta-box']))) ;
		if(array_key_exists($new_meta_box_id, $this->data)){
		if($this->data[$new_meta_box_id]['post_type'][0] == $_POST['post_type']){
		          echo json_encode(array("success"=>0, 'msg'=>"Meta box name already exists."));
		          wp_die();
		}

		}
		$new_meta_box = trim($_POST['new-meta-box']) ;

		$this->data[$new_meta_box_id] = $this->data[$old_meta_box_id];

		unset( $this->data[$old_meta_box_id] );

		$this->data[$new_meta_box_id]['label'] = $new_meta_box;

		$this->data[$new_meta_box_id]['index'] = $new_meta_box_id;

		update_option($this->option_key, $this->data);


		foreach ($this->data as $metaboxkey => $metaboxvalue) {
			  global $wpdb;
			  if($value['post_type'][0] != $_POST['post_type']) continue;
			  else if($metaboxkey != $new_meta_box_id) continue;
				foreach ($metaboxvalue['fields'] as $key => $value) {

				$new_post_meta_key =  "_".$metaboxkey."_".$key;
				$old_post_meta_key =  "_".$old_meta_box_id."_".$key;
				$meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape($old_post_meta_key)."'");

				if (is_array($meta) && !empty($meta) && isset($meta) ) {
	        $wpdb->query(
	                    "
	                    UPDATE $wpdb->postmeta
	                    SET meta_key = '".$wpdb->escape($new_post_meta_key)."'
	                    WHERE meta_key = '".$wpdb->escape($old_post_meta_key)."'
	                        AND post_id = '".$wpdb->escape($_POST['post_id'])."'
	                    "
	        );
				}
			}
		}


	 	echo json_encode(array("success"=>1, 'msg'=>"successfully edited"));
	 	wp_die();

 	}
 	function uc_update_metabox_field(){
	  global $wpdb;
	  $meta_box = $_POST['meta_box'];
	  $old_meta_key = $_POST['old_key'];
	  $new_meta_key = implode("_", explode(' ', trim($_POST['key'])));


	  if(array_key_exists($new_meta_key, $this->data[$meta_box]['fields'])){
	              if($this->data[$meta_box]['post_type'][0] == $_POST['post_type']){
	                          echo json_encode(array("success"=>0, 'msg'=>"Meta key name already exists."));
	                          wp_die();
	              }

	  }

	  $this->data[$meta_box]['fields'][$new_meta_key] = $this->data[$meta_box]['fields'][$old_meta_key];

	  $this->data[$meta_box]['fields'][$new_meta_key]['name'] = $new_meta_key;
	  $this->data[$meta_box]['fields'][$new_meta_key]['label'] = $_POST['label'];
	  $this->data[$meta_box]['fields'][$new_meta_key]['description'] = $_POST['desc'];
	  $this->data[$meta_box]['fields'][$new_meta_key]['type'] = $_POST['type'];

	  unset($this->data[$meta_box]['fields'][$old_meta_key]);

	  update_option($this->option_key, $this->data);

	  $meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape($old_post_meta_key)."'");

	  foreach ($this->data as $metaboxkey => $metaboxvalue) {
	              global $wpdb;
	              if($value['post_type'][0] != $_POST['post_type']) continue;
	              else if($metaboxkey != $meta_box) continue;

	              $new_post_meta_key =  "_".$metaboxkey."_".$new_meta_key;
	              $old_post_meta_key =  "_".$metaboxkey."_".$old_meta_key;

	              if (is_array($meta) && !empty($meta) && isset($meta) ) {
	                          $wpdb->query(
	                                      "
	                                      UPDATE $wpdb->postmeta
	                                      SET meta_key = '".$wpdb->escape($new_post_meta_key)."'
	                                      WHERE meta_key = '".$wpdb->escape($old_post_meta_key)."'
	                                          AND post_id = '".$wpdb->escape($_POST['post_id'])."'
	                                      "
	                          );
	              }
	  }
	  echo json_encode(array("success"=>1, 'msg'=>"successfully edited"));
	  wp_die();
	}

}
new Rb_CustomMetaBox_Admin();
