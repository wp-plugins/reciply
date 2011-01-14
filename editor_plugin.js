function reciply() {
	if ((image_option == "undefined") || (image_option == "") || (image_option == "false")) {
						image_option="http://www.recip.ly/static/images/widget-add.png";
						if (color_option=="orange") image_option="http://www.recip.ly/static/images/widget-add-orange.png";
						if (color_option=="red") image_option="http://www.recip.ly/static/images/widget-add.png";				
						}
    return '<script src="http://www.recip.ly/static/js/jquery-reciply.js" type="text/javascript"></script><div class="reciply-addtobasket-widget"><img src='+image_option+'"></div>';
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
                version : "1.0.8"
            };
        }
    });

    tinymce.PluginManager.add('reciply', tinymce.plugins.reciply);
    
})();