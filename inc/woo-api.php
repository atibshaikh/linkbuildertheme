<?php 



add_action( 'admin_menu', 'linkbuilder_product_api_page', 9999 );
 
function linkbuilder_product_api_page() {
   //add_submenu_page( 'edit.php?post_type=product', 'Ahref API Import', 'Ahref API Import', 'edit_products', 'ahrefs_api_import', 'linkbuilder_product_api_page_callback', 9999 );

   add_menu_page( 'Ahref API Import', 'Ahref API Import Setting', 'manage_options', 'ahref-api-setting', 'linkbuilder_product_api_page_callback', 'dashicons-tickets', 57 );

      // add_submenu_page( 'youtube-api-setting', 'Youtube API Importer', 'Youtube API Importer', 'manage_options', 'sub-importer', array($this,'my_plugin_admin_subpage') );
}
 
function linkbuilder_product_api_page_callback() {

   require 'ahref-api-import-form.php';
}


add_action('admin_enqueue_scripts', 'admin_enqueue_style_script' );


function admin_enqueue_style_script(){

   
   if(isset($_REQUEST['page'])){
      
      if($_REQUEST['page'] == 'ahref-api-setting' ){
         
         wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', array(), '1.0.0', 'all' );

         wp_enqueue_style('ahref-css', get_stylesheet_directory_uri().'/assets/css/admin-style.css', array(), '1.0.0', 'all');

         wp_enqueue_script('jquery-ui-datepicker');

         wp_enqueue_script('admin-js', get_stylesheet_directory_uri().'/assets/css/admin-js.js', array('jquery'), false);
         
         wp_enqueue_style('e2b-admin-ui-css','https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css',false,"1.9.0",false);
      }


   }


}