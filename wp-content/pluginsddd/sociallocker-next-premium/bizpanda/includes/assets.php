<?php

class OPanda_AssetsManager {
    
    private static $_requested = false;
    private static $_createrScriptPrinted = false;
    private static $_cssOptionsToPrint = array();
    
    public static function init() {
        self::initBulkLocking();
        self::iniDynamicThemes();
    }
    
    /**
     * Requests connection Opt-In Panda assets on a current page.
     * 
     * @since 1.0.0
     * @return void
     */
    public static function requestAssets( $fromBody = false, $fromHook = false ) {

        if ( self::$_requested ) return;
        self::$_requested = true;

        add_action( 'wp_footer', 'OPanda_AssetsManager::printCreaterScript', 9999 );
        
        if ( $fromBody || $fromHook ) {
            OPanda_AssetsManager::connectAssets(); 
        } else {
            add_action( 'wp_enqueue_scripts', 'OPanda_AssetsManager::connectAssets' );
        }
        
        if ( !$fromBody ) {
            add_action( 'wp_head', 'OPanda_AssetsManager::printSdkScript' );
        } else {
            add_action( 'wp_footer', 'OPanda_AssetsManager::printSdkScript', 1 );  
        }
    }
    
    /**
     * Loades and initiing Facebook SDK.
     * 
     * @since 1.0.0
     * @return void
     */
    public static function printSdkScript() {
        
        $fb_appId = get_option('opanda_facebook_appid');
        $fb_version = get_option('opanda_facebook_version', 'v2.0');
        $fb_lang = get_option('opanda_lang', 'en_US');
        
        $url = ( $fb_version === 'v1.0' ) 
            ? "//connect.facebook.net/" . $fb_lang . "/all.js"
            : "//connect.facebook.net/" . $fb_lang . "/sdk.js?";

        ?>
        <!-- 
            Facebook SDK
        
            Created by the Opt-In Panda plugin (c) OnePress Ltd
            http://optinpanda.org
        -->
        <script>
            window.fbAsyncInit = function() {
                window.FB.init({
                    appId: <?php echo $fb_appId ?>,
                    status: true,
                    cookie: true,
                    xfbml: true,
                    version: '<?php echo $fb_version ?>'
                });
                window.FB.init = function(){};
            };
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "<?php echo $url ?>";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <!-- / -->   
        <?php
        
        do_action('onp_sl_print_sdk_scripts');
    }
    
    public static function printCssSelectorOptions() {
        ?>
        <!-- 
            Opt-In Panda CSS Selectors (Bulk Locking)

            Created by the Opt-In Panda plugin (c) OnePress Ltd
            http://optinpanda.org
        -->
        <script>
            if ( !window.bizpanda ) window.bizpanda = {};
            window.bizpanda.bulkCssSelectors = [];
            <?php foreach( self::$_cssOptionsToPrint as $options ) { ?>
            window.bizpanda.bulkCssSelectors.push({
                lockId: '<?php echo $options['locker-options-id'] ?>',
                selector: '<?php echo $options['css-selector'] ?>'
            });
            <?php } ?>
        </script>
        <style>
            <?php foreach( self::$_cssOptionsToPrint as $options ) { ?>
            <?php if ( $options['overlap-mode'] === 'full' ) { ?>
            <?php echo $options['css-selector'] ?> { display: none; }
            <?php } ?>
            <?php } ?>
        </style>
        <!-- / -->
        <?php
        
        self::$_cssOptionsToPrint = array();
    }
    
    /**
     * Prints a script that creates Opt-In Pandas via css selectors
     * 
     * @since 1.0.0
     * @return void
     */
    public static function printCreaterScript() {
        if ( self::$_createrScriptPrinted ) return;
        self::$_createrScriptPrinted = true;
        
        do_action('onp_sl_begin_creater_script');
        ?>
                
        <!-- 
            Creater Script for Opt-In Panda
        
            Created by the Opt-In Panda plugin (c) OnePress Ltd
            http://optinpanda.org
        -->
        <script>
            (function($){ if ( window.bizpanda && window.bizpanda.lockers ) window.bizpanda.lockers(); })(jQuery);
        </script>
        <!-- / -->
        <?php
    
        do_action('onp_sl_end_creater_script');
    }
    
    /**
     * Conencts scripts and styles of Opt-In Panda.
     * 
     * @sincee 1.0.0
     * @return void
     */
    public static function connectAssets() {
        
            wp_enqueue_style( 
                'onp-optinpanda', 
                OPANDA_BIZPANDA_URL . '/assets/css/lockers.010003.min.css'
            );  

            wp_enqueue_script( 
                'onp-optinpanda', 
                OPANDA_BIZPANDA_URL . '/assets/js/lockers.010004.min.js', 
                array('jquery', 'jquery-effects-core', 'jquery-effects-highlight'), false, true
            );  
        
        

        
        $facebookSDK = array( 
            'appId' => get_option('opanda_facebook_appid'),
            'lang' => get_option('opanda_lang', 'en_US') 
        ); 

        wp_localize_script( 'onp-optinpanda', 'facebookSDK', $facebookSDK );
        
        do_action('onp_sl_connect_assets');
    }
        
    // -----------------------------------------------
    // Working with locker options.
    // -----------------------------------------------
    
    private static $_lockerOptions = array();
    private static $_lockerOptionsToPrint = array();
    
    /**
     * Prints locker options.
     * 
     * @since 1.0.0
     * @global type $post
     */
    public static function printLockerOptions() {
        
        $data = array();
        
        foreach(self::$_lockerOptionsToPrint as $name => $id) {
            $lockData = self::getLockerDataToPrint( $id );
            
            $data[$id] = array(
                'name' => $name,
                'options' => $lockData
            );
        }

        ?>
        <!-- 
            Options of Bulk Lockers        
            Created by the Opt-In Panda plugin (c) OnePress Ltd
            http://onepress-media.com/plugin/optinpanda-for-wordpress/get
        -->        
            <script>
            if ( !window.bizpanda ) window.bizpanda = {};
            if ( !window.bizpanda.lockerOptions ) window.bizpanda.lockerOptions = {};
            <?php foreach( $data as $item ) { ?>
                window.bizpanda.lockerOptions['<?php echo $item['name'] ?>'] = <?php echo json_encode( $item['options'] ) ?>;
            <?php } ?>
            </script>
            <?php foreach( $data as $id => $item ) { ?>
            <?php do_action( 'opanda_print_batch_locker_assets', $id, $item['options'] ); ?>          
            <?php } ?>
        <!-- / -->
        <?php
        
        self::$_lockerOptionsToPrint = array();
    }
    
    /**
     * Returns base options for all Panda Items.
     * 
     * @since 1.0.0
     */
    public static function getBaseOptions( $id ) {

        $hasScope = get_option('opanda_interrelation', false);

            // PREMIUM build options
            $params = array(
                'demo' => get_option('opanda_debug', false),
                'actualUrls' => get_option('opanda_actual_urls', false),
                
                'text' => array(
                    'header' => self::getLockerOption($id, 'header'), 
                    'message' => self::getLockerOption($id, 'message')           
                ),
                
                'tumbler' => get_option('opanda_tumbler', false),
                'theme' => self::getLockerOption($id, 'style'), 
                
                'overlap' => array(
                    'mode' => self::getLockerOption($id, 'overlap', false, 'full'),
                    'position' => self::getLockerOption($id, 'overlap_position', false, 'middle'),
                    'altMode' => get_option('opanda_alt_overlap_mode', 'transparence')
                ),
                
                'googleAnalytics' => get_option('opanda_google_analytics', 1),

                'effects' => array(
                    'highlight' => self::getLockerOption($id, 'highlight')
                ),
                
                'terms' => opanda_terms_url(),
                'privacyPolicy' => opanda_privacy_policy_url(),
                
                'locker' => array(
                    'close'     => self::getLockerOption($id, 'close'),
                    'timer'     => self::getLockerOption($id, 'timer'),
                    'mobile'    => self::getLockerOption($id, 'mobile'),
                    'scope'     => $hasScope ? 'global' : '',
                    'expires'   => self::getLockerOption($id, 'relock_interval_in_seconds', false, false),
                    'loadingTimeout' => get_option('opanda_timeout', 10000),
                    'tumbler' => get_option('opanda_tumbler', false),
                    'naMode' => get_option('opanda_na_mode', 'show-error')
                )
            );
        


        $params['proxy'] = opanda_proxy_url();
        
        // - Replaces shortcodes in the locker message
        
        global $post;
        
        $postTitle = $post != null ? $post->post_title : '';
        $postUrl = $post != null ? get_permalink($post->ID) : '';

        if ( !empty( $params['text']['message'] ) ) {
            $params['text']['message'] = str_replace('[post_title]', $postTitle, $params['text']['message']);
            $params['text']['message'] = str_replace('[post_url]', $postUrl, $params['text']['message']);  
        }

        return $params;
    }
    
    /**
     * Returns data to print.
     */
    public static function getLockerDataToPrint( $id, $lockData = array() ) {
        global $post;

        $lockData['lockerId'] = $id;

        // options for tracking

        $lockData['tracking'] = get_option('opanda_tracking', true);
        $lockData['postId'] = !empty($post) ? $post->ID : false;
        $lockData['ajaxUrl'] = admin_url( 'admin-ajax.php' );
        
        // the pande item option
        
        $baseOptions = self::getBaseOptions( $id );
        
        $itemType = opanda_get_item_type_by_id( $id );

        $options = apply_filters("opanda_{$itemType}_item_options", $baseOptions, $id );
        $options = apply_filters("opanda_item_options", $options, $id );

        // normilize options
        
        self::_normilizeLockerOptions( $options );
        
        if ( !isset($options['text']['header']) ) $options['text']['header'] = '';
        if ( !isset($options['text']['message']) ) $options['text']['message'] = '';  
        
        $lockData['options'] = $options;
        
        $lockData['_theme'] = self::getLockerOption($id, 'style' );
        $lockData['_style'] = self::getLockerOption($id, 'style_profile' );
          
        return $lockData;
    }
    
    /**
     * Returns locker options.
     * 
     * @since 1.0.0
     * @param integer $lockerId
     * @return mixed
     */
    public static function getLockerOptions( $lockerId ) {

        if ( isset( self::$_lockerOptions[$lockerId] ) ) return self::$_lockerOptions[$lockerId];
        $options = get_post_meta($lockerId, '');
        
        $real = array();
        foreach($options as $key => $values) {
            $real[$key] = $values[0];
        }
        
        self::$_lockerOptions[$lockerId] = $real;
        return $real;
    }
    
    /**
     * Returns a locker option.
     * 
     * @since 1.0.0
     * @param integer $lockerId
     * @param string $name
     * @param boolean $isArray
     * @param mixed $default
     */
    public static function getLockerOption( $lockerId, $name, $isArray = false, $default = null ) {
        $options = self::getLockerOptions($lockerId);
        $value = isset( $options['opanda_' . $name] ) ? $options['opanda_' . $name] : null;

        return ($value === null || $value === '')
            ? $default 
            : ( $isArray ? maybe_unserialize($value) : stripslashes( $value ) ); 
    }
    
    /**
     * Notmilized locker options.
     * 
     * @since 1.0.0
     * @param type $params
     */
    private static function _normilizeLockerOptions( &$params ) {
        
        foreach( $params as $key => &$item ) {

            if ( $item === '' || $item === null || $item === 0 ) {
                unset( $params[$key] );
                continue;
            }

            if ( $item === 'true' ) {
                $params[$key] = true;
                continue;
            }      
            
            if ( $item === '1' ) {
                $params[$key] = 1;
                continue;
            }  

            if ( $item === 'false' ) {
                $params[$key] = false;
                continue;
            }   
            
            if ( $item === '0' ) {
                $params[$key] = 0;
                continue;
            }               

            if ( gettype($item) == 'array' ) {
                self::_normilizeLockerOptions( $params[$key] );
            }
        }
    }
       
    // -----------------------------------------------
    // Bulk Locking
    // -----------------------------------------------
    
    /**
     * Init bulk lockers.
     * 
     * The method gets array of all bulk lockers and tries to understand which of them 
     * are suitable for a current page. If a bulk locker is suitable, then the assets will be 
     * included in the <head> section of a current page. 
     * 
     * @since 3.0.0
     * @return void
     */
    public static function initBulkLocking() {
        
        $bulkLockers = get_option('onp_sl_bulk_lockers', array());
        if ( empty($bulkLockers) ) return;
                
        foreach($bulkLockers as $id => $options) {
            
            $itemType = get_post_meta( $id, 'opanda_item', true );

            if ( 'social-locker' == $itemType && !BizPanda::hasPlugin('sociallocker') ) continue;
            if ( 'email-locker' == $itemType && !BizPanda::hasPlugin('optinpanda') ) continue;
            
            // if we have bulk lockers based on css selectors, then we have to include
            // assets on every page and also print which css selectors we will use for the
            // Opt-In Panda creater script
            
            if ( $options['way'] == 'css-selector' ) {
                
                $lockData = self::getLockerDataToPrint($id);

                self::$_lockerOptionsToPrint['css-selector-' . $id] = $id;
                self::$_cssOptionsToPrint[] = array(
                    'locker-options-id' => 'css-selector-' . $id,
                    'css-selector' => $options['css_selector'],
                    'overlap-mode' => $lockData['options']['overlap']['mode']
                );
                
                self::requestAssets();
                
            // if we have lockers based on the 'skip-lock' and 'more-tag' rules,
            // we need check if a current page is excluded
                
            } else {
                if ( !is_singular( $options['post_types'] ) ) continue;
                if ( !self::isPageExcluded( $id, $options ) ) {
                    self::requestAssets();
                    continue;
                }
            }
        }
        
        if ( !empty( self::$_cssOptionsToPrint ) ) {
            add_action( 'wp_head', 'OPanda_AssetsManager::printCssSelectorOptions' );
            add_action( 'wp_head', 'OPanda_AssetsManager::printLockerOptions' );
        } 
        
        add_filter('the_content', 'OPanda_AssetsManager::addSocialLockerShortcodes', 1);
    }
    
    /**
     * Cache for the method isPageExcluded.
     * 
     * @since 3.0.0
     * @var mixed
     */
    private static $_cache_isPageExcluded = array();
    
    /**
     * Checks if a current page is exluded to show the bulk lockers 
     * based on the 'skip-lock' and 'more-tag' rules
     * 
     * @since 3.0.0
     * @param mixed $options
     * @return boolean
     */
    private static function isPageExcluded( $id, $options ) {
        global $post;
        if (empty($post)) return true;
        
        $key = $id . '' . $post->ID; 
        if ( isset( self::$_cache_isPageExcluded[$key] ) ) return self::$_cache_isPageExcluded[$key];

        if ( !in_array( $post->post_type, $options['post_types'] ) ) { 
            self::$_cache_isPageExcluded[$key] = true;
            return true;
        } 
           
        if ( empty( $options['exclude_posts'] ) && empty( $options['exclude_categories']  ) ) {
            self::$_cache_isPageExcluded[$key] = false;
            return false;
        }    

        if ( in_array( $post->ID, $options['exclude_posts'] ) ) {
            self::$_cache_isPageExcluded[$key] = true;
            return true;
        }

        $isPostCategoryExcluded = false;
        foreach(get_the_category() as $category) {
            if ( in_array( $category->cat_ID, $options['exclude_categories'] ) ) {
                $isPostCategoryExcluded = true;
            }
        }
        
        self::$_cache_isPageExcluded[$key] = $isPostCategoryExcluded;
        return $isPostCategoryExcluded;
    }
     
    /**
     * Adds a locker shortcodes on the flight if bulk locking are turned on.
     * 
     * @param type $content
     * @return type
     */
    public static function addSocialLockerShortcodes( $content ) {
        $bulkLockers = get_option('onp_sl_bulk_lockers', array());
        if ( empty($bulkLockers) ) return $content;

        foreach($bulkLockers as $id => $options) {
            if ( !in_array( $options['way'], array('skip-lock', 'more-tag') ) ) continue;
            if ( self::isPageExcluded( $id, $options ) ) continue;
                        
            $itemType = get_post_meta( $id, 'opanda_item', true );

            if ( 'social-locker' == $itemType && !BizPanda::hasPlugin('sociallocker') ) continue;
            if ( 'email-locker' == $itemType && !BizPanda::hasPlugin('optinpanda') ) continue;
            
            switch ( $itemType ) {
                case 'email-locker':
                    $shortcodeName = 'emaillocker-bulk';
                    break;
                case 'signin-locker':
                    $shortcodeName = 'signinlocker-bulk';
                    break;
                default:
                    $shortcodeName = 'sociallocker-bulk';
                    break;
            }

            if ( $options['way'] == 'skip-lock' ) {
                if ( $options['skip_number'] == 0 ) {;
                    return "[$shortcodeName id='$id']" . $content . "[/$shortcodeName]";
                } else {
                    $counter = 0;
                    $offset = 0;

                    while( preg_match('/[^\s]+((<\/p>)|(\n\r){2,}|(\r\n){2,}|(\n){2,}|(\r){2,})/i', $content, $matches, PREG_OFFSET_CAPTURE, $offset ) ) {
                        $counter++;
                        $offset = $matches[0][1] + strlen( $matches[0][0] );
                      
                        if ( $counter == $options['skip_number'] ) { 
                            $content = substr($content, 0, $offset) . "[$shortcodeName id='$id']" . substr($content, $offset) . "[/$shortcodeName]"; 
                            return $content;                            
                        }
                    }
                }
                
                return $content;
                
            } elseif( $options['way'] == 'more-tag' && is_singular( $options['post_types'] ) ) {
                global $post;
                
                $label = '<span id="more-' . $post->ID . '"></span>';
                $pos = strpos( $content, $label );
                if ( $pos === false ) return $content;
                
                $offset = $pos + strlen( $label );
                if ( substr($content, $offset, 4) == '</p>' ) $offset += 4;
                
                return substr($content, 0, $offset) . "[$shortcodeName id='$id']" . substr($content, $offset) . "[/$shortcodeName]";                 
            }
        }
        
        return $content;
    }
    
    private static function deleteBulkLocker( $id ) {
        $bulkLockers = get_option('onp_sl_bulk_lockers', array());
        if ( isset($bulkLockers[$id]) ) unset( $bulkLockers[$id] );
        delete_option('onp_sl_bulk_lockers');
        add_option('onp_sl_bulk_lockers', $bulkLockers);     
    }
    
    // -----------------------------------------------
    // Dynamic Themes
    // -----------------------------------------------
    
    /**
     * Inits support for dynamic themes.
     * 
     * @since 1.0.0
     * @return void
     */
    public static function iniDynamicThemes() {
        $dynamicTheme = get_option('opanda_dynamic_theme', false);
        if ( !$dynamicTheme ) return;
        
        add_action( 'wp_head', 'OPanda_AssetsManager::printDynamicThemesOptions' );
        self::requestAssets();
    }
    
    /**
     * Prints options required for dynamic themes.
     * 
     * @since 1.0.0
     * @return void
     */
    public static function printDynamicThemesOptions() {
        $isDynamic = get_option('opanda_dynamic_theme', false);
        $event = get_option('opanda_dynamic_theme_event', '');       
        ?>
        <!-- 
            Support for Dynamic Themes
        
            Created by the Opt-In Panda plugin (c) OnePress Ltd
            http://optinpanda.org
        -->
        <script>
        if ( !window.bizpanda ) window.bizpanda = {};
        window.bizpanda.dynamicThemeSupport = '<?php echo $isDynamic ?>';
        window.bizpanda.dynamicThemeEvent = '<?php echo $event ?>';
        </script>     
        <?php do_action('opanda_print_dynamic_theme_options'); ?>  
        <!-- / -->     
        <?php
    }
}

if ( !is_admin() ) add_action('wp', 'OPanda_AssetsManager::init');