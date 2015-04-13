<?php
/*
Plugin Name: Pretty file list pro
Plugin URI: http://www.smartredfox.com/prettylistpro
Description: A plugin that shows files in an attractive, sortable, and searchable list.
Version: 1.9.3
Author: James Botham
Author URI: http://www.smartredfox.com

Changelog:
-1.9.3
-- Fixed bug that was causing wp-revision docs to use wrong url in some instances
-1.9.2
-- Added description to file types
-1.9.1
-- List hidden initially option added
-1.9.0
-- Additional file types added for docx, xslx, pptx, etc.
-- WP Document Revisions Support Added
-- Fixed shortcode wizard insert button in IE9



 */

class PrettyFileListProPlugin_Class{  
        
    /** 
     * Class Constructor 
     */  
    public function __construct() {          
        //File types supported        
        $this->supported_file_types = array(
            'img' => array(
                'Image',//Friendly name
                'image/gif',
                'image/png',
                'image/jpeg'
                ),
            'pdf' => array(
                'PDF',//Friendly name
                'application/pdf',
                'application/x-pdf',
                'application/acrobat','applications/vnd.pdf','text/pdf','text/x-pdf'
                ),
            'xls' => array(
                'Excel',//Friendly name
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', //xslx
                'application/vnd.openxmlformats-officedocument.spreadsheetml.template' //xslt
                ),
            'doc' => array(
                'Word',//Friendly name
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',//docx
                'application/vnd.openxmlformats-officedocument.wordprocessingml.template' //dotx
                ),
            'ppt' => array(
                'Powerpoint',//Friendly name
                'application/mspowerpnt',
                'application/vnd-mspowerpoint',
                'application/powerpoint',
                'application/x-powerpoint',
                'application/vnd.ms-powerpoint',
                'application/mspowerpoint',
                'application/ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.template', //potx
                'application/vnd.openxmlformats-officedocument.presentationml.slideshow', //ppsx
                'application/vnd.openxmlformats-officedocument.presentationml.presentation', //pptx
                'application/vnd.openxmlformats-officedocument.presentationml.slide' //sldx
                ),
            'zip' => array(
                'Zip',//Friendly name
                'application/zip',
                'application/x-zip',
                'application/x-zip-compressed',
                'application/x-compress',
                'application/x-compressed',
                'multipart/x-zip'
                ),
            'mp3' => array(
                'MP3',//Friendly name
                'audio/mpeg',
                'audio/mpeg3',
                'audio/x-mpeg-3',
                'audio/x-mpeg-3'
                ),
            'mp4' => array(
                'MP4',//Friendly name
                'video/mp4v-es',
                'audio/mp4'
                )            
        );
        
        $this->plugin_defines();
        $this->setup_actions();
        
        if(!is_admin())
        {
            add_shortcode('prettyfilelist', array($this, 'prettyfilelist_shortcode'));
        }               
        
        //Custom fields for external file links
        $prefix = 'external_file_link';

        $this->external_file_link_fields = array(
          array(
              'name' => 'fileurl',
              'desc' => 'Url to file',
              'id' => $prefix . 'fileurl',
              'type' => 'text',
              'std' => 'fileurl'),
          array(
              'name' => 'filesize',
              'desc' => 'Size of the file',
              'id' => $prefix . 'filesize',
              'type' => 'text',
              'std' => 'filesize'),
          array(
              'name' => 'filesize_units',
              'desc' => 'File size units',
              'id' => $prefix . 'filesize_units',
              'type' => 'dropdown',
              'std' => 'filesize_units'),
          array(
              'name' => 'filetype',
              'desc' => 'File type (pdf, xls, etc.)',
              'id' => $prefix . 'filetype',
              'type' => 'dropdown',
              'std' => 'filetype'),
          array(
              'name' => 'filedate',
              'desc' => 'The Date the file was created',
              'id' => $prefix . 'filedate',
              'type' => 'date',
              'std' => 'filedate'
          )  
        );          
    }        

    //Convert a type to friendly text
    function typeToString($type){
        
        $matchedType = $this->supported_file_types[$type];
        if($matchedType != ''){
            return $matchedType[0];
        }

        return "";
    }
    
    //Get file from mime type
    function get_extension_from_mimetype($filemimetype) {
        $file_extension = "";

        //Loop through each file extension
        foreach($this->supported_file_types as $key => $value){
            //Then each mimetype
            foreach($value as $mimetype){
                if($filemimetype == $mimetype){
                    return $key;
                }
            }
        }
        
        return "";
    }
    
    function register_taxonomy_media_categories() {

        $labels = array( 
            'name' => __( 'Media categories', 'prettyfilelist' ),
            'singular_name' => __( 'Media category', 'prettyfilelist' ),
            'search_items' => __( 'Search Media categories', 'prettyfilelist' ),
            'popular_items' => __( 'Popular Media categories', 'prettyfilelist' ),
            'all_items' => __( 'All Media categories', 'prettyfilelist' ),
            'parent_item' => __( 'Parent Media category', 'prettyfilelist' ),
            'parent_item_colon' => __( 'Parent Media category:', 'prettyfilelist' ),
            'edit_item' => __( 'Edit Media category', 'prettyfilelist' ),
            'update_item' => __( 'Update Media category', 'prettyfilelist' ),
            'add_new_item' => __( 'Add New Media category', 'prettyfilelist' ),
            'new_item_name' => __( 'New Media category', 'prettyfilelist' ),
            'separate_items_with_commas' => __( 'Separate media categories with commas', 'prettyfilelist' ),
            'add_or_remove_items' => __( 'Add or remove Media categories', 'prettyfilelist' ),
            'choose_from_most_used' => __( 'Choose from most used Media categories', 'prettyfilelist' ),
            'menu_name' => __( 'Media categories', 'prettyfilelist' ),
        );

        $args = array( 
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'show_tagcloud' => true,
            'show_admin_column' => true,
            'hierarchical' => false,
            'rewrite' => false,
            'query_var' => true
        );
        
        $post_types = array('attachment','external_file_link');
        
        //If wp revisions exists add categories to it       
        if(class_exists('Document_Revisions')){
            $post_types[] = 'document';
        }
        
        register_taxonomy( 'media_categories', $post_types, $args );
    }
    
    
    /** 
     * Defines to be used anywhere in WordPress after the plugin has been initiated. 
     */  
    function plugin_defines()
    {
        define( 'PRETTY_FILE_LIST_PRO_PATH', trailingslashit( WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__ ),"",plugin_basename( __FILE__ ) ) ) );  
        define( 'PRETTY_FILE_LIST_PRO_URL' , trailingslashit( WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__ ),"",plugin_basename( __FILE__ ) ) ) );    		
    }    
    
    /** 
     * Setup the actions to hook the plugin into WordPress at the appropriate places 
     */
    function setup_actions(){
        //Custom post type for external links
        add_action( 'init', array($this,'register_cpt_external_file_link') );
        
        //Custom taxonomy for all media
        add_action( 'init', array($this,'register_taxonomy_media_categories'));



        if(is_admin())
        {
            //Admin only
            add_action('admin_init', array($this,'pfl_admin_init'));
            
            //The tag to taxonomy convertor
            add_action('admin_menu', array($this,'register_taxonomy_fix_menu_page'));
            
            //Attach the settings menu
            add_action('admin_menu', array($this,'srf_prettylist_admin_menu'));
            
            //Attach save event for Settings page
            add_filter( 'attachment_fields_to_save', array($this,'srf_attachment_field_prettylist_save'), 10, 2 );
            //Add shortcode button
            add_action('init', array($this,'add_button'));
            
            //Ajax calls for admin
            add_action('wp_ajax_get_attached_files', array($this,'get_attached_files_ajax'));
            add_action('wp_ajax_get_all_files', array($this,'get_all_files_ajax'));
            add_action('wp_ajax_get_all_terms', array($this,'get_all_terms_ajax'));
            add_action('wp_ajax_get_all_file_types', array($this,'get_all_file_types_ajax'));

            add_action('wp_ajax_get_remote_file_size', array($this,'get_remote_file_size_ajax'));

            //Add tag option to media upload page
            //add_filter( 'attachment_fields_to_edit', array($this,'srf_extra_media_fields'), 10, 2 ); 
            //Attach save event for media upload page
            //add_filter( 'attachment_fields_to_save', array($this,'srf_extra_media_fields_save'), 10, 2 ); 
            //Add admin side scripts etc
            add_action('admin_print_styles', array($this,'load_admin_scripts_styles'));
        }
        else
        {			                    
            //Add stylesheets
            add_action('init', array($this,'prettyfilelist_stylesheets'));
            //Add javascript
            add_action('init', array($this,'srf_prettylist_frontend_scripts'));
            //Set domain for translations
            load_plugin_textdomain( 'prettyfilelist', false, dirname(plugin_basename( __FILE__ )));                   
        }
    }         

    //Admin only init
    function pfl_admin_init(){
        //setup edit/add map location
        add_meta_box("external_file_link_editor", "External file details", array($this,'external_file_link_edit_box'), "external_file_link", "normal", "low");
        
        //Save map locations
        add_action('save_post', array($this,'save_custom_meta'));    
        
        //Change publish button
        add_filter( 'gettext', array($this,'change_external_link_publish_button'), 10, 2 );
    }
    
    function register_cpt_external_file_link() {
        
        $boxesToShow = array('title','thumbnail');//Disable full editor
        
        $labels = array(
            'name' => __( 'External Files', 'prettyfilelist' ),
            'singular_name' => __( 'External File', 'prettyfilelist' ),
            'add_new' => __( 'Add New', 'prettyfilelist' ),
            'all_items' => __( 'External Files', 'prettyfilelist' ),
            'add_new_item' => __( 'Add New External File', 'prettyfilelist' ),
            'edit_item' => __( 'Edit External File', 'prettyfilelist' ),
            'new_item' => __( 'New External Files', 'prettyfilelist' ),
            'view_item' => __( 'View External Files', 'prettyfilelist' ),
            'search_items' => __( 'Search External Files', 'prettyfilelist' ),
            'not_found' => __( 'No external files found', 'prettyfilelist' ),
            'not_found_in_trash' => __( 'No external files found in Trash', 'prettyfilelist' ),
            'parent_item_colon' => __( 'Parent External File Link:', 'prettyfilelist' ),
            'menu_name' => __( 'External Files', 'prettyfilelist' )
        );
        
        $args = array(
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => '/filelistpro',
            'show_in_nav_menus' => false,
            'exclude_from_search' => true,
            'supports' => $boxesToShow
        );
        
        register_post_type( 'external_file_link', $args );
    } 

    //setup edit/add map location
    function external_file_link_edit_box()
    {       
        //Get the edit page
        include(PRETTY_FILE_LIST_PRO_PATH . 'includes/external_file_link_edit_box.php');
    }    
    
    // Save the Data
    function save_custom_meta($post_id) {
        //Check if post variables are set first
        if(isset($_POST['custom_meta_box_nonce'])){
            // Verify nonce
            if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], PRETTY_FILE_LIST_PRO_PATH)){
                return $post_id;
            }
        }
        else{
            //Or quit out (not saving)
            return;
        }

        //If autosave return
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){ return; }

        // loop through fields and save the data
        foreach ($this->external_file_link_fields as $field){
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];

            if ($new && $new != $old) {                
                update_post_meta($post_id, $field['id'], $new); 
                
                //Set mime type                
                if($field['name'] == 'filetype'){
                    //Get mime type
                    $mimetype = $this->supported_file_types[$new][1];
                    global $wpdb;
                    //Save mime type
                    //NB: update post meta updates post table only, update post doesnt handle mime type
                    $wpdb->update("$wpdb->posts", array('post_mime_type' => $mimetype), array('ID' => $post_id));
                }                
                elseif($field['name'] == 'filesize'){
                    //Convert to bytes
                    //From wordpress own size_format
                    $quant = array(
                        // ========================= Origin ====
                        'TB' => 1099511627776,  // pow( 1024, 4)
                        'GB' => 1073741824,     // pow( 1024, 3)
                        'MB' => 1048576,        // pow( 1024, 2)
                        'KB' => 1024,           // pow( 1024, 1)
                        'B' => 1,              // pow( 1024, 0)
                    );
                    //File size units
                    $units = $_POST['external_file_linkfilesize_units'];
                    $byte_size = $quant[$units] * $new;
                    update_post_meta($post_id, $field['id'], $byte_size);
                }
            } 
            elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }    

    function change_external_link_publish_button( $translation, $text ) {
        if ( 'external_file_link' == get_post_type()){
            if ( $text == 'Publish' ){
                return 'Create link';
            }        
        }

        return $translation;
    }    

    //Ajax call to get remote file size
    function get_remote_file_size_ajax(){        
        
        //Check curl is installed
        if(function_exists('curl_init')){
            $remoteFile = $_POST['fileUrl'];
            
            $ch = curl_init($remoteFile);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE);
            curl_setopt($ch, CURLOPT_FILETIME, TRUE);

            $data = curl_exec($ch);

            $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
            $mime_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $file_time = curl_getinfo($ch, CURLINFO_FILETIME);
            $modified_date = date("m/d/Y",$file_time);

            //Convert to file ext
            //Generic ___x file
            if($mime_type == "application/vnd.openxmlformats"){
                $file_type = pathinfo($remoteFile, PATHINFO_EXTENSION);
            }
            else{
                $file_type = $this->get_extension_from_mimetype($mime_type);
            }

            $file_Details = array($size,$file_type,$modified_date);                

            if ($data === false) {
                //echo 'cURL failed';
                echo -1;
                exit;
            }
            else{
                echo json_encode($file_Details);            
            }

            curl_close($ch);
            
        }
        else{
            return;
        }        
    }
    
    //Ajax call for add shortcode modal
    function get_attached_files_ajax() {
        $currentPostId = intval( $_POST['currentPostId'] );

        $args = array( 'post_type' => 'attachment','orderby' => 'title','order' => 'ASC', 'posts_per_page'=>-1, 'post_status' => null, 'post_parent' => $currentPostId); 
        $attachments = get_children($args);
        $html = '<ul>';//Start the list

        foreach ( $attachments as $attachment ) {                
            $html .= '<li><label><input type="checkbox" class="file" id="file_' . $attachment->ID . '" name="file_' . $attachment->ID .'" value="' . $attachment->ID . '">' . $attachment->post_title . '</label></li>';
        }
        $html .= '</ul>';//End the list
        echo $html;

        die(); // this is required to return a proper result
    }
    
    //Ajax call for add shortcode modal
    function get_all_files_ajax() {
     
        $wprevmode = get_option('srf_pflpro_wprevmode'); 
        
        //WP REV MODE
        if($wprevmode == "true"){
            $args = array( 'post_type' => array('document'),'posts_per_page'=>-1,'post_status'=>'any');
            
            $attachmentsnew = get_documents($args);
            
            $html = '<ul data-wprevmode="true">';//Start the list
            
            if(count($attachmentsnew) > 0){
                foreach($attachmentsnew as $attachment){
                    $id = $attachment->ID;
                    $html .= '<li class="' . $attachment->post_type . '"><label><input type="checkbox" class="file" id="file_' . $id . '" name="file_' . $id .'" value="' . $id . '">' . get_the_title($id) .  '</label></li>';
                }
            }
            else{
                $html .= '<li>No files found</li>';//none found
            }
            
            $html .= '</ul>';//End the list            
        }
        else{
            //MEDIA LIBRARY MODE
            $args = array( 'post_type' => array('external_file_link','attachment'),'posts_per_page'=>-1,'post_status'=>'any'); 
            $attachmentsnew = new WP_Query($args);
            
            $html = '<ul data-wprevmode="false">';//Start the list
            
            if(count($attachmentsnew) > 0){
            while ($attachmentsnew->have_posts()):
                $attachmentsnew->next_post();
                $id = $attachmentsnew->post->ID;
                $html .= '<li class="' . $attachmentsnew->post->post_type . '"><label><input type="checkbox" class="file" id="file_' . $id . '" name="file_' . $id .'" value="' . $id . '">' . get_the_title($id) .  '</label></li>';
            endwhile;
            }
            else{
                $html .= '<li>No files found</li>';//none found
            }
            
            $html .= '</ul>';//End the list            
        }
        
        
       
        echo $html;

        die(); // this is required to return a proper result
    }
    
    function get_all_terms_ajax(){
        $args = array('hide_empty' => false,'hierarchical'  => false); 
        
        $terms = get_terms( 'media_categories', $args);

        $html = '<ul>';//Start the list
        
        foreach($terms as $term){
            $html .= '<li><label><input type="checkbox" class="file" id="' . $term->slug . '" name="' . $term->slug .'" value="' . $term->slug . '">' . $term->name .  '</label></li>';
        }        
        
        $html .= '</ul>';//End the list
        echo $html;        
        die(); // this is required to return a proper result
    }

    function get_all_file_types_ajax(){
        
        //$this->supported_file_types;
        $html ="";
        //Loop through each file extension
        //'img' => array('Image' => 'image/gif','image/png','image/jpeg'),
        foreach($this->supported_file_types as $key => $value){
            $html .= "<li class='$key'><label class='selected' for=''><input type='checkbox' value='$key' checked='checked' name='$key'>$value[0]</label></li>";
        }

        echo $html;        
        die(); // this is required to return a proper result
    }    
    
    //Output shortcode
    public function prettyfilelist_shortcode($atts, $content = null){
        //Get attributes from shortcode 
        extract(shortcode_atts(array(
                "enddate" => "",
                "filesperpage" => "7",
                "filestoshow" => "",
                "hidefilter" => "false",
                "hidesearch" => "false",
                "hidesort" => "false",                
                "hidelistinitially" => "false",
                "openinnew" => "false",
                "orderby" => "post_date",
                "orderdir" => "DESC",                
                "requirealltags" =>"false",
                "startdate" => "",
                "tags" => "",                
                "thispostonly" => false,
                "type" => "xls,pdf,doc,zip,ppt,img,mp3,mp4",
                "wprevmode" => "false"
        ), $atts)); 

        $html ='';

        //Get an array of files to display
        if($filestoshow != ""){
            $filestoshowarray = explode(',',$filestoshow);                    
        }

        //Get an array of types to display
        $types = explode(',',$type);

        //Get a string of mime types we want  
        $mimeTypesToGet = $this->TypeToMime($type);                             

        //See if whole site or just this post page
        //Check to see if we want all types
        //If all types add filters
        //Get all attachments of the right type
        if($wprevmode == "true"){
            if($thispostonly){
                $args = array('media_categories' => $tags, 'post_type' => array('document'),'orderby' => $orderby,'order' => $orderdir, 'posts_per_page'=>-1,'post_status'=>'publish', 'post_parent' => get_the_id());
            }
            else{                    
                $args = array('media_categories' => $tags,'post_type' => array('document'),'orderby' => $orderby,'order' => $orderdir, 'posts_per_page'=>-1, 'post_status' => array('publish'));
            }
            
            $attachments = new WP_Query($args);                
        }else{
            if($thispostonly){
                $args = array('media_categories' => $tags, 'post_type' => array('external_file_link','attachment'),'orderby' => $orderby,'order' => $orderdir, 'posts_per_page'=>-1,'post_status'=>'any', 'post_parent' => get_the_id(),'post_mime_type' => $mimeTypesToGet);
            }
            else{                    
                $args = array('media_categories' => $tags, 'post_type' => array('external_file_link','attachment'),'orderby' => $orderby,'order' => $orderdir, 'posts_per_page'=>-1, 'post_status' => array('any','publish'), 'post_mime_type' => $mimeTypesToGet);
            }
            
            $attachments = new WP_Query($args);
        }

        //Get options for display
        $hideFilter = ((count($types) <= 1) || get_option('srf_pflpro_hidefilter') == 'true') || $hidefilter == "true";
        $hideSearch = get_option('srf_pflpro_hidesearch') == 'true' || $hidesearch == "true";
        $hideSort = get_option('srf_pflpro_hidesort') == 'true' || $hidesort == "true";
        $useCustomTemplate = get_option('srf_pflpro_usecustomtemplate') == 'true';

        //Get the template file for display
        //Do here so we only get it once                
        $filePath = PRETTY_FILE_LIST_PRO_PATH . 'templates/pflprotemplate.php';

        //See if we need a custom template
        if($useCustomTemplate)
        {
            $filePath = $this->get_theme_file('pflprotemplate.php');

            //Make sure the file exists
            if(!file_exists($filePath)){
                $filePath = PRETTY_FILE_LIST_PRO_PATH . 'templates/pflprotemplate.php';
            }
        }

        $hidelistattrib = $hidelistinitially == 'true' ? 'data-hideinitially="true"' : '';

        //Get template file		 
        $template = file_get_contents($filePath);

        //Strip out line breaks and carriage returns
        $template = trim( preg_replace( '/\s+/', ' ',$template));
        
        //Build the html for display             
        $html .= '<div class="prettyFileList" ' . $hidelistattrib . ' data-filesperpage="' . $filesperpage .'">';
        //Main files
        if ($attachments->have_posts()) {
            $html .= '<div class="prettyFileBar">';

            //Don't show filter button if only one type
            if(!$hideFilter){
                $html .= '<a href="#" class="showFilterBtn float_right corePrettyStyle btn">' . __('Filter','prettyfilelist') .'</a>';  
            }
            if(!$hideSort){
                $html .= '<a href="#" class="showSortingBtn float_right corePrettyStyle btn">' . __('Sort','prettyfilelist') .'</a>';
            }                                        
            $html .= '<div class="prettyFileFilters">';
            $html .= '<ul class="unstyled">';
            foreach($types as $thisType){
                $html .= '<li><a href="" data-filter-type="' . $thisType . '" class="' . $thisType .'Filter '. $thisType .' showing">' . $this->typeToString($thisType) .'</a></li>';
            }

            $html .= '</ul>';
            $html .= '<p class="bar"><a href="#" class="cross">' . __('Close','prettyfilelist') .'</a></p>';
            $html .= '</div>';

            $html .= '<div class="prettyFileSorting" ';
            $html .= $hideFilter ? 'style="right:0"' : '';
            $html .= '>';
            $html .= '<ul class="unstyled">';
            $html .= '<li><a href="" data-sort-type="bydate" data-sort-direction="asc" class="asc">' . __('By Date','prettyfilelist') .'</a></li>';
            $html .= '<li><a href="" data-sort-type="bytitle">' . __('By Name','prettyfilelist') .'</a></li>';
            if(count($types) != 1){
                $html .= '<li><a href="" data-sort-type="bytype" class="">' . __('By Type','prettyfilelist') .'</a></li>';
            }
            $html .= '</ul>';
            $html .= '<p class="bar"><a href="#" class="cross">Close</a></p>';
            $html .= '</div>';
            if(!$hideSearch){
                $html .= '<div class="prettyFileListSearch"><label style="display:none;">' . __('Search','prettyfilelist') .'</label><input type="text" value="' . __('Search...','prettyfilelist') .'" class="prettySearchValue" /><a class="doPrettySearch btn corePrettyStyle">' . __('Go','prettyfilelist') .'</a><a class="clearSearch btn corePrettyStyle hidden">' . __('Clear','prettyfilelist') .'</a></div>';
            }
            $html .= '</div>';
            $html .= '<div class="prettyMessage" style="display:none"><span></span><a href="#" class="btn">' . __('Show all files','prettyfilelist') .'</a></div>';
            $html .= '<div class="prettyListItems loading">';                                

            //TODO: Switch this to be done in wpquery 
            if($filestoshow == ""){
                while ($attachments->have_posts()):
                    $attachments->next_post();
                    $id = $attachments->post->ID;
                    $attachment = $attachments->post;   
                    $fileTags = get_the_terms( $id, 'media_categories');
                    $postType = $attachment->post_type;
                    $html .= $this->srf_get_formatted_link($attachment,$openinnew,$startdate,$enddate,$template,$fileTags,$postType,$requirealltags);                                        
                endwhile;
            }
            else{                                    
                while ($attachments->have_posts()):                                        
                    $attachments->next_post();
                    $id = $attachments->post->ID;
                    $attachment = $attachments->post;   
                    $fileTags = get_the_terms( $id, 'media_categories');
                    if(in_array($attachment->ID, $filestoshowarray)){
                        $postType = $attachment->post_type;
                        $html .= $this->srf_get_formatted_link($attachment,$openinnew,$startdate,$enddate,$template,$fileTags,$postType,$requirealltags);                                        
                    }

                endwhile;
            }

            $html .= '</div>';
            $html .= '<div class="prettyPagination">';
            $html .= '<a href="#" class="pfl_next btn corePrettyStyle">' . __('Next','prettyfilelist') .' &raquo;</a>';
            $html .= '<span class="pagingInfo">' . __('Page','prettyfilelist') .' <span class="currentPage">1</span> ' . __('of','prettyfilelist') .' <span class="totalPages"></span></span>';
            $html .= '<a href="#" class="pfl_prev btn disabled corePrettyStyle">&laquo; ' . __('Prev','prettyfilelist') .'</a>';
            $html .= '</div>';//End paging
        }
        else{
            $html .= "<div class='prettyMessage'>This list doesn't contain any files</div>";
        }                            
        $html .= '</div>';//End prettyfilelist
        

        return $html;
    }

    //Add Stylesheet
    public function prettyfilelist_stylesheets()
    {
        //Get user selected stylesheet if any
        $options['srf_pflpro_stylesheet_to_use'] = get_option('srf_pflpro_stylesheet_to_use'); 

        $stylesheet_url = PRETTY_FILE_LIST_PRO_URL . 'styles/Grey_light_default.css';

        if($options['srf_pflpro_stylesheet_to_use'] != ""){
            //Add our prettylist stylesheet
            $stylesheet_url = PRETTY_FILE_LIST_PRO_URL . 'styles/' . $options['srf_pflpro_stylesheet_to_use'];	
        }

        wp_register_style('srfprettylistStyleSheets', $stylesheet_url);
        wp_enqueue_style( 'srfprettylistStyleSheets');
    }  

    private function TypeToMime($typesToConvert){
        $unconvertedTypes = explode(",", $typesToConvert);
        $typeString = "";                
        $i = 0;

        foreach ($unconvertedTypes as $type) {                                      
            if(isset($this->supported_file_types[$type])){
                foreach($this->supported_file_types[$type] as $mimetype){
                    $typeString .= $mimetype . ",";
                }
            }
        }

        //Remove extra comma
        if($typeString != ""){
            $typeString = substr_replace($typeString ,"",-1);
        }

        return $typeString;
    }	

    public function srf_get_formatted_link($attachment,$openinnew,$startDate,$endDate,$html,$tags,$posttype,$requirealltags){

        
        if($posttype == 'external_file_link'){
            //Get all meta
            $external_meta = get_post_meta($attachment->ID);            
            //Get the mime type and title	
            $file_extension = $external_meta['external_file_linkfiletype'][0];
            $mime_type = $this->supported_file_types[$file_extension][0]; //Get the mime-type
            $title_temp = $attachment->post_title; //Get the title
            $modified_date = $external_meta['external_file_linkfiledate'][0];//Get the last modified date
        }
        else if($posttype == 'document'){
			//Not original
			if(is_integer(intval($attachment->post_content))){
				$originaldoc = get_post($attachment->post_content);

				$mime_type = $originaldoc->post_mime_type; //Get the mime-type
				$title_temp = $attachment->post_title; //Get the title
				$modified_date = $attachment->post_modified;//Get the last modified date
				$caption = $originaldoc->post_excerpt;
			}
			else{
				$mime_type = $attachment->post_mime_type; //Get the mime-type
				$title_temp = $attachment->post_title; //Get the title
				$modified_date = $attachment->post_modified;//Get the last modified date
				$caption = $attachment->post_excerpt;                    
			}
        }
        else{
            //Get the mime type and title			
            $mime_type = $attachment->post_mime_type; //Get the mime-type
            $title_temp = $attachment->post_title; //Get the title
            $modified_date = $attachment->post_modified;//Get the last modified date
            $caption = $attachment->post_excerpt;            
        }

        $unixdate = strtotime($modified_date);
        
        //Get date option if set                
        $date_format = get_option( 'srf_pflpro_date_format' );
        
        //If not set use default
        if($date_format == ""){
            $date_format = 'jS M Y';                    
        }       
        
        $modified_date = date($date_format, $unixdate);
        
        //Check if before start date
        if($startDate != "" && strtotime($modified_date) < strtotime($startDate)){return "";}

        //Check if after end date
        if($endDate != "" && strtotime($modified_date) > strtotime($endDate)){return "";}
        
        //Check mime-type against our list of types we style links for
        $type = $this->get_extension_from_mimetype($mime_type);               	

        $src = "";

        //If we matched a type create our shortcode
        if($type != "")
        {
            if($posttype == 'external_file_link'){
                $src = $external_meta['external_file_linkfileurl'][0]; 
            }
            else if($posttype == 'document'){           
                $src = get_permalink($attachment->ID);             
            }
            else{
                $src = wp_get_attachment_url( $attachment->ID );
            }
            
            //Convert tags array to string
            $tagsString = "";
            
            if($tags != ''){
                foreach($tags as $tag){
                    if($tagsString != ''){
                        $tagsString .= ',';
                    }
                    $tagsString .= $tag->slug;
                }
            }
            
            //Use this to add target etc.
            //Open in new window?
            $additionalAttr = $openinnew == 'true' ? ' target="_blank"' : "";
            
            //Add tags to item for future filtering(?)
            $additionalAttr .= ' data-tags="' . $tagsString . '"';

            //Add date as a data attribute
            $additionalAttr .= ' data-date="' . $unixdate . '"';
            
            //Link url
            $html = str_replace('##src##',$src,$html);
            //Title
            $html = str_replace('##title##',$title_temp,$html);
            //Additional Attributes
            $html = str_replace('##additionalattr##',$additionalAttr,$html);
            //Tags
            $html = str_replace('##tags##',$tagsString,$html);
            //File type
            $html = str_replace('##filetype##',$type,$html);
            //Caption
            if(isset($caption)){
                $html = str_replace('##caption##',$caption,$html);
            }
            else{
                $html = str_replace('##caption##','',$html);
            }

            //Description - not for wp rev
            if(isset($attachment->post_content) && $attachment->post_content != '' && $posttype != 'document'){
                $html = str_replace('##description##',$attachment->post_content,$html);
            }
            else{
                $html = str_replace('##description##','',$html);
            }

            //File size
            //Only do file sizing if needed
            //TODO:Add this to data attrib in set format for sorting
            if(strstr($html,'##size##')){
                if($posttype == 'external_file_link'){
                    $html = str_replace('##size##',size_format($external_meta['external_file_linkfilesize'][0]),$html);
                }
                else if($posttype == 'document'){
                    if(get_attached_file( $originaldoc->ID ) != ''){
                       $filesize = filesize(get_attached_file( $originaldoc->ID));
                        $html = str_replace('##size##',size_format($filesize),$html);
                    }
                } 
				else{
                    if(get_attached_file( $attachment->ID) != ''){
                        $filesize = filesize(get_attached_file( $attachment->ID));
                        $html = str_replace('##size##',size_format($filesize),$html);
                    }
				}
            }

            //Get download count if plugin included
            if(strstr($html,'##esdc-count##')){
                $filename = basename ( get_attached_file( $attachment->ID ));
                $downloadCount = $this->get_count($filename);
                $html = str_replace('##esdc-count##',$downloadCount,$html);
            }

            //Last modified date
            $html = str_replace('##date##',$modified_date,$html);

        }    
        return $html; // return new $html 
    }

    //Get count if escd download counter plugin installed
    function get_count($filename, $from="", $to=""){
        
        //Make sure the plugin is installed        
        if(is_plugin_active('electric-studio-download-counter/electric_studio_download_counter.php')){

            global $wpdb;

            if($to==""){$to = current_time('mysql');}			
            if($from==""){$from = '0000-00-00';}

            $tableName = $wpdb->prefix."es_download_counter";

            $sql = $wpdb->prepare("SELECT id, time FROM ".$tableName." WHERE download_name = '%s' AND time BETWEEN %s AND %s",$filename,$from,$to);

            $results = $wpdb->query($sql);

            return $results;
        }
    }	
    

	/****************************************************************************************
	ADMIN STUFF
     ****************************************************************************************/
	
	/**********************
	QUEUE ADMIN MENU         
     **********************/
	public function srf_prettylist_admin_menu()
	{  
        //Add plugin to the admin menu  
        $page = add_options_page('File List Pro Settings', 'File List Pro', 'manage_options', dirname(__FILE__), array($this,'srf_prettylistpro_admin_options'));  

        //Add admin preview script only to our pages
        add_action( 'admin_print_styles-' . $page, array($this,'srf_prettylist_admin_scripts'));
	} 
    
    function register_taxonomy_fix_menu_page() 
    {         
        //Parent
        $pageMain = add_menu_page('File List Pro', 'File List Pro', 'edit_posts','/filelistpro',PRETTY_FILE_LIST_PRO_PATH . 'includes/prettylistpro_import_admin.php',PRETTY_FILE_LIST_PRO_URL .'images/filelistpro16.png',21.9);
        
        //Settings
        $pageSub = add_submenu_page('/filelistpro', 'File List Pro Settings', 'Settings', 'edit_posts','', array($this,'srf_prettylistpro_admin_options'));
        
        
        //Tag fixer
        $test = add_submenu_page('/filelistpro', 'Import old tags into new', 'Import old tags', 'manage_options', PRETTY_FILE_LIST_PRO_PATH . 'includes/old_tags_convertor.php');
        
        
        //Add admin preview script only to our pages
        //add_action( 'admin_print_styles-' . $pageSub, array($this,'srf_prettylist_admin_scripts_two'));
    }
    
    //Get the options page from an include file
	function srf_prettylistpro_admin_options() 
	{
        include(PRETTY_FILE_LIST_PRO_PATH . 'includes/prettylistpro_import_admin.php');                
	}  

	/**********************
	LOAD ADMIN MENU SCRIPTS
     **********************/
	function srf_prettylist_admin_scripts()
	{                        
        $params = array('pluginUrl' => PRETTY_FILE_LIST_PRO_URL,'altPluginUrl' => get_bloginfo('template_directory') . '/prettystyles/');
        wp_register_script('prettylistpreviewer', PRETTY_FILE_LIST_PRO_URL . 'js/style_previewer.js');
        wp_localize_script('prettylistpreviewer', 'prettylistScriptParams', $params );
        wp_enqueue_script('prettylistpreviewer' );
	}
    
	function srf_prettylist_admin_scripts_two()
	{                        
        $params = array('pluginUrl' => PRETTY_FILE_LIST_PRO_URL,'altPluginUrl' => get_bloginfo('template_directory') . '/prettystyles/');
        wp_register_script('prettylistpreviewer', PRETTY_FILE_LIST_PRO_URL . 'js/style_previewer.js');
        wp_localize_script('prettylistpreviewer', 'prettylistScriptParams', $params );
        wp_enqueue_script('prettylistpreviewer' );
	}        
    
	function srf_prettylist_frontend_scripts(){
        //Localisation texts
        $params = array(
            'defaultSearchMessage' => __('Search...','prettyfilelist'),
            'noSelectedTypeMessage' => __('No files of selected type(s) found.','prettyfilelist'),
            'noTypeMessage' => __('No types selected.','prettyfilelist'),
            'noFilesFoundMessage' => __('No files found.','prettyfilelist')
        );
        //Localize and script enqueue done in shortcode so we can get attributes
        wp_register_script('prettylistjs', PRETTY_FILE_LIST_PRO_URL . 'js/PrettyFileList.js');  
        wp_enqueue_script("jquery");
	    wp_enqueue_script('prettylistjs' );
        wp_localize_script( 'prettylistjs', 'FileListProParams', $params );            
	}
	
	
    
	/**********************
	SAVE ADMIN MENU SETTINGS
     **********************/

	/*Save value of "srf_prettylist" selection in media uploader */
    function srf_attachment_field_prettylist_save( $post, $attachment ) {
        //if( isset( $attachment['srf_prettylist-include'] ) ) 
        //update_post_meta( $post['ID'], 'srf_prettylist-include', $attachment['srf_prettylist-include'] );  
        return $post;
	}
    
    function load_admin_scripts_styles(){
        //Only load if needed
        global $post_type;
        if( 'external_file_link' == $post_type ){
            wp_enqueue_style( 'external_file_links_admin_style', PRETTY_FILE_LIST_PRO_URL . 'css/external_file_links_admin.css' );
            wp_enqueue_style( 'external_file_links_jqueryui_style', 'http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css');
            
            //Core stuff
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui' );
            wp_enqueue_script( 'jquery-ui-datepicker');                
            
            //Validator                
            wp_register_script('jquery-validator', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.min.js');
            wp_enqueue_script('jquery-validator');
            
            wp_register_script('jquery-validator-additional', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/additional-methods.min.js');
            wp_enqueue_script('jquery-validator-additional');                
            
            //Main js for editor
            $params = array('pluginUrl' => PRETTY_FILE_LIST_PRO_URL);                
            wp_register_script('external_file_links_admin_script', PRETTY_FILE_LIST_PRO_URL . 'js/external_file_links_admin.js');
            wp_localize_script('external_file_links_admin_script', 'plugin_initScriptParams', $params );
            wp_enqueue_script('external_file_links_admin_script' );
            
        }
    }	
    
    /*********************
	ADD MEDIA OPTION
     **********************/	
	function srf_extra_media_fields( $form_fields, $post ){
        
        // Get tags from file
        $tags = get_post_meta( $post->ID, 'file_list_pro_tags', true );
        
        // If no tags set empty
        if( !isset( $tags ) ){$tags = "";}
        
        $html = "<div class='fileListProTags'>";
        $html .= "<input type='text' name='attachments[$post->ID][file_list_pro_tags]' value='{$tags}' />";
        $html .= "<p class='help'>Enter a list of tags separated by commas.</p>";
        $html .= "</div>";
        
        // Construct the form field
        $form_fields['file_list_pro_tags'] = array(
          'label' => 'File List Pro Tags',
                  'input' => 'html',
          'html'  => $html,
        );
        
        // Return all form fields
        return $form_fields;
	}        

	/*Save tags in media uploader */
	function srf_extra_media_fields_save( $post, $attachment ) {  
        update_post_meta( $post['ID'], 'file_list_pro_tags', $attachment['file_list_pro_tags'] );
        return $post;
	}        
    
	/*********************
	ADD SHORTCODE BUTTON
     **********************/	
	
    function add_button() {
        if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
        {  
            add_filter('mce_external_plugins', array($this,'add_plugin'));
            add_filter('mce_buttons', array($this,'register_button'));
        }
    }  

    function register_button($buttons) {  
        array_push($buttons, "prettylist");  
        return $buttons;  
    }  

    function add_plugin($plugin_array) {  
        $plugin_array['prettylist'] = PRETTY_FILE_LIST_PRO_URL.'js/ModalCreate.js';  
        return $plugin_array;  
    } 	

    function get_theme_file($relative) {
        return sprintf('%s/%s/%s', get_theme_root(), get_template(), $relative);
    }
}

//Engage.  
$PrettyFileListProPlugin_Class = new PrettyFileListProPlugin_Class();  
?>