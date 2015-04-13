
//VARIABLES
var pickerType = "criteria"; //Set initial pick type
var pathToAjax = "";
var currentPostId = "";
var isRTL = $('body').hasClass('rtl');
var wpRevMode = false;


//FUNCTIONS
//case-insensitive version of :contains
$.extend($.expr[":"], {
    "containsNC": function(elem, i, match, array) {
            return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
});

var ButtonDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ButtonDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
                currentPostId = jQuery(ed["formElement"]["post_ID"]).val();   
                var data = {
                    action: 'get_all_files',
                    wprevmode: 'false'
                };
                                
                pathToAjax = (ed['buttons']['prettylist']['pluginurl']);
                
                //get attached files
                jQuery.post(pathToAjax, data, function(response) {
                    $('#AllAttachedFiles').html(response);
                    //Check if wp rev mode
                    wpRevMode = $(response).data('wprevmode');
                });                  
                
	},
	insert : function insertButton(ed) { 
                                  
                ////Validate the form first 
                var isValid = true;
                var typeString = "";
                var tagString = "";

                //Set variables based on picker type
                if(pickerType == "criteria"){
                    //Get variables
                    //Dates
                    var fromDate = $('#FromDate').val();
                    var endDate = $('#ToDate').val();
                    //Checked items
                    var types = jQuery(':checked','#TypeList');
                    //Checked tags
                    var tags = jQuery('input:checked','#Tags');
                    
                    //Make types into a string
                    types.each(function(){
                        if(typeString != ""){
                                typeString += ',';
                        }
                        typeString += jQuery(this).val();
                    });
                    
                    //Make tags into a string
                    tags.each(function(){
                        if(tagString != ""){
                                tagString += ',';
                        }
                        tagString += jQuery(this).val();
                    });
                    //validate dates
                    //Make sure that if two dates are entered they are logical
                    if(fromDate != "" && endDate != "" && (fromDate > endDate)){
                        $('#DateError').removeClass('hidden');
                        isValid = false;
                    }
                    else{
                        $('#DateError').addClass('hidden');
                    }

                    //Check at least one type selected
                    if(types.length == 0){                    
                        $('#TypeError').removeClass('hidden');
                        isValid = false;
                    }
                    else{
                        $('#TypeError').addClass('hidden');
                    }
                }
                else{
                    //Check to see if a file has been picked
                    if(jQuery('.file:checked').length == 0){                       
                        //Error
                        $('#FileError').removeClass('hidden');
                        isValid = false;
                    }
                    else{
                        //Is valid
                        typeString = "pdf,xls,doc,zip,ppt,img,mp3";
                        $('#FileError').addClass('hidden');
                        isValid = true;
                    }
                }
                
                //Quit out if invalid
                if(isValid == false) {
                    return;                    
                }

		var filesPerPage = jQuery('#FilesPerPage').val();
                
                //Get output var ready
		var output = '';

		//Build the output of our shortcode
		output = '[prettyfilelist ';
                
                output += 'type="' + typeString + '" ';
                
                //If criteria based list
                if(pickerType == "criteria"){
                    //Add the tags
                    output += tagString != "" ? ' tags="' + tagString + '" ' : "";

                    //Add the date range   
                    output += jQuery('#FromDate').val() != "" ? ' startdate="' + jQuery('#FromDate').val() + '" ' : "";
                    output += jQuery('#ToDate').val() != "" ? ' enddate="' + jQuery('#ToDate').val() + '" ' : "";
                    //This post only?
                    output += jQuery('#thispostonlycrit').is(":checked") ? 'thispostonly="true" ' : "";
                }
                else{                   
                    //Get files to display
                    var fileList = "";
                    $('.file:checked').each(function(){
                        fileList += $(this).val() + ',';
                    });        
                
                    //Add file list
                    output += fileList != "" ? ' filestoshow="' + fileList + '" ' : "";
                    //This post only?
                    output += jQuery('#thispostonly').is(":checked") ? 'thispostonly="true" ' : "";                    
                }
                
	            //WP Rev mode
	            output += (wpRevMode == true || wpRevMode == 'true' ? ' wprevmode="true" ' : '');

                //Add sorting
                output += jQuery('#FieldToSortBy').val() != "post_date" ? 'orderby="' + jQuery('#FieldToSortBy').val() + '" ' : "";
                output += jQuery('#DirectionToSortBy').val() != "DESC" ? 'orderdir="' + jQuery('#DirectionToSortBy').val() + '" ' : "";
                               
                //Hide buttons
                output += jQuery('#hidefilter').is(":checked") ? 'hidefilter="true" ' : "";
                output += jQuery('#hidesort').is(":checked") ? 'hidesort="true" ' : "";
                output += jQuery('#hidesearch').is(":checked") ? 'hidesearch="true" ' : "";                
                
                //Open in new window?
                output += jQuery('#openinnew').is(":checked") ? 'openinnew="true" ' : "";

		output += 'filesPerPage="' + filesPerPage + '"]';
			
		// inserts the shortcode into the active editor
		tinyMCE.activeEditor.execCommand('mceInsertContent', 0, output);
		
		// closes Thickbox
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);
 
$(document).ready(function(){  
    //Date picker
    $('.datepicker').datepicker({buttonImage: '../images/silk_icons/date.png',showOn: "both",buttonImageOnly: true});
    
    //Search error
    var noneFoundMessage = $('#noneFoundMessage');
    //File Container
    var fileContainer = $('#AllAttachedFiles');
    //Clear search
    var clearSearch = $('#ClearSearch');
    var allFiles = "";
    


    //TODO: Make search work
    //Hide all others, and uncheck
    searchButton = $('#DoSearch');
    searchBox = $('#SearchFiles'); 
    
    //Fire search on enter key
    searchBox.keydown(function (e){
        if(e.keyCode === 13){
            searchButton.click();
        }
    });	

    searchButton.click(function(){		
        //Check for a search term		
        if(searchBox.val() !== ""){	
            searchBox.removeClass("error");
            allFiles = $('li',fileContainer);
            filteredFiles = allFiles.filter(':containsNC(' + searchBox.val() + ')');
            if(filteredFiles.length > 0){
                allFiles.hide();
                filteredFiles.show();
                noneFoundMessage.addClass('hidden');
            }
            else{
                allFiles.hide();                        
                noneFoundMessage.removeClass('hidden');
            } 
            
            clearSearch.removeClass('hidden');
        }
        else{
            searchBox.addClass("error");
        } 
        
        return false;
    });
            
    clearSearch.click(function(){                
        //Hide button
        $(this).addClass('hidden');
        //Clear value
        searchBox.val('');
        //Show all files
        allFiles.show();
        //Clear error
        noneFoundMessage.addClass('hidden');
        
        return false;
    });
    
    //Select/deselect file types
    $('#TypeList').on('click','label',function(e){
        var clicked = $(e.target);
        
        if(clicked.is('label')){
            clicked.toggleClass('selected');
            $('input',clicked).prop("checked", !$('input',clicked).prop("checked"));
        }
    });
    
    //Load correct files depending on checkbox
    $('#thispostonly').click(function(){
        if($(this).is(':checked')){            
            //Load only this post
                var data = {
                    action: 'get_attached_files',
                    currentPostId: currentPostId
                };               
                
                //Add loading, remove all files
                fileContainer.addClass('loading').html("");
                
                //get attached files
                $.post(pathToAjax, data, function(response) {
                    //Remove loading, add local files
                    fileContainer.removeClass('loading').html(response);
                });
        }
        else{
            //Load all files
            //Load only this post
            var data = {
                action: 'get_all_files'
            };               

            //Add loading, remove all files
            fileContainer.addClass('loading').html("");

            //get attached files
            $.post(pathToAjax, data, function(response) {
                //Remove loading, add all files
                fileContainer.removeClass('loading').html(response);
            });            
        }
    });    


       //File type choice
       $('a','#FileTypeChoice').click(function(e){
            if($(this).hasClass('pickFiles')){
                $('#PickItems').removeClass('hidden');
                pickerType =  "pickfiles";
            }
            else{
                $('#GenerateList').removeClass('hidden');
                //get_all_terms_ajax
                var data = {
                    action: 'get_all_file_types'
                };                
                //Get all file types
                $.post(pathToAjax, data, function(response) {
                    //Remove loading, add local files
                    $('#TypeList').removeClass('loading').html(response);
                });
                
                //get_all_terms_ajax
                var data = {
                    action: 'get_all_terms',
                    currentPostId: currentPostId
                };
                
                //Add loading, remove all files
                $('#Tags').addClass('loading').html("");
                
                //get attached files
                $.post(pathToAjax, data, function(response) {
                    //Remove loading, add local files
                    $('#Tags').removeClass('loading').html(response);
                });
                pickerType =  "criteria";
            }
            if(isRTL){
                scroller.animate({right: '-=600'},200);
            }
            else{
                scroller.animate({left: '-=600'},200);
            }
           
           return false;
       });
       
       //Load external file list
       $('.viewOptions','#PickItems').click(function(){
            //Check to see if a file has been picked
            if(jQuery('.file:checked').length == 0){                       
                //Error
                $('#FileError').removeClass('hidden');
                isValid = false;                
            }
            else{
                //Is valid
                typeString = "pdf,xls,doc,zip,ppt,img,mp3";
                $('#FileError').addClass('hidden');
                isValid = true;
                //Scroll to next
                if(isRTL){
                    scroller.animate({right: '-=600'},200);
                }
                else{
                    scroller.animate({left: '-=600'},200);
                }
            }
            return false;
       });
       
        //Get scroller
        var scroller = $('#Scroller','#ScrollContainer');

       //Next button
       $('.next').click(function(){
            if(isRTL){
                scroller.animate({right: '-=600'},200);
            }
            else{
                scroller.animate({left: '-=600'},200);
            }
           return false;
       });
       
       //Back button
       $('.back').click(function(){
           //Hide both panels on back to start
           if($(this).hasClass('goToFirst')){
                $('#PickItems,#GenerateList').addClass('hidden');
           }
            if(isRTL){
                scroller.animate({right: '+=600'},200);
            }
            else{
                scroller.animate({left: '+=600'},200);
            }
           return false;
       });
    }
);
