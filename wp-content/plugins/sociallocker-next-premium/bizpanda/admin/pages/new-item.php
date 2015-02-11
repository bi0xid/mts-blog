<?php
/**
 * Shows the dialog to select a type of new opt-in element.
 * 
 * @author Paul Kashtanoff <paul@byonepress.com>
 * @copyright (c) 2014, OnePress Ltd
 * 
 * @package core 
 * @since 1.0.0
 */

class OPanda_NewPandaItemPage extends OPanda_AdminPage  {
 
    public function __construct( $plugin  ) {    
        
        $this->menuTitle = __('+ New Item', 'optinpanda');
        $this->menuPostType = OPANDA_POST_TYPE;
        $this->id = "new-item";
    
        parent::__construct( $plugin );
    }
        
    public function assets($scripts, $styles) {
        $this->scripts->request('jquery');
        
        $this->styles->request( array( 
            'bootstrap.core'
            ), 'bootstrap' ); 
        
        $this->scripts->add(OPANDA_BIZPANDA_URL . '/assets/admin/js/new-item.010000.js');  
        $this->styles->add(OPANDA_BIZPANDA_URL . '/assets/admin/css/new-item.010000.css');
    }
    
    /**
     * Shows the screen.
     * 
     * @sinve 1.0.0
     * @return void
     */
    public function indexAction() {
        $types = opanda_get_item_types();
        
        // checkes extra items which are not installed yet
        
        $fetchedItems = opanda_fetch_panda_items();
        
        $extraItems = array();
        foreach( $fetchedItems as $item ) {
            if ( BizPanda::hasPlugin( $item['pluginName'] ) ) continue;
            $extraItems[] = $item;
        }

        ?>

        <div class="wrap factory-fontawesome-320">

            <div class="opanda-items ">
                
                <h2><?php _e('Creating New Item', 'optinpanda') ?></h2>
                <p style="margin-top: 0px;"><?php _e('Choose which items you would like to create.', 'optinpanda') ?></p>

                <?php foreach( $types as $name => $type ) { ?>
                <div class="postbox opanda-item">

                    <h4 class="opanda-title">
                        <?php echo $type['title'] ?>
                    </h4>
                    <div class="opanda-description">
                        <?php echo $type['description'] ?>
                    </div>
                    <div class="opanda-buttons">

                        <a href="<?php echo admin_url('post-new.php?post_type=opanda-item&opanda_item=' . $name); ?>" class="button button-large opanda-create">
                            <i class="fa fa-plus"></i><span><?php _e('Create Item', 'optinpanda') ?></span>
                        </a>

                        <?php if ( isset( $type['help'] )) { ?>
                        <a href="<?php echo $type['help'] ?>" class="button button-large opanda-help opanda-right" title="<?php _e('Click here to learn more', 'opanda') ?>">
                            <i class="fa fa-question-circle"></i>
                        </a>
                        <?php } ?>
                    </div>
                </div>

                <?php } ?>
            </div>
            
            <?php if ( !empty( $extraItems ) ) { ?>
            
            <div class="opanda-separator"></div>
            
            <div class="opanda-extra-items">
                <div class="opanda-inner-wrap">
                    
                    <h2>
                        <?php _e('More Marketing Tools To Grow Your Business', 'optinpanda') ?>
                    </h2>
                    <p style="margin-top: 0px;">
                        <?php _e('Check out other plugins which add more features to your lockers.', 'optinpanda') ?>
                    </p>
                    
                    <?php foreach( $extraItems as $item ) { ?>
                    
                        <div class="postbox opanda-item">
                            <i class="fa fa-plus-circle opanda-plus-background"></i>
                            
                            <h4 class="opanda-title">
                                <?php echo $item['title'] ?>
                            </h4>
                            <div class="opanda-description">
                                <?php echo $item['description'] ?>
                            </div>
                            <div class="opanda-buttons">
                                <a href='<?php echo $item['url'] ?>' class="button button-large" title="<?php _e('Click here to learn more', 'opanda') ?>">
                                    <i class="fa fa-external-link"></i><span>Learn More</span>
                                </a>
                            </div>
                        </div>
                    
                    <?php } ?>

                    <img class="opanda-arrow" src='<?php echo OPANDA_BIZPANDA_URL . '/assets/admin/img/new-item-arrow.png' ?>' />
                    
                </div>
            </div>
            
            <?php } ?>
        </div>
        <?php
    }
}

FactoryPages321::register($bizpanda, 'OPanda_NewPandaItemPage');