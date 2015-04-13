<?php
global $post;
               
// Use nonce for verification
echo '<input type="hidden" name="custom_meta_box_nonce" value="'. wp_create_nonce(PRETTY_FILE_LIST_PRO_PATH) . '" />';
?>
<div id="FileListProExternalFile">
    <div class="form-wrap clearfix">
        <?php
        
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
                    
        foreach ($this->external_file_link_fields as $field) 
        {
            //Get the data for this field
            $meta = get_post_meta($post->ID, $field['id'], true);
            
            //See what field we're outputting
            switch ($field['name']) {
                case 'fileurl':
                ?>
                    <div class="form-field form-required">
                        <label for="<?php echo $field['id']?>"><?php _e('Url of file','prettyfilelist')?></label>
                        <input class="addExternalLinkUrl required" name="<?php echo $field['id']; ?>" type="url2" id="<?php echo $field['id']?>" value="<?php echo $meta; ?>">
                        <a href="#" id="CheckFile" class="btn">Get details</a>
                        <p class="fieldError hidden" id="BadUrl">Supported file not found at this address.</p>
                        <p><?php _e('The full url (including http://) for this file.','prettyfilelist')?></p>
                    </div>
                <?php
                break;
                case 'filesize':    
                    $file_size = "";
                    
                    if($meta != ""){
                        //File size units
                        $file_size_units = get_post_meta($post->ID, 'external_file_linkfilesize_units', true);                    
                        $file_size = $meta / $quant[$file_size_units];
                    }
                ?>
                    <div class="form-field form-optional clearfix">
                        <label for="<?php echo $field['id']?>"><?php _e('File size','prettyfilelist')?></label>
                        <input class="addExternalLinkFileSize required" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']?>" value="<?php echo $file_size; ?>" style="display:inline-block;width:50px;">
                        
                <?php
                break;            
                case 'filesize_units':
                ?>
                        <!--<label for="<?php echo $field['id']?>"><?php _e('File size unit','prettyfilelist')?></label>-->
                        <select class="addExternalLinkFileSize" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']?>" style="display:inline-block;">
                          <option value="B" <?php echo ($meta == "B" ? "selected" : "") ?>><?php _e('Bytes','prettyfilelist')?></option>
                          <option value="KB" <?php echo ($meta == "KB" ? "selected" : "") ?>><?php _e('KB','prettyfilelist')?></option>
                          <option value="MB" <?php echo ($meta == "MB" ? "selected" : "") ?>><?php _e('MB','prettyfilelist')?></option>
                          <option value="GB" <?php echo ($meta == "GB" ? "selected" : "") ?>><?php _e('GB','prettyfilelist')?></option>
                        </select>
                        <p><?php _e('The size of the file. Units are not used for display purposes, they just make it easier for you to enter details.','prettyfilelist')?></p>
                    </div>
                <?php
                break;
                case 'filedate':
                ?>
                    <div class="form-field form-required clearfix last">
                        <label for="<?php echo $field['id']?>"><?php _e('Date created/updated','prettyfilelist')?></label>                        
                        <input class="addExternalLinkFileDate required" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']?>" value="<?php echo $meta; ?>" />
                        <p><?php _e('The datestamp for when this file was last updated (MM/DD/YYYY).','prettyfilelist')?></p>
                    </div>
                <?php
                break;              
                case 'filetype':
                ?>
                    <div class="form-field form-required clearfix">
                        <label for="<?php echo $field['id']?>"><?php _e('File type','prettyfilelist')?></label>                        
                        <select class="addExternalLinkType" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']?>" style="display:inline-block;">
                        <?php
                            foreach ($this->supported_file_types as $key => $value) {
                                ?>
                                <option value="<?php echo $key ?>" <?php echo ($meta == $key ? "selected" : "") ?>><?php echo $key ?></option>
                                <?php
                            }                        
                        ?>
                        </select>
                        <p><?php _e('The file type.','prettyfilelist')?></p>
                    </div>     
                <?php
                break;  
            }
        }
        ?>                   
    </div>                
</div>