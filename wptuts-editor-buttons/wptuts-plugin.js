(function() {
    tinymce.create('tinymce.plugins.bootstrap', {
        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            /*ed.addButton('dropcap', {
                title : 'DropCap',
                cmd : 'dropcap',
                image : url + '/dropcap.jpg'
            });
 
            ed.addButton('showrecent', {
                title : 'Add recent posts shortcode',
                cmd : 'showrecent',
                image : url + '/recent.jpg'
            });*/
            
            /*ed.addButton('alert_2',{
                title : 'Alert',
                cmd : 'alert_2',
                icon: 'icon dashicons-info',
            });*/

            /*ed.addCommand('dropcap', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '<span class="dropcap">' + selected_text + '</span>';
                ed.execCommand('mceInsertContent', 0, return_text);
            });
 
            ed.addCommand('showrecent', function() {
                var number = prompt("How many posts you want to show ? "),
                    shortcode;
                if (number !== null) {
                    number = parseInt(number);
                    if (number > 0 && number <= 20) {
                        shortcode = '[recent-post number="' + number + '"/]';
                        ed.execCommand('mceInsertContent', 0, shortcode);
                    }
                    else {
                        alert("The number value is invalid. It should be from 0 to 20.");
                    }
                }
            });*/
            
            /*ed.addCommand('alert_2',function(){
                ed.windowManager.open( {
                    title: 'Alert properties',
                    body: [{
                        type: 'listbox',
                        name: 'alert_type',
                        label: 'Alert type',
                        values: [
                            {text : 'Success', value : 'alert-success'},  
                            {text : 'Info', value : 'alert-info'},  
                            {text : 'Warning', value : 'alert-warning'},  
                            {text : 'Danger', value : 'alert-danger'},  
                        ] 
                    },
                    {
                        type: 'checkbox',
                        name: 'alert_dismissible',
                        label: 'Dismissible',
                    }
                    ],
                    onsubmit: function( e ) {
                        var selected_text = ed.selection.getContent();
                        var return_text = '';
                        var close_button = '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                        return_text = '<div class="alert ' + e.data.alert_type + ' ' + (e.data.alert_dismissible ? 'alert-dismissible' : '') + '" role="alert">'  + (e.data.alert_dismissible ? close_button : '') + selected_text + '</div>';
                        ed.execCommand('mceInsertContent',0, return_text);
                    }
                });
                
                
            });*/
            
            // alert : begin
            var alert_types = ['success','info','warning','danger'];
            
            ed.addButton("alert", {
                title: 'Alert',
                tooltip: "Make selected paragraph as alert",
                icon: 'glyphicon glyphicon-heart',
                onclick: function() {
                    var self = this;
                    if(!self.active()) {
                        ed.windowManager.open( {
                            title: 'Alert properties',
                            body: [{
                                type: 'listbox',
                                name: 'alert_type',
                                label: 'Alert type',
                                values: [
                                    {text : 'Success', value : 'alert-success'},  
                                    {text : 'Info', value : 'alert-info'},  
                                    {text : 'Warning', value : 'alert-warning'},  
                                    {text : 'Danger', value : 'alert-danger'},  
                                ] 
                            }],
                            onsubmit: function( e ) {
                                ed.formatter.toggle(e.data.alert_type);
                                
                                ed.formatter.formatChanged(e.data.alert_type, function(state) {
                                    self.active(state);
                                });
                            }
                        });
                    } else {
                        for(var i=0;i<alert_types.length;i++)
                            ed.formatter.remove('alert-'+alert_types[i]);
                    }                  
                },
                onpostrender: function() {
                    var self = this;

                    if(ed.formatter) {
                        editorFormatterSetup(self);
                    } else {
                        ed.on('init', function() {
                            editorFormatterSetup(self);
                        });
                    }
                }
            });
            // alert : end
            
            
            // button : begin
            var btn_types = ['default','primary','success','info','warning','danger'];

            ed.addButton("button", {
                title: 'Button',
                tooltip: "Make selection as button",
                icon: 'glyphicon glyphicon-heart',
                onclick: function() {
                    var self = this;
                    if(!self.active()) {
                        ed.windowManager.open( {
                            title: 'Button properties',
                            body: [{
                                type: 'listbox',
                                name: 'button_type',
                                label: 'Button type',
                                values: [
                                    {text : 'Default', value : 'btn-default'},  
                                    {text : 'Primary', value : 'btn-primary'},  
                                    {text : 'Success', value : 'btn-success'},  
                                    {text : 'Info', value : 'btn-info'},  
                                    {text : 'Warning', value : 'btn-warning'},  
                                    {text : 'Danger', value : 'btn-danger'},  
                                ] 
                            }],
                            onsubmit: function( e ) {
                                ed.formatter.toggle(e.data.alert_type);
                                
                                ed.formatter.formatChanged(e.data.alert_type, function(state) {
                                    self.active(state);
                                });
                            }
                        });
                    } else {
                        for(var i=0;i<btn_types.length;i++)
                            ed.formatter.remove('btn-'+btn_types[i]);
                    }                  
                },
                onpostrender: function() {
                    var self = this;

                    if(ed.formatter) {
                        editorFormatterSetup(self);
                    } else {
                        ed.on('init', function() {
                            editorFormatterSetup(self);
                        });
                    }
                }
            });
            // button : end
            
            var editorFormatterSetup = function(self) {

                for(var i=0;i<alert_types.length;i++)
                    ed.formatter.register('alert-'+alert_types[i], {
                        block: 'div',
                        classes: 'alert alert-'+alert_types[i]
                    });
                
                ed.formatter.register('alert', {
                    block: 'div',
                    classes: 'alert'
                });                

                ed.formatter.formatChanged('alert', function(state) {
                    self.active(state);
                },true);                
                
                for(var i=0;i<btn_types.length;i++)
                    ed.formatter.register('btn-'+alert_types[i], {
                        block: 'button',
                        classes: 'btn btn-'+alert_types[i]
                    });
                
                ed.formatter.register('btn', {
                    block: 'a',
                    classes: 'btn',
                    role: 'button'
                });                

                ed.formatter.formatChanged('btn', function(state) {
                    self.active(state);
                },true);                
                
            };
            
        },
 
        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Bootstrap Buttons',
                author : 'Sergio',
                version : "0.1"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'bootstrap', tinymce.plugins.bootstrap );
})();