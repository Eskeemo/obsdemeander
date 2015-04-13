<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="wrap">
    <div class="icon32" id="icon-upload"><br></div>
    <h2>Tag updater</h2>    

    <?php 
    //Check not update before
        $updatedPreviously = get_option( 'old_flp_tags_updated');

        if(!$updatedPreviously){
            echo '<p>If you have been using the old tag system you need to run the tag convertor to make sure all of your lists work with the new system.</p>';
            global $wpdb;

            //MEDIA FILES
            //================================
            $querystr = "
            SELECT wposts.*
            FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
            WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_value != ''
            AND wpostmeta.meta_key = 'file_list_pro_tags'";

            $files = $wpdb->get_results($querystr, OBJECT);

            $totalUpdates = count($files);

            foreach($files as $file){
                //Get old tags
                $oldtags = get_post_meta($file->ID,'file_list_pro_tags',true);
                //Set as custom taxonomy items
                wp_set_post_terms( $file->ID, $oldtags, 'media_categories', true );
                //Clear old tags
                //delete_post_meta($file->ID, 'file_list_pro_tags');
                //Save option to say it's done                
            }            
            
            //EXTERNAL FILES
            //================================
            $querystr = "
            SELECT wposts.*
            FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
            WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_value != ''
            AND wpostmeta.meta_key = 'external_file_linktags'";

            $files = $wpdb->get_results($querystr, OBJECT);

            $totalExternalUpdates = count($files);

            foreach($files as $file){
                //Get old tags
                $oldtags = get_post_meta($file->ID,'external_file_linktags',true);
                //Set as custom taxonomy items
                wp_set_post_terms( $file->ID, $oldtags, 'media_categories', true );
                //Clear old tags 
                //delete_post_meta($file->ID, 'external_file_linktags');                
            }   
            
            echo "<p>$totalUpdates updates for media files completed.</p>";
            echo "<p>$totalExternalUpdates updates for external files completed.</p>";
            echo "<p>Total:" . ($totalUpdates + $totalExternalUpdates)  ."</p>";
            
            //Save option to say it's done
            update_option( 'old_flp_tags_updated', true);
        }
        else{
            echo "<p>You've already updated your tags. You don't need to do anything else, just enjoy the new tagging system!</p>";
        }
    ?>

</div>
