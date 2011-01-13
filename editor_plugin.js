function reciply() {
	//alert(image_option);
	//alert(color_option);
	//alert(url_option);
	url_option="'"+url_option+"'";
	if ((image_option == "undefined") || (image_option == "")) {
						if (color_option=="orange") image_option="http://www.recip.ly/static/images/widget-add-orange.png";
						if (color_option=="red") image_option="http://www.recip.ly/static/images/widget-add.png";
						}		
    return '<script src="http://www.recip.ly/static/js/jquery-reciply.js" type="text/javascript"></script><div class="reciply-addtobasket-widget" onclick="location.href='+url_option+'";" style="cursor:pointer;"><img src='+image_option+'"></div>';
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
                image: url + "/reciply.png"
            });			
        },

        getInfo : function() {
            return {
                longname : 'Reciply plugin',
                author : 'Karim Ntic',
                authorurl : '',
                infourl : '',
                version : "1.0"
            };
        }
    });

    tinymce.PluginManager.add('reciply', tinymce.plugins.reciply);
    
})();
