function reciply() {		
	var reciplyURL = "http://www.recip.ly";	
	if(choix_option=="custom") {
		if ((image_option == "undefined") || (image_option == "") || (image_option == "false")) 
		{ 
		color_option = "red";
		image_option=reciplyURL +"/static/images/widget-add-"+color_option+".png";
		}
	}
	if(choix_option=="reciply") {
						if((color_option=="") || (color_option==null)) color_option = "red";
						image_option=reciplyURL +"/static/images/widget-add-"+color_option+".png";
						}
    return '<script src='+reciplyURL +'/static/js/jquery-reciply.js" type="text/javascript"></script><div class="reciply-addtobasket-widget"><img src='+image_option+'"></div>';
}

(function() {
    tinymce.create('tinymce.plugins.reciply', {

        init : function(ed, url){
            ed.addButton('reciply', {
                title : 'Insert Reciply Button',
                onclick : function() {
                    ed.execCommand(
                        'mceInsertContent',
                        false,
                        reciply()
                        );
                },
                image: url + "/images/reciply.png"
            });			
        },

        getInfo : function() {
            return {
                longname : 'Reciply plugin',
                author : 'The Recip.ly Integration team',
                authorurl : 'http://integration.recip.ly',
                infourl : '',
                version : "1.1.3"
            };
        }
    });

    tinymce.PluginManager.add('reciply', tinymce.plugins.reciply);
    
})();