<?php
    //Add css file for admin
    //$admin_stylesheet_url = PRETTY_FILE_LIST_PRO_URL . 'css/admin.css';
//    wp_register_style('srfprettylistadminStyleSheets', $admin_stylesheet_url);
//    wp_enqueue_style( 'srfprettylistadminStyleSheets');

    //Blank message created
    $message = "";

    //The @ suppresses an error if post[action] is not set
    if (@$_POST['action'] == 'update')  
    {  
          //todo: make this a method and save an array
          //Set the option to the form variable                
          updateOption('stylesheet_to_use');
          updateOption('openinnew');
          updateOption('hidefilter');
          updateOption('hidesearch');
          updateOption('hidesort');
          updateOption('wprevmode');
          updateOption('usecustomtemplate');
          updateOption('date_format');//srf_pflpro_date_format

          //Send a message to the user to let them know it was updated
          $message = '<div id="message" class="updated fade"><p><strong>' . __('Options saved','prettyfilelist') . '</strong></p></div>';  
    }

    //path to directory to scan
    $directory = PRETTY_FILE_LIST_PRO_PATH . 'styles/';
    $altDirectory = get_template_directory() . '/prettystyles/';

    //get all css files with a .css extension.
    $styles = glob($directory . "*.css");
    $altStyles = glob($altDirectory . "*.css");  

    //Get our options
    $options['srf_pflpro_stylesheet_to_use'] = get_option('srf_pflpro_stylesheet_to_use');
    $options['srf_pflpro_openinnew'] = get_option('srf_pflpro_openinnew');
    $options['srf_pflpro_usecustomtemplate'] = get_option('srf_pflpro_usecustomtemplate');
    $options['srf_pflpro_hidefilter'] = get_option('srf_pflpro_hidefilter');
    $options['srf_pflpro_hidesearch'] = get_option('srf_pflpro_hidesearch');
    $options['srf_pflpro_hidesort'] = get_option('srf_pflpro_hidesort');
    $options['srf_pflpro_date_format'] = get_option('srf_pflpro_date_format');        
    $options['srf_pflpro_wprevmode'] = get_option('srf_pflpro_wprevmode'); 
          

    //Display options form
    echo '<div class="wrap">' . $message;                     
        echo '<div class="icon32"><br /></div>';
        echo '<h2>File List Pro - Settings</h2>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="action" value="update" />';
                   
        //LIST STYLE
        echo '<h3>Styling</h3>';
        echo '<table class="form-table">';
            echo '<tbody>';
                echo '<tr valign="top">';
                    echo '<th scope="row">Pick a style</th>';
                    echo '<td>';
                        echo '<style id="Previewer"></style>';

                    echo '<select name="stylesheet_to_use" id="show_pages">';
		
                    //Print each available css file
                    //Core styles
                    foreach($styles as $style)
                    {
                        echo '<option value="' . basename($style) .'"' . (basename($style) == $options['srf_pflpro_stylesheet_to_use'] ? 'selected="selected"' : '')  . '>' . friendlyCssFileName(basename($style)) . '</option>';
                    }
                    //Custom styles
                    foreach($altStyles as $style)
                    {
                        echo '<option value="' . basename($style) .'#"' . (basename($style) == $options['srf_pflpro_stylesheet_to_use'] ? 'selected="selected"' : '')  . '>' . friendlyCssFileName(basename($style)) . ' (Custom)</option>';
                    }
	  
                    echo '</select>';
                    echo '</td>';
                echo '</tr>';
        
                //USE CUSTOM TEMPLATE
                echo '<tr valign="top">';
                    echo '<th scope="row">Template</th>';
                        echo '<td>';
                            echo '<fieldset>';
                                echo '<legend class="screen-reader-text"><span>Use a custom template</span></legend>';
                                    echo '<label for="usecustomtemplate"><input type="checkbox"' . ($options['srf_pflpro_usecustomtemplate'] == 'true' ? 'checked="checked"' : '')  . ' value="true" name="usecustomtemplate" id="usecustomtemplate"/> Use a custom template.</label>';
                            echo '</fieldset>';
                            echo '<span style="color:#777"><i>To create a custom template make a copy of the <strong>templates/pflprotemplate.php</strong> file in the root of your active theme.</i></span>';
                        echo '</td>';
                echo '</tr>';
        
            echo '</tbody>';
        echo '</table>';
        
        //WP Revisions mode
        if(is_plugin_active('wp-document-revisions/wp-document-revisions.php')){
        echo '<h3>WP Document Revisions</h3>';
        echo '<p>It looks like you\'re using WP Document Revisions on the site. File List Pro can adapt to use files from WP Document Revisions instead of the Media Library.</p>';
        echo '<table class="form-table">';
            echo '<tbody>';

                
                    echo '<tr align="top">';
                    echo '<th scope="row">&nbsp;</th>';
                    echo '<td>';
                    echo '<fieldset>';
                    echo '<legend class="screen-reader-text"><span>Use WP Document Revisions for file listings.</span></legend>';
                    
                    echo '<label for="wprevmode"><input type="checkbox"' . checked($options['srf_pflpro_wprevmode'],'true',false)  . ' value="true" name="wprevmode" id="wprevmode"/> Use WP Document Revisions for file listings.</label>';
                    echo '</fieldset>';
                    echo '</td>';
                    echo '</tr>';
                
            echo '</tbody>';
        echo '</table>';
        }
        
        //Other options
        echo '<h3>Other options</h3>';
        echo '<p>These options are site wide and WILL override settings on individual lists.</p>';
        echo '<table class="form-table">';
            echo '<tbody>';                        
            
                echo '<tr valign="top">';
                    echo '<th scope="row">Links</th>';
                    echo '<td>';
                        echo '<fieldset>';
                            echo '<legend class="screen-reader-text"><span>Force links to open in a new window.</span></legend>';
                            echo '<label for="openinnew"><input type="checkbox"' . ($options['srf_pflpro_openinnew'] == 'true' ? 'checked="checked"' : '')  . ' value="true" name="openinnew" id="openinnew"/> Force links to open in a new window.</label>';
                        echo '</fieldset>';
                    echo '</td>';
                echo '</tr>';
        
                echo '<tr valign="top">';
                    echo '<th scope="row">Functionality</th>';
                        echo '<td>';
                            echo '<fieldset>';
                                echo '<legend class="screen-reader-text"><span>Hide filter button</span></legend>';
                                    echo '<label for="hidefilter"><input type="checkbox"' . ($options['srf_pflpro_hidefilter'] == 'true' ? 'checked="checked"' : '')  . ' value="true" name="hidefilter" id="hidefilter"/> Hide filter button.</label>';
                            echo '</fieldset>';
                        echo '</td>';
                echo '</tr>';
        
                echo '<tr valign="top">';
                    echo '<th scope="row">&nbsp;</th>';
                    echo '<td>';
                        echo '<fieldset>';
                            echo '<legend class="screen-reader-text"><span>Hide search box</span></legend>';
                            echo '<label for="hidesearch"><input type="checkbox"' . ($options['srf_pflpro_hidesearch'] == 'true' ? 'checked="checked"' : '')  . ' value="true" name="hidesearch" id="hidesearch"/> Hide search box</label>';
                        echo '</fieldset>';
                    echo '</td>';
                echo '</tr>';
        
                echo '<tr valign="top">';
                    echo '<th scope="row">&nbsp;</th>';
                    echo '<td>';
                        echo '<fieldset>';
                            echo '<legend class="screen-reader-text"><span>Hide sort button</span></legend>';
                            echo '<label for="hidesort"><input type="checkbox"' . ($options['srf_pflpro_hidesort'] == 'true' ? 'checked="checked"' : '')  . ' value="true" name="hidesort" id="hidesort"/> Hide sort button.</label>';
                        echo '</fieldset>';
                    echo '</td>';
                echo '</tr>';
        
                echo '<tr valign="top">';
                    echo '<th scope="row">Date format</th>';
                    echo '<td>';
                        echo '<fieldset>';
                            echo '<legend class="screen-reader-text"><span>Date format</span></legend>';
                            echo '<label for="date_format"><input type="text" value="' . ($options['srf_pflpro_date_format'] == "" ? 'jS M Y' : $options['srf_pflpro_date_format']) . '" name="date_format" id="date_format"/></label>';
                        echo '</fieldset>';
                
                        echo '<span><a href="http://php.net/manual/en/datetime.formats.date.php">Php date format string</a>.</span>';
                    echo '</td>';
                echo '</tr>';
            echo '</tbody>';
        echo '</table>';
        //Save button
        echo '<p><input type="submit" class="button-primary" value="Save Changes" /></p>';
        //Example
        echo '<h3 style="clear:both;width:100%;">Current style example:</h3>
        <div class="prettyFileList" style="max-width:600px;">
        <div class="prettyFileBar"><a class="showFilterBtn float_right corePrettyStyle btn" href="#">Filter</a><a class="showSortingBtn float_right corePrettyStyle btn" href="#">Sort</a><div class="prettyFileFilters"><ul class="unstyled"><li><a class="pdfFilter pdf showing" data-filter-type="pdf" href="">PDF</a></li><li><a class="xlsFilter xls showing" data-filter-type="xls" href="">Excel</a></li><li><a class="docFilter doc showing" data-filter-type="doc" href="">Word</a></li><li><a class="pptFilter ppt showing" data-filter-type="ppt" href="">Powerpoint</a></li><li><a class="zipFilter zip showing" data-filter-type="zip" href="">Zip</a></li></ul><p class="bar"><a class="cross" href="#">Close</a></p></div><div class="prettyFileSorting"><ul class="unstyled"><li><a class="asc" data-sort-direction="asc" data-sort-type="bydate" href="">By Date</a></li><li><a data-sort-type="bytitle" href="">By Name</a></li><li><a class="" data-sort-type="bytype" href="">By Type</a></li></ul><p class="bar"><a class="cross" href="#">Close</a></p></div><div class="prettyFileListSearch"><label style="display:none;">Search</label><input type="text" class="prettySearchValue" value="Search..."><a class="doPrettySearch btn corePrettyStyle">Go</a><a class="clearSearch btn corePrettyStyle hidden">Clear</a></div></div>
        <div class="prettyListItems"><a href="#" class="prettylink corePrettyStyle pdf">A pdf example pretty file link</a>
        <a href="#" class="prettylink corePrettyStyle xls">An Excel spreadsheet example pretty file link</a>
        <a href="#" class="prettylink corePrettyStyle ppt">A PowerPoint example pretty file link</a>
        <a href="#" class="prettylink corePrettyStyle doc">A Word document example pretty file link</a>
        <a href="#" class="prettylink corePrettyStyle zip">A Zip file example pretty file link</a></div>
        <div class="prettyPagination"><a class="pfl_next btn corePrettyStyle" href="#">Next »</a><span class="pagingInfo">Page <span class="currentPage">1</span> of <span class="totalPages">2</span></span><a class="pfl_prev btn disabled corePrettyStyle" href="#">« Prev</a></div>
        </div>';	
        echo '</form></div>';

        
        function updateOption($optionName){

                //new window
                if(@$_POST[$optionName]){
                    update_option('srf_pflpro_' . $optionName, $_POST[$optionName]);
                }
                else{
                    update_option('srf_pflpro_' . $optionName, '');
                }
            
        }
        
        function friendlyCssFileName($unfriendlyName){
            $friendlyName = str_replace('_',' ',$unfriendlyName);
            $friendlyName = str_replace('.css','',$friendlyName);
            return $friendlyName;
        }
        ?>

