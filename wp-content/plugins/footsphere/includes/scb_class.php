<?php

/**
 *
 */

class scb_class
{

  function __construct()
  {
    require dirname(__FILE__) . '/scb/scb/load.php';
    cb_init( '__init' );
  }

  function __init()
  {/*
    // Creating a custom table
  	new scbTable( 'example_table', __FILE__, "
  		example_id int(20),
  		example varchar(100),
  		PRIMARY KEY  (example_id)
  	");*/

  	// Creating an options object
  	$options = new scbOptions( 'example_options', __FILE__, array(
  		'default_option_a' => 'foo',
  		'default_option_b' => 'bar',
  	) );

  	// Creating settings page objects
  	if ( is_admin() ) {
  		require_once( dirname( __FILE__ ) . '/scb/example.php' );
  		new Example_Admin_Page( __FILE__, $options );
  		new Example_Boxes_Page( __FILE__ );
  	}
  }
}

?>
