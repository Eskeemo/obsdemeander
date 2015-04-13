/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


(function($) {
	
    $(document).ready(function(){  

        var datefield = $("#external_file_linkfiledate");
        var sizefield = $("#external_file_linkfilesize");
        var sizeunitsfield = $("#external_file_linkfilesize_units");
        var typefield = $("#external_file_linkfiletype");

        datefield.datepicker({buttonImage: plugin_initScriptParams.pluginUrl + 'images/silk_icons/date.png', maxDate: '0',showOn: "both",buttonImageOnly: true});
        
        //Validate on click
        $('#publish').click(function(){
            if($('#post').valid()){
                return true;   
            }
            else{
                //Hide the ajax and re-enable button
                $('#ajax-loading').hide();
                $('#publish').removeClass('button-primary-disabled');
                return false;
            }            
        });
        
        $('#CheckFile').click(function(){
            var thisButton = $(this);
            thisButton.addClass('loading');
            urlField = $('#external_file_linkfileurl');
                        
            //If url is completed
            if(urlField.val() != ""){                            
                var data = {
                    action: 'get_remote_file_size',
                    fileUrl: urlField.val()
                };
            
                //get attached files
                jQuery.post(ajaxurl, data, function(response){
                    //See if curl succeeded
                    if(response != -1 && response != 0){
                        
                        //remove weird 0 at end
                        response = response.slice(0,-1);    
                        
                        var file_details = jQuery.parseJSON(response);

                        if(file_details != null){
                            if(file_details[0] != -1){
                                $('#BadUrl').addClass('hidden');
                                //Set file size
                                sizefield.val(file_details[0]);
                                sizeunitsfield.val('Bytes');                                
                                //Set type
                                // remove last character from string if it's an x
                                if(file_details[1].charAt( file_details[1].length-1 ) == "x") {
                                    file_details[1] = file_details[1].slice(0,-1);
                                }
                                typefield.val(file_details[1]);
                                //Date field
                                datefield.val(file_details[2]);                            
                            }
                            else{
                                $('#BadUrl').removeClass('hidden');
                            }

                        }
                        else{
                            //Try to help a bit                    
                            //Work out the file type
                            var url = urlField.val();
                            var urlPieces = url.split(".");
                            //Assume last piece is file type
                            var fileExt = $(urlPieces).last()[0];
                            // remove last character from string if it's an x
                            if(fileExt.charAt( fileExt.length-1 ) == "x") {
                                fileExt = fileExt.slice(0,-1);
                            }

                            $('#external_file_linkfiletype').val(fileExt);
                        }
                    }
                    else{
                        $('#BadUrl').removeClass('hidden');
                    }
                    
                    //Stop loading icon
                    thisButton.removeClass('loading');
                                        
                });
            }
            return false;
        });
        
        //Make sure update is enabled on input change
        $('input','#mapListAddressSearch').change(function(){
            $('#publish').removeClass('button-primary-disabled');
        });
        
    });
})( jQuery );