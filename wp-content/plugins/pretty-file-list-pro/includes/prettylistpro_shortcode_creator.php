<?php
// this file contains the contents of the popup window
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Insert File List</title>
<meta http-equiv="Expires" content="Sat, 1 Jan 2000 08:00:00 GMT" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script language="javascript" type="text/javascript" src="../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="../js/ShortcodeCreator.js"></script>
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="../css/ShortcodeCreator.css?v=0_1"></link>
</head>
<body class="">
    <form action="/" method="get" accept-charset="utf-8">   
    <div id="ScrollContainer">
        <div id="Scroller">
        <!--Pick file list type-->
        <div id="FileTypeChoice" class="scrollPanel">
            <a href="#" class="pickFiles btn"><h2>Pick Files</h2><span>See a list of files and choose which ones to show.</span></a>
            <a href="#" class="generateList btn"><h2>Generate List</h2><span>Select files to list by specifying criteria.</span></a>            
        </div>
        
        <!-- Pick files from a list -->
        <div id="PickItems" class="scrollPanel hidden">
            <h2>Pick Items</h2>                               
            <p>
                <label class="float_right"><input type="checkbox" name="thispostonly" id="thispostonly" value="true">This post/page only</label>
                <label>Search:</label> <input type="text" id="SearchFiles" /><a href="#" id="DoSearch" class="btn">Go</a><a href="#" id="ClearSearch" class="hidden">Clear</a>
            </p>
            <div class="fieldError hidden" id="FileError">Please pick at least one file.</div> 
            <div id="noneFoundMessage" class="hidden">No files found</div>
            <div id="AllAttachedFiles"></div> 
            <div class="buttonBox clearfix">
                <a href="" class="back btn goToFirst">Back</a>
                <a href="" class="viewOptions btn">Next</a>
            </div>
        </div>
        
        <!-- Pick files by criteria -->
        <div id="GenerateList" class="scrollPanel hidden">
            <h2>Generate List</h2>
            <div class="fieldContainer">
                <div class="fieldError hidden" id="TypeError">Please pick at least one file type.</div>            
                <label>File types:</label>
                <ul id="TypeList" class="clearfix unstyled fourColList loading"></ul>
            </div>
            
            <div class="fieldContainer">
                <div class="fieldError hidden" id="DateError">End date must be after the start date.</div>
                <div>
                    <div class="inline-block"><label>Date range:</label> </div>
                    <div class="inline-block">
                        <label for="FromDate">From</label> <input type="text" id="FromDate" class="datepicker" />
                        <label for="ToDate">To</label> <input type="text" id="ToDate"  class="datepicker"/>
                        <span class="help-inline">Leave blank to show all</span>                                                                       
                    </div>
                </div>
            </div>
            
            <div class="fieldContainer">
                <p><label>By tag</label></p>
                <div id="Tags" class="clearfix"></div>
            </div>
            
            <div class="fieldContainer">
                <p><label><input type="checkbox" name="thispostonlycrit" id="thispostonlycrit" value="true">Only show files attached to this post/page</label></p>
            </div>
            
            <div class="buttonBox clearfix">
                <a href="#" class="back btn goToFirst">Back</a>
                <a href="#" class="next btn">Next</a>
            </div>
        </div>
        
        <!-- Choose options -->
        <div id="ChooseOptions" class="scrollPanel">
            <h2>Choose List Options</h2>
            <h3>Sorting</h3>
            <div class="fieldContainer">
                    <p><label for="FieldToSortBy">Initially sort by</label>
                    <select name="FieldToSortBy" class="" id="FieldToSortBy">
                        <option value="post_date">Uploaded date</option>
                        <option value="title">Title</option>
                        <option value="random">Random</option>
                    </select>
                    <select name="DirectionToSortBy" class="" id="DirectionToSortBy">
                        <option value="DESC">Descending</option>
                        <option value="ASC">Ascending</option>
                    </select></p>                        
            </div>
            <h3>Other options</h3>
            <div class="fieldContainer" id="OtherOptions">
                <ul class="twoColList clearfix unstyled">
                <li><label><input type="checkbox" id="openinnew" name="openinnew" value="true">Open link in new window</label></li>
                <li><label><input type="checkbox" id="hidefilter" name="hidefilter" value="true">Hide filter button</label></li>
                <li><label><input type="checkbox" id="hidesort" name="openinnew" value="true">Hide sort button</label></li>
                <li><label><input type="checkbox" id="hidesearch" name="openinnew" value="true">Hide Search</label></li>
                </ul>

                <p><label for="FilesPerPage-url">Files per page</label>
                <select name="FilesPerPage" class="" id="FilesPerPage">
                    <option value="3">3</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select> </p>
            </div>            

            <div class="buttonBox clearfix">	
                <a href="" class="back btn">Back</a>
                <a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" class="create btn">Insert</a>
            </div>            
        </div>
        
        </div><!--EOF:Scroller-->
    </div>
    
    </div>
</body>
</html>