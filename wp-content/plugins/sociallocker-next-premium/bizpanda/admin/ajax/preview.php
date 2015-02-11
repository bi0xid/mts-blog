<?php
add_action("wp_ajax_onp_sl_preview", 'onp_lock_preview');
function onp_lock_preview() {
?>
<!DOCTYPE html>
<html>
    <head>
         <meta charset="UTF-8" />
         <style>
             body {
                 padding: 0px;
                 margin: 0px;
                 font: normal normal 400 14px/170% Arial;
                 color: #333333;
                 text-align: justify;
             }
             * {
                 padding: 0px;
                 margin: 0px;
             }
             #wrap {
                 padding: 20px;
                 overflow: hidden;
             }
             p {
                 margin: 0px;
             }
             p + p {
                 margin-top: 8px;
             }
             .content-to-lock a {
                 color: #3185AB;
             }
             .content-to-lock {
                 text-shadow: 1px 1px 1px #fff;
                 padding: 20px 40px;
             }
             .content-to-lock .header { 
                 margin-bottom: 20px;
             }
             .content-to-lock .header strong { 
                 font-size: 16px;
                 text-transform: capitalize;
             }
             .content-to-lock .image {
                 text-align: center;
                 background-color: #f9f9f9;
                 border-bottom: 3px solid #f1f1f1;
                 margin: auto;
                 padding: 30px 20px 20px 20px;
             }
             .content-to-lock .image img {
                 display: block;
                 margin: auto;
                 margin-bottom: 15px;
                 max-width: 460px;
                 max-height: 276px;
                 height: 100%;
                 width: 100%;
             }
             .content-to-lock .footer { 
                 margin-top: 20px;
             }
         </style>
         <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-includes/js/jquery/jquery.js"></script>
         
         <?php if ( file_exists( includes_url() . 'js/jquery/ui/jquery.ui.core.min.js' )) { ?>
         <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-includes/js/jquery/ui/jquery.ui.core.min.js"></script>     
         <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-includes/js/jquery/ui/jquery.ui.effect.min.js"></script>
         <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-includes/js/jquery/ui/jquery.ui.effect-highlight.min.js"></script>
         <?php } else { ?>
         <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-includes/js/jquery/ui/core.min.js"></script>     
         <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-includes/js/jquery/ui/effect.min.js"></script>
         <script type="text/javascript" src="<?php echo get_site_url() ?>/wp-includes/js/jquery/ui/effect-highlight.min.js"></script>
         <?php } ?>

         <script type="text/javascript" src="<?php echo OPANDA_BIZPANDA_URL ?>/assets/admin/js/libs/json2.js"></script>    
         
         <?php ?>
         <script type="text/javascript" src="<?php echo OPANDA_BIZPANDA_URL ?>/assets/js/lockers.010002.min.js"></script>  
         <link rel="stylesheet" type="text/css" href="<?php echo OPANDA_BIZPANDA_URL ?>/assets/css/lockers.010000.min.css">  
         <?php 
 ?>
         
         <?php do_action('onp_sl_preview_head') ?>  
    </head>
    <body class="onp-sl-demo">
        <div id="wrap" style="text-align: center; margin: 0 auto; max-width: 800px;">
            <div class="content-to-lock" style="text-align: center; margin: 0 auto; max-width: 700px;">

                <div class="header">
                    <p><strong>Lorem ipsum dolor sit amet, consectetur adipiscing</strong></p>
                    <p>
                        Maecenas sed consectetur tortor. Morbi non vestibulum eros, at posuere nisi praesent consequat.
                    </p>
                </div>
                <div class="image">
                    <img src="<?php echo OPANDA_BIZPANDA_URL ?>/assets/admin/img/preview-image.jpg" alt="Preview image" />
                    <i>Aenean vel sodales sem. Morbi et felis eget felis vulputate placerat.</i>
                </div>
                <div class="footer">
                    <p>Curabitur a rutrum enim, sit amet ultrices quam. 
                    Morbi dui leo, euismod a diam vitae, hendrerit ultricies arcu. 
                    Suspendisse tempor ultrices urna ut auctor.</p>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
    </body>
    
    <?php do_action('opanda_preview_print_scripts', !empty( $_GET ) ? $_GET : null); ?>  
    
    <script>     
        (function($){  
           var callback = '<?php echo ( isset( $_POST['callback'] ) ? $_POST['callback'] : '' ) ?>';
           var $originalContent = $("#wrap").clone();
     
           window.setOptions = function( options ) {
               $("#wrap").remove();
               $("body").prepend( $originalContent.clone() );

               options.demo = true;

               var locker = $(".content-to-lock").pandalocker(options);   
               
               locker.bind('opanda-unlock', function(){
                    window.alertFrameSize();   
               });
               
               locker.bind('opanda-size-changed', function(){
                    window.alertFrameSize();   
               });
               
               window.alertFrameSize();
               
               setTimeout(function(){
                   window.alertFrameSize();
               }, 300);
           };

           window.alertFrameSize = function() {
               if ( !parent || !callback ) return;
               var height = jQuery("#wrap").height(); height += 50;
               if (parent[callback]) parent[callback]( height );
           };

           window.dencodeOptions  = function( options ) {
               for( var optionName in options ) {
                   if ( typeof options[optionName] === 'object' ) {
                       options[optionName] = dencodeOptions( options[optionName] );
                   } else {
                       if ( options[optionName] ) {
                           options[optionName] = decodeURI( options[optionName] );
                       }
                   }
               }
               return options;
           };

           window.defaultOptions = {
                demo: true,
                text: {},
                
                locker: {},
                overlap: {},
                
                groups: {},
                
                socialButtons: {
                    buttons: {},
                    effects: {}
                },
                
                connectButtons: {
                    facebook: {},
                    twitter: {},
                    google: {},
                    linkedin: {}
                },
                
                subscrioption: {},

                events: {
                    ready: function() { alertFrameSize(); },             
                    unlock: function() { alertFrameSize(); },
                    unlockByTimer: function() { alertFrameSize(); },
                    unlockByClose: function() { alertFrameSize(); }            
                }
           };
                      
           $(document).trigger('onp-sl-filter-preview-options-php');           

           $(function(){
              setTimeout(function(){ alertFrameSize(true); }, 2000); 
           });
           
           var postOptions = dencodeOptions( JSON.parse('<?php echo $_POST['options'] ?>') );
           var options = $.extend(window.defaultOptions, postOptions);

           $(function(){
               var locker = $(".content-to-lock").pandalocker(options);
               
               locker.bind('opanda-unlock', function(){
                    window.alertFrameSize();   
               });
               
               locker.bind('opanda-size-changed', function(){
                    window.alertFrameSize();   
               });
           });

           jQuery(document).click(function(){
               if( parent && window.removeProfilerSelector ) window.removeProfilerSelector();
           });
        })(jQuery);
    </script>
</html>

<?php
exit;
}
 