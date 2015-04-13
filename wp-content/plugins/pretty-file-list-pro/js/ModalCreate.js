(function() {  
    tinymce.create('tinymce.plugins.prettylist', {  
        init : function(ed, url) {              
            ed.addButton('prettylist', {  
                title : 'Add a Pretty file list',  
                image : url.replace('/js','')+'/images/filelist.png',  
				cmd : 'prettyfilepro',
				pluginurl: ajaxurl
                
            });  
			
            // Register commands
            ed.addCommand('prettyfilepro', function() {
                    ed.windowManager.open({
                            file : url.replace('/js','')+'/includes/prettylistpro_shortcode_creator.php', // file that contains HTML for our modal window
                            width : 600 + parseInt(ed.getLang('button.delta_width', 0)), // width of modal
                            height : 500 + parseInt(ed.getLang('button.delta_height', 0)), // height of modal
                            inline : 1
                    }, {
                            plugin_url : url
                    });
            });
        }
        
    });  
    tinymce.PluginManager.add('prettylist', tinymce.plugins.prettylist);  
}
)();

jQuery.urlParam = function(url,name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(url);
    if (results == null){return ''}
    return results[1] || 0;
} 