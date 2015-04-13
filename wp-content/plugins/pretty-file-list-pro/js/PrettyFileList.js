jQuery(function($) {
        //SETTINGS        
        var searchBoxDefault = FileListProParams.defaultSearchMessage;//"Search...";        
        
        var allPFLContainers = $('.prettyFileList');                
        
        allPFLContainers.each(function(){
            //DOM OBJECTS
            
            //File container
            var allFilesContainer = $(this);
            //Message box
            var messageBox = $('.prettyMessage',allFilesContainer);
            var messageText = $('span',messageBox);           
            //All files
            var filteredFiles = $('.prettylink',allFilesContainer);
            //Working file list
            var allFiles = filteredFiles.clone();
            //File container
            var fileContainer = $('.prettyListItems',allFilesContainer);
            //Next and prev buttons
            var nextButton = $('.pfl_next',allFilesContainer);
            var prevButton = $('.pfl_prev',allFilesContainer);
            //Paging info
            var pageAt = allFilesContainer.data('filesperpage');
            var paginationContainer = $('.prettyPagination',allFilesContainer);
            var currentPageCounter = $('.currentPage',allFilesContainer);
            var totalPageCounter = $('.totalPages',allFilesContainer);
            //Top bar
            var searchAndFilterContainer = $('.prettyFileBar',allFilesContainer);	
            //Filters
            var showFilterBtn = $('.showFilterBtn',allFilesContainer);
            var filterLinksContainer = $('.prettyFileFilters',allFilesContainer);
            var filterLinks = $('li a',filterLinksContainer);
            //Sorting
            var showSortingBtn = $('.showSortingBtn',allFilesContainer);
            var sortingLinksContainer = $('.prettyFileSorting',allFilesContainer);
            var sortingLinks = $('.prettyFileSorting li a',allFilesContainer);

            //Search
            var searchBoxContainer = $('.prettyFileListSearch',allFilesContainer);
            var searchBox = $('.prettySearchValue',searchBoxContainer);
            var searchButton = $('.doPrettySearch',searchBoxContainer);
            var clearSearchButton = $('.clearSearch',searchBoxContainer);
            var hideInitially = allFilesContainer.data('hideinitially');//Hide items until search 
            var currentlyHidden = hideInitially;

            //VARIABLES
            var currentPage = 0;
            //Total number of files
            var totalFiles = filteredFiles.length;	
            //Total pages
            var totalPages = (Math.ceil(totalFiles / pageAt));
            
            //Show pages and paging
            function showHidePages(){
                //Hide if only showing after search
                if(hideInitially == true && searchBox.val() === searchBoxDefault){
                    fileContainer.hide(); 
                    paginationContainer.hide();
                    showFilterBtn.hide();    
                    showSortingBtn.hide();
                }
                else{

                    //Hide all
                    filteredFiles.hide();                

                    //Show current page
                    filteredFiles.filter(':lt(' + ((currentPage + 1)  * pageAt) + ')').css('display', 'block');
                    filteredFiles.filter(':lt(' + (currentPage * pageAt) + ')').hide();

                    //Remove loading
                    fileContainer.removeClass('loading');

                    //Set paging
                    if(currentPage === 0){
                        prevButton.addClass('disabled');
                    }
                    else{
                        prevButton.removeClass('disabled');
                    }
                    if(currentPage === (totalPages - 1)){
                        nextButton.addClass('disabled');
                    }
                    else{
                        nextButton.removeClass('disabled');
                    }

                    //Update paging text
                    if(totalPages > 1){
                        paginationContainer.show();
                        currentPageCounter.text(currentPage + 1);
                        totalPageCounter.text(totalPages);
                        //hide pages as not needed
                        paginationContainer.show();
                    }
                    else{
                        //hide pages as not needed
                        paginationContainer.hide();
                    }  

                    fileContainer.show();   
                    showFilterBtn.show();    
                    showSortingBtn.show();     
                }
            }

            //Reset paging
            function resetPaging(){
                //Back to first page
                currentPage = 0;
                //Recalculate total pages
                totalPages = (Math.ceil(filteredFiles.length / pageAt));
            }

            //Show and hide error message
            function showHideMessage(message){
                    messageText.text(message);

                    if(message.length > 0){
                        //Get the filtered files again and then Delete all files
                        filteredFiles.remove();
                        //Reset paging
                        currentPage = 0;
                        //Total pages
                        totalPages = 1;			
                        //Refilter
                        showHidePages();
                        //Show the error message
                        messageBox.show();
                    }
                    else{
                        messageBox.hide();
                    }
            }

            //EVENTS
            //Next and prev buttons only wired up if needed
            if(pageAt < totalFiles){
                    
                    //Next click
                    nextButton.click(function(){
                        if($(this).hasClass('disabled')){return false;}
                        currentPage++;                        
                        showHidePages();
                        return false;
                    });

                    //Prev click
                    prevButton.click(function()
                    {
                        if($(this).hasClass('disabled')){return false;}
                        currentPage--;
                        showHidePages();
                        return false;
                    });
            }

            //Filtering
            //Show filters
            showFilterBtn.click(function(){		
                    sortingLinksContainer.hide();		
                    filterLinksContainer.toggle();
                    return false;
            });

            //Hide filters
            $('.cross',filterLinksContainer).click(function(){
                    sortingLinksContainer.hide();
                    filterLinksContainer.toggle();
                    return false;
            });

            //Filter item clicked
            filterLinks.click(function(){                    
                //Get the type we're looking for
                $(this).toggleClass('showing');
                
                //Get all types that are selected
                var typeToShow = $('.prettyFileFilters a.showing',allFilesContainer);
                var typesString = "";
                var typeCount = typeToShow.length;

                if(typeCount > 0){
                    $.each(typeToShow,function(index,element){
                        typesString += "." + $(this).data('filter-type');
                        if (index != typeCount - 1) {
                                typesString += ',';
                        }
                    });
                        //Delete all files
                        filteredFiles.remove();
                        //Reclone them in
                        filteredFiles = allFiles.filter(typesString);
                        if(filteredFiles.length === 0){
                                showHideMessage(FileListProParams.noSelectedTypeMessage);
                        }
                        else{
                                fileContainer.append(filteredFiles);
                                //Reset paging
                                resetPaging();
                                //Refilter
                                showHidePages();
                                //Clear any messages
                                messageBox.hide();
                                messageText.text("");
                        }
                }
                else{
                        showHideMessage(FileListProParams.noTypeMessage);
                }
                return false;
            });	

        //SEARCH
        //Show active state
        searchBox.focus(function(e){  
            $(this).addClass("active"); 
            if($(this).val() === searchBoxDefault){ 
                    $(this).val("");
            }
        });  
        //Clear active state
        searchBox.blur(function(e){  
            $(this).removeClass("active");  
                if($(this).val() === "") {
                        $(this).val(searchBoxDefault);  
                }
        }); 

            //Fire search on enter key
            searchBox.keydown(function (e){
                    if(e.keyCode === 13){
                            searchButton.click();
                    }
            });	

            searchButton.click(function(){                
                    //Check for a search term		
                    if(searchBox.val() !== "" && searchBox.val() !== searchBoxDefault){	
                            searchBox.removeClass("error");
                            //Clear all files
                            filteredFiles.remove();
                            filteredFiles = allFiles.filter(':containsNC(' + searchBox.val() + ')');
                            if(filteredFiles.length > 0){
                                    fileContainer.append(filteredFiles);

                                    resetPaging();
                                    //Refilter
                                    showHidePages();
                                    //Clear any messages
                                    showHideMessage("");
                                    clearSearchButton.removeClass('hidden');
                            }
                            else{
                               clearSearchButton.removeClass('hidden');
                               showHideMessage(FileListProParams.noFilesFoundMessage);
                            } 
                    }
                    else{
                            searchBox.addClass("error");
                    } 
                    //TODO: Clear filters? Or filter results
            });
            
            clearSearchButton.click(function(){                  
                //Clear value
                searchBox.val(searchBoxDefault);
                //Clear all
                resetWholeList();
            });

            //RESET ALL
            //
            function resetWholeList(){

                //Clear all files
                filteredFiles.remove();
                filteredFiles = allFiles;
                fileContainer.append(filteredFiles);

                //Reset paging
                resetPaging();
                //Refilter
                showHidePages();
                //Clear any messages
                messageBox.hide();
                messageText.text("");  

                if(hideInitially == false || searchBox.val() === searchBoxDefault){
                    //Hide clear button
                    clearSearchButton.addClass('hidden');                    
                }
            }

            //SORTING
            //Show options
            showSortingBtn.click(function(){
                filterLinksContainer.hide();
                sortingLinksContainer.toggle();
                return false;
            });
            //Hide option 
            $('.cross',sortingLinksContainer).click(function(){
                filterLinksContainer.hide();
                sortingLinksContainer.toggle();
                return false;
            });

            $(sortingLinks).click(function(){
                    var clicked = $(this);
                    //Get sort type
                    var sortType = clicked.data("sort-type");
                    var sortDirection = "";
                    var sortLinks = $(sortingLinks);
                    sortDirection = clicked.data("sort-direction");

                    //Clear all direction classes
                    sortLinks.attr('class','');

                    //Get sort direction
                    if(sortDirection === "" || sortDirection === undefined){
                        //If no sort direction clear all
                        sortLinks.data('sort-direction','');
                        //Set to asc
                        sortDirection = 'asc';
                    }
                    else{
                        if(clicked.data('sort-direction') === 'asc'){
                                sortDirection = 'dec';
                        }
                        else{
                                sortDirection = 'asc';
                        }
                    }

                    //Add the sort direction to the item
                    clicked.data('sort-direction',sortDirection);
                    clicked.addClass(sortDirection);

                    //Clear all sort directions
                    sortList(sortDirection,sortType);
                    sortingLinksContainer.slideToggle();
                    return false;
            });

            function sortList(direction,sortType){
                filteredFiles.remove();

                //pick the sort type
                var sortAlg = direction + "_" + sortType;
                
                //pick the sort
                //Do switch because eval is evil ;)
                switch (sortAlg){
                    case 'asc_bytype':
                        filteredFiles = filteredFiles.sort(asc_bytype);
                        break;
                    case 'dec_bytype':
                        filteredFiles = filteredFiles.sort(dec_bytype);
                        break;
                    case 'asc_bydate':
                        filteredFiles = filteredFiles.sort(asc_bydate);
                        break;
                    case 'dec_bydate':
                        filteredFiles = filteredFiles.sort(dec_bydate);
                        break;      
                    case 'asc_bytitle':
                        filteredFiles = filteredFiles.sort(asc_bytitle);
                        break; 
                    case 'dec_bytitle':
                        filteredFiles = filteredFiles.sort(dec_bytitle);
                        break;       
                    default:
                        filteredFiles = filteredFiles.sort(asc_bydate);
                        break;
                }
                    
                fileContainer.append(filteredFiles);

                //Reset paging
                resetPaging();
                //Refilter
                showHidePages();
                //Clear any messages
                showHideMessage("");

                //TYPE SORT
                // accending sort
                function asc_bytype(a, b){return (($(b).attr("class")) < ($(a).attr("class")) ? 1 : -1);}
                // decending sort
                function dec_bytype(a, b){return (($(b).attr("class")) > ($(a).attr("class")) ? 1 : -1);}  

                //DATE SORT
                // accending sort
                function asc_bydate(a, b){return (($(b).data("date")) < ($(a).data("date")) ? 1 : -1);}
                // decending sort
                function dec_bydate(a, b){return (($(b).data("date")) > ($(a).data("date")) ? 1 : -1);}

                //TITLE SORT
                // accending sort
                function asc_bytitle(a, b){
                    var newA = $('.fileTitle',$(a));
                    var newB = $('.fileTitle',$(b));
                    return (newB.text() < newA.text() ? 1 : -1);
                }
                // decending sort
                function dec_bytitle(a, b){
                    var newA = $('.fileTitle',$(a));
                    var newB = $('.fileTitle',$(b));
                    return (newB.text() > newA.text() ? 1 : -1);
                }
            }


            /*Show all files button*/
            $('.btn',messageBox).click(	
                function(){
                   //Clear all
                   resetWholeList();
                   return false;
                }		
            );
            
            	
            //MAIN
            //Show initial page
            showHidePages();
            
        });

	//FUNCTIONS
	//case-insensitive version of :contains        
        if(jQuery.fn.jquery == '1.8.0'){
            //jquery 1.8.0 kills the other method            
            jQuery.expr[":"].containsNC = jQuery.expr.createPseudo(function(arg) {
                return function( elem ) {
                    return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
                };
            });
        }
        else{
            $.extend($.expr[":"], {
                "containsNC": function(elem, i, match, array) {
                        return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
                }
            });
        }

});