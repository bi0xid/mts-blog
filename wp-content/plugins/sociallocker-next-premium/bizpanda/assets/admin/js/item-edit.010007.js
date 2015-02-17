if ( !window.bizpanda ) window.bizpanda = {};
if ( !window.bizpanda.lockerEditor ) window.bizpanda.lockerEditor = {};

(function($){
    
    window.bizpanda.lockerEditor = {
        
        init: function() {  
            this.item = $('#opanda_item').val();;
            
            this.basicOptions.init( this.item );
            
            this.socialOptions.init( this.item );
            this.connectOptions.init( this.item );
            this.subscriptionOptions.init( this.item );         

            this.trackInputChanges();
            this.recreatePreview();
        }, 
        
        /**
         * Starts to track user input to refresh the preview.
         */
        trackInputChanges: function() {
            var self = this;
            
            var tabs = [
                "#OPanda_BasicOptionsMetaBox",
                "#OPanda_SocialOptionsMetaBox",
                "#OPanda_AdvancedOptionsMetaBox",
                "#OPanda_ConnectOptionsMetaBox",
                '#OPanda_SubscriptionOptionsMetaBox'
            ];
            
            for(var index in tabs) {
                
                $(tabs[index])
                   .find("input, select, textarea")
                   .bind('change keyup', function(){ self.refreshPreview(); });
            }
        },
        
        /**
         * Binds the change event of the WP editor.
         */
        bindWpEditorChange: function( ed ) {
            var self = this;
            
            var changed = function() {
                tinyMCE.activeEditor.save();
                self.refreshPreview();
            };
            
            if ( tinymce.majorVersion <= 3 ) {
                ed.onChange.add(function(){ changed(); });
            } else {
                ed.on("change", function(){ changed(); });
            }
        },
        
        /**
         * Refreshes the preview after short delay.
         */
        refreshPreview: function( force ) {
            var self = this;
            
            if ( this.timerOn && !force ) {
                this.timerAgain = true;
                return;
            }

            this.timerOn = true;
            setTimeout(function(){

                if (self.timerAgain) {
                    self.timerAgain = false;
                    self.refreshPreview( true );
                } else {
                    self.timerAgain = false;
                    self.timerOn = false;
                    self.recreatePreview();
                }

            }, 500);
        },
        
        /**
         * Recreates the preview, submmits forms to the preview frame.
         */
        recreatePreview: function() {          
            var url = $("#lock-preview-wrap").data('url');            
            var options = this.getPreviewOptions();   

            window.bizpanda.preview.refresh( url, 'preview', options, 'onp_sl_update_preview_height' );
        },
        
        /**
         * Gets options for the preview to submit into the frame.
         */
        getPreviewOptions: function() {
            
            var options = this.getCommonOptions();
            var extra = {};
            
            if ( 'social-locker' === this.item ) {
                extra = this.socialOptions.getSocialOptions();
            } else if ( 'email-locker' === this.item ) {
                extra = this.subscriptionOptions.getEmailOptions();
            } else if ( 'signin-locker' === this.item ) {
                extra = this.connectOptions.getConnectOptions();
            }

            var options = $.extend(true, options, extra);
            if ( window.bizpanda.lockerEditor.filterOptions ) {
                options = window.bizpanda.lockerEditor.filterOptions( options );
            }
            
            $(document).trigger('onp-sl-filter-preview-options', [options]);
            return options;
        },
        
        getCommonOptions: function() {

            var timer = parseInt( $("#opanda_timer").val() );

            var options = {
                
                text: {
                    header: $("#opanda_header").val(),
                    message: $("#opanda_message").val()   
                },
                
                theme: 'secrets',
                
                overlap: {
                    mode: $("#opanda_overlap").val(),
                    position: $("#opanda_overlap_position").val()
                },
                effects: { 
                    highlight: $("#opanda_highlight").is(':checked')
                },
                
                locker: {
                    timer: ( !timer || timer === 0 ) ? null : timer,		
                    close: $("#opanda_close").is(':checked'),
                    mobile: $("#opanda_mobile").is(':checked')
                },
                
                proxy: window.opanda_proxy_url
            };

            if (!options.text.header && options.text.message) {
                options.text = options.text.message;
            }
                options['theme'] = $("#opanda_style").val();
            

            
            if ( window.bizpanda.previewGoogleFonts ) {
                
                var theme = options['theme'];
                options['theme'] = {
                    'name': theme,
                    'fonts': window.bizpanda.previewGoogleFonts
                };
            }
            
            return options;
        },

        // --------------------------------------
        // Basic Metabox
        // -------------------------------------- 
        
        basicOptions: {
            
            init: function(){
                this.initOverlapModeButtons();
            },
            
            initOverlapModeButtons: function() {
                var $overlapControl = $("#OPanda_BasicOptionsMetaBox .factory-control-overlap .factory-buttons-group");
                var $positionControl = $("#OPanda_BasicOptionsMetaBox .factory-control-overlap_position");
                var $position = $("#opanda_overlap_position");            

                $overlapControl.after( $("<div id='opanda_overlap_position_wrap'></div>").append( $position ) );

                var checkPositionControlVisability = function( ){
                    var value = $("#opanda_overlap").val();

                    if ( value === 'full' ) {
                        $("#opanda_overlap_position_wrap").css("display", "none");
                    } else {
                        $("#opanda_overlap_position_wrap").css("display", "inline-block");   
                    }
                };
                checkPositionControlVisability();

                $("#opanda_overlap").change(function(){
                    checkPositionControlVisability();
                });
            }
        },
        
        // --------------------------------------
        // Social Options
        // --------------------------------------

        socialOptions: {
            
            init: function() {
                this.initSocialTabs();
            },

            /**
             * Inits social tabs.
            */
            initSocialTabs: function() {
                var self = this;
                var socialTabWrap = $(".factory-align-vertical .nav-tabs");
                var socialTabItem = $(".factory-align-vertical .nav-tabs li");

                // current order

                var currentString = $("#opanda_buttons_order").val();
                if (currentString) {

                    var currentSet = currentString.split(',');
                    var originalSet = {};

                    socialTabItem.each(function(){
                        var tabId = $(this).data('tab-id');
                        originalSet[tabId] = $(this).detach();
                    });

                    for(var index in currentSet) {
                        var currentId = currentSet[index];
                        socialTabWrap.append(originalSet[currentId]);
                        delete originalSet[currentId];
                    }

                    for(var index in originalSet) {
                        socialTabWrap.append(originalSet[index]);
                    }

                    $(function(){
                        $(socialTabWrap.find("li a").get(0)).tab('show');
                    });
                }

                // make shortable
                $(".factory-align-vertical .nav-tabs").addClass("ui-sortable");
                $(".factory-align-vertical .nav-tabs").sortable({
                    placeholder: "sortable-placeholder",
                    opacity: 0.7,
                    items: "> li",
                    update: function(event, ui) {
                       self.updateButtonOrder();
                    }
                });  

                // 

                socialTabWrap.find('li').each(function(){
                    var tabId = $(this).data('tab-id');
                    var item = $(this);
                    var checkbox = $("#opanda_" + tabId + "_available");              

                    checkbox.change(function(){
                        var isAvailable = checkbox.is(':checked'); 

                        if (!isAvailable) {
                            item.addClass('factory-disabled');
                        } else {
                            item.removeClass('factory-disabled');
                        }

                        self.updateButtonOrder();
                    }).change();
                });
            },
            
            updateButtonOrder: function(value) {

                if (!value) {

                    var socialTabWrap = $(".factory-align-vertical .nav-tabs");

                    var resultArray = [];
                    socialTabWrap.find('li:not(.sortable-placeholder):not(.factory-disabled)').each(function(){
                        resultArray.push( $(this).data('tab-id') );
                    });
                    var result = resultArray.join(',');

                    $("#opanda_buttons_order").val(result).change();
                }
            },
            
            getSocialOptions: function() {
                var buttons = $("#opanda_buttons_order").val();
                
                var options = {
                    
                    groups: {
                        order: ['social-buttons']
                    },
                    
                    socialButtons: {
                        
                        counters: ( $("#opanda_show_counters").length === 1 ) 
                                    ? $("#opanda_show_counters").is(':checked') 
                                    : true,
                                    
                        order: buttons ? buttons.split(",") : buttons,
                        
                        facebook: {
                            appId: $("#lock-preview-wrap").data('facebook-appid'),
                            lang: $("#lock-preview-wrap").data('lang'),
                            version: $("#lock-preview-wrap").data('facebook-version'),   
                            like: {
                                url: $("#opanda_facebook_like_url").val(),
                                title: $("#opanda_facebook_like_title").val()
                            },
                            share: {
                                url: $("#opanda_facebook_share_url").val(),
                                title: $("#opanda_facebook_share_title").val(),
                                name: $("#opanda_facebook_share_message_name").val(),
                                caption: $("#opanda_facebook_share_message_caption").val(),
                                description: $("#opanda_facebook_share_message_description").val(),
                                image: $("#opanda_facebook_share_message_image").val(),
                                counter: $("#opanda_facebook_share_counter_url").val()
                            }
                        }, 
                        twitter: {
                            lang: $("#lock-preview-wrap").data('short-lang'),
                            tweet: { 
                                url: $("#opanda_twitter_tweet_url").val(),
                                text: $("#opanda_twitter_tweet_text").val(),
                                title: $("#opanda_twitter_tweet_title").val(),
                                counturl: $("#opanda_twitter_tweet_counturl").val(),
                                via: $("#opanda_twitter_tweet_via").val()              
                            },
                            follow: {
                                url: $("#opanda_twitter_follow_url").val(),
                                title: $("#opanda_twitter_follow_title").val() 
                            }
                        },          
                        google: {
                            lang: $("#lock-preview-wrap").data('short-lang'),
                            plus: {
                                url: $("#opanda_google_plus_url").val(),
                                title: $("#opanda_google_plus_title").val()
                            },   
                            share: {
                                url: $("#opanda_google_share_url").val(),
                                title: $("#opanda_google_share_title").val()
                            }
                        },          
                        linkedin: {  
                            share: {
                                url: $("#opanda_linkedin_share_url").val(),
                                title: $("#opanda_linkedin_share_title").val()
                            }
                        }
                    }
                };

                return options;
            }
        },

        // --------------------------------------
        // Connect Buttons Metabox
        // --------------------------------------
        
        connectOptions: {
            
            init: function( item ) {
                if ( 'signin-locker' !== item ) return;
                
                var self = this;
                
                this.$control = $(".opanda-connect-buttons");
                this.$buttons = this.$control.find(".opanda-button");
                this.$actions = this.$control.find(".opanda-action");
                
                this.$result = $("#opanda_connect_buttons");

                $(window).resize(function(){ self.adjustHeights(); });
                self.adjustHeights();
                self.hideEmptyDisabledActions();
                
                this.initButtons();
                this.setupEvents();
            },
            
            getConnectOptions: function() {

                var gerOrder = function( fieldId ) {
                    var actions = $(fieldId).val();
                    return actions ? actions.split(",") : []; 
                };

                var order = gerOrder("#opanda_connect_buttons");
                
                var emailIndex = $.inArray( 'email', order );
                if ( emailIndex > -1 ) { order.splice(emailIndex, 1); } 

                var groups = ( emailIndex > -1 )
                    ? ['connect-buttons', 'subscription']
                    : ['connect-buttons'];
                    
                var optinMode = $('#opanda_subscribe_mode').val();
                    
                var options = {
                    
                    groups: {
                        order: groups
                    },
                    
                    terms: window.opanda_terms,
                    privacyPolicy: window.opanda_privacy_policy,
                    
                    connectButtons: {
                        
                        order: order,
                        
                        facebook: {
                            appId: window.opanda_facebook_app_id,
                            actions: gerOrder('#opanda_facebook_actions'),
                        },
                        twitter: {
                            actions: gerOrder('#opanda_twitter_actions'),
                            follow: {
                                user: $("#opanda_twitter_follow_user").val(),
                                notifications: $("#opanda_twitter_follow_notifications").is(':checked') 
                            },
                            tweet: {
                                message: $("#opanda_twitter_tweet_message").val()
                            }
                        },
                        google: {
                            clientId: window.opanda_google_client_id,
                            actions: gerOrder('#opanda_google_actions'),
                            
                            youtubeSubscribe: {
                                channelId: $("#opanda_google_youtube_channel_id").val()
                            }
                        },
                        linkedin: {
                            actions: gerOrder('#opanda_linkedin_actions'),
                            apiKey: window.opanda_linkedin_api_key,
                            
                            follow: {
                                company: $("#opanda_linkedin_follow_company").val()
                            }
                        }
                    },
                    
                    subscription: {
                        
                        text: {
                            message: $("#opanda_subscribe_before_form").val()
                        },
                        
                        form: {
                            buttonText: $("#opanda_subscribe_button_text").val(),
                            noSpamText: $("#opanda_subscribe_after_button").val()
                        }
                    },
                                       
                    subscribeActionOptions: {                        
                        campaignId: $("#opanda_subscribe_list").length ? $("#opanda_subscribe_list").val() : null,
                        service: window.opanda_subscription_service_name,
                        doubleOptin: $.inArray( optinMode, ['quick-double-optin', 'double-optin'] > -1),
                        confirm: $.inArray( optinMode, ['double-optin'] > -1),
                        requireName: $("#opanda_subscribe_name").is(':checked')
                    }
                };
                
                return options;
            },
    
            adjustHeights: function() {
                
                var maxHeight = 0;
                var $buttons = this.$buttons.find(".opanda-actions:not(.opanda-actions-disabled)").each(function(){
                    var height = $(this).css('height', 'auto').height();
                    if ( height > maxHeight ) maxHeight = height;
                });
                
                $buttons.height(maxHeight);
            },
            
            hideEmptyDisabledActions: function() {
            
                $(".opanda-actions-disabled").each(function(){
                    if ( $(this).find(".opanda-action").length > 0 ) return;
                    $(this).hide();
                });
            },
            
            initButtons: function() {
                var self = this;
                
                var stringResult = this.$result.val();
                if (!stringResult) stringResult = null;
                
                var buttons = stringResult.split(',');
                for( var index in buttons ) {
                    var buttonName = buttons[index];
                    this.activateButton( buttonName, true );
                }
                
                this.$buttons.each(function(){
                    self.initButtonActions( $(this).data('name') )
                });
                
                this.initActionSaveEmail();
            },
            
            initActionSaveEmail: function () {

                
                $("input[data-action='lead']").change(function(){
                    $("#opanda_catch_leads").val( $(this).is(":checked") ? "1" : "0" );
                });
                
                if ( $("#opanda_catch_leads").val() == "1" ) {
                    $("input[data-action='lead']").attr('checked', 'checked');
                } else {
                    $("input[data-action='lead']").removeAttr('checked');
                }
            },
            
            initButtonActions: function( buttonName ) {
                
                var stringResult = $("#opanda_" + buttonName + "_actions").val();
                if (!stringResult) stringResult = null;
                
                if ( stringResult ) {
                    var actions = stringResult.split(',');
                    for( var index in actions ) {
                        var actionName = actions[index];
                        this.activateButtonAction( buttonName, actionName, true );
                    }
                }
            },
            
            setupEvents: function() {
                var self = this;
                
                this.$buttons.find(".opanda-button-title input").change(function(){
                    self.toogleButton( $(this).val() );
                });
                
                this.$buttons.find(".opanda-action input").change(function(){

                    var common = $(this).data('common') ? true : false;  
                    var button = $(this).data('button');
                    var action = $(this).data('action');
                    
                    if ( $(this).is(':checked') ) {
                        self.showOptions( common, button, action );
                    }
                    
                    var $input = self.getOptionsLink( common, button, action ).find("input");
                    
                    if ( $(this).is(':checked') ) {
                        $input.attr('checked', 'checked');
                    } else {
                        $input.removeAttr('checked', 'checked');
                    }
                    
                    self.updateResult();
                    return false;
                });    
                
                this.$buttons.find(".opanda-action .opanda-action-link").click(function(){
                    
                    var common = $(this).data('common') ? true : false;  
                    var button = $(this).data('button');
                    var action = $(this).data('action');
  
                    self.toogleOptions( common, button, action );
                    return false;
                });
                
                this.$buttons.find(".opanda-action .opanda-action-link").hover(function(){
                    
                    var common = $(this).data('common') ? true : false;  
                    var button = $(this).data('button');
                    var action = $(this).data('action');
                    
                    var $link = self.getOptionsLink( common, button, action );
                    $link.addClass('opanda-hover');
                    
                }, function(){
                    
                    var common = $(this).data('common') ? true : false;  
                    var button = $(this).data('button');
                    var action = $(this).data('action');
                    
                    var $link = self.getOptionsLink( common, button, action );
                    $link.removeClass('opanda-hover');
                });    
            },
            
            /**
             * Gets the button $object.
             */
            getButton: function( name ) {
                return this.$control.find(".opanda-button-" + name);
            },
            
            /**
             * Activates or deactivates the button.
             */
            toogleButton: function( name ) {
                
                var $button = this.getButton( name );
                if ( $button.hasClass('opanda-on') ) this.deactivateButton( name );
                else this.activateButton( name );
            },
            
            /**
             * Activates the connect button.
             */
            activateButton: function( name, setup ) {
                
                var $button = this.getButton( name );
                $button.removeClass('opanda-off').addClass('opanda-on');
                
                $button.find(".opanda-actions .opanda-action:not(.opanda-action-disabled) input").removeAttr('disabled');
                $button.find(".opanda-button-title input").attr('checked', 'checked');
                
                if ( !setup ) this.updateResult();
            },
            
            /**
             * Deactivates the button.
             */
            deactivateButton: function( name, setup ) {
                
                var $button = this.getButton( name );
                $button.removeClass('opanda-on').addClass('opanda-off');
                
                $button.find(".opanda-actions input").attr('disabled', 'disabled');
                $button.find(".opanda-button-title input").removeAttr('checked');
                
                if ( !setup ) this.updateResult();
            },
            
            /**
             * Activates the button action.
             */
            activateButtonAction: function( buttonName, actionName, setup) {
                
                var $button = this.getButton( buttonName );

                var $action = $button.find('.opanda-action-' + actionName);
                if ( $action.is('.opanda-action-disabled') ) return;
                
                $action.find('input').attr('checked', 'checked');
                
                if ( !setup ) this.updateActionsResult( buttonName, actionName );
            },
            
            /**
             * Deactivates the button action.
             */
            deactivateButtonAction: function( buttonName, actionName, setup) {
                
                var $button = this.getButton( buttonName );
                $button.find('.opanda-action-' + actionName + ' inpput').removeAttr('checked');
                
                if ( !setup ) this.updateActionsResult( buttonName, actionName );
            },
            
            /**
             * Gets the options $object.
             */
            getOptions: function( common, button, action ) {
                
                if ( common ) {
                    return $( "#opanda-" + action + "-options" );
                } else {
                    return $( "#opanda-" + button + "-" + action + "-options" );
                }
            },
            
            /**
             * Gets the options link $object.
             */
            getOptionsLink: function( common, button, action ) {
                
                if ( common ) {
                    return this.$control.find(".opanda-action-" + action);
                } else {
                    return this.$control.find(".opanda-button-" + button + " .opanda-action-" + action);
                }
            },      

            /**
             * Shows or hides the options.
             */
            toogleOptions: function( common, button, action ) {
                
                var $options = this.getOptions( common, button, action );
                if ( !$options.is(":visible") ) this.showOptions( common, button, action );
                else this.hideOptions( common, button, action );
            },
            
            /**
             * Shows the action options.
             */
            showOptions: function( common, button, action ) {
                $(".opanda-connect-buttons-options").addClass('opanda-off');
                this.$actions.removeClass('opanda-on'); 
                
                var $options = this.getOptions( common, button, action );
                $options.hide().removeClass('opanda-off').fadeIn(300);
                
                var $link = this.getOptionsLink( common, button, action );
                $link.addClass('opanda-on');
            },
            
            /**
             * Hides the action options.
             */
            hideOptions: function( common, button, action ) {
                $(".opanda-connect-buttons-options").addClass('opanda-off');
                this.$actions.removeClass('opanda-on'); 
            },
            
            /**
             * Updates the hidden field where the available buttons are saved.
             */
            updateResult: function() {
                var buttons = [];
                
                $(".opanda-connect-buttons .opanda-button.opanda-on").each(function(){
                    buttons.push( $(this).data('name') );
                });
                
                this.$result.val( buttons.join(',') );
                
                for( var i in buttons ) {
                    this.updateActionsResult( buttons[i] );
                }
            },
            
            /**
             * Updates the hidden field where the button actions are saved.
             */
            updateActionsResult: function( buttonName ) {
                var actions = [];
                
                $(".opanda-connect-buttons .opanda-button-" + buttonName + " .opanda-action input:checked").each(function(){
                    actions.push( $(this).data('action') );
                });
                
                $("#opanda_" + buttonName + "_actions").val( actions.join(',') );
            }
        },

        // --------------------------------------
        // Subscription Options Metabox
        // --------------------------------------

        subscriptionOptions: {

            init: function( item ){
                if ( 'email-locker' !== item && 'connect-locker' !== item ) return;
                
                $("#opanda_subscribe_allow_social").change(function(){
                    var value = $(this).is(":checked");
                    if ( value ) $("#social-buttons-options").fadeIn();
                    else $("#social-buttons-options").hide();
                }).change();
            },
            
            getEmailOptions: function() {
                
                var connectButtons = [];
                if ( $("#factory-checklist-opanda_subscribe_social_buttons-facebook").is(":checked") ) connectButtons.push('facebook');
                if ( $("#factory-checklist-opanda_subscribe_social_buttons-google").is(":checked") ) connectButtons.push('google'); 
                if ( $("#factory-checklist-opanda_subscribe_social_buttons-linkedin").is(":checked") ) connectButtons.push('linkedin');  
                
                var groups = ( $("#opanda_subscribe_allow_social").is(":checked") && connectButtons.length )
                    ? ['subscription', 'connect-buttons']
                    : ['subscription'];
                    
                var optinMode = $('#opanda_subscribe_mode').val();

                var options = {
                    
                    groups: {
                        order: groups
                    },
                    
                    terms: window.opanda_terms,
                    privacyPolicy: window.opanda_privacy_policy,
                    
                    connectButtons: {

                        order: connectButtons,
                        
                        text: {
                            message: $("#opanda_subscribe_social_text").val()
                        },

                        facebook: {
                            appId: window.opanda_facebook_app_id,
                            actions: ['subscribe']
                        },
                        google: {
                            clientId: window.opanda_google_client_id,
                            actions: ['subscribe']
                        },
                        linkedin: {
                            actions: ['subscribe'],
                            apiKey: window.opanda_linkedin_api_key
                        }
                    },
                    
                    subscription: {
                        form: {
                            buttonText: $("#opanda_button_text").val(),
                            noSpamText: $("#opanda_after_button").val()
                        }
                    },
                    
                    subscribeActionOptions: {
                        
                        campaignId: $("#opanda_subscribe_list").length ? $("#opanda_subscribe_list").val() : null,
                        service: window.opanda_subscription_service_name,
                        doubleOptin: $.inArray( optinMode, ['quick-double-optin', 'double-optin'] > -1),
                        confirm: $.inArray( optinMode, ['double-optin'] > -1),
                        requireName: $("#opanda_subscribe_name").is(':checked')
                    }
                };
                
                return options;
            }
        }
    };
    
    $(function(){
        window.bizpanda.lockerEditor.init();
    });
    
})(jQuery)

function opanda_editor_callback(e) {
    if ( e.type == 'keyup') {
        tinyMCE.activeEditor.save();
        window.bizpanda.lockerEditor.refreshPreview();
    }
    return true;
}


