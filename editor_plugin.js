function purchase() {
    return '<div class="reciply-addtobasket-widget" href="URL of your website"><img src="http://localhost/wordpress/wp-content/uploads/2011/01/widget-add.png" width="220" height="40"></div>';
}

(function() {

    tinymce.create('tinymce.plugins.purchase', {

        init : function(ed, url){
            ed.addButton('purchase', {
                title : 'Insert Purchase Button',
                onclick : function() {
                    ed.execCommand(
                        'mceInsertContent',
                        false,
                        purchase()
                        );
                },
                image: url + "/purchase.png"
            });
        },

        getInfo : function() {
            return {
                longname : 'Purchase Ingredient plugin',
                author : 'Karim Ntic',
                authorurl : '',
                infourl : '',
                version : "1.0"
            };
        }
    });

    tinymce.PluginManager.add('purchase', tinymce.plugins.purchase);
    
})();
