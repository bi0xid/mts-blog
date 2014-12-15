<?php 
/**
 * License page is a place where a user can check updated and manage the license.
 */
class OnpSL_LicenseManagerPage extends OnpLicensing324_LicenseManagerPage  {
 
    public $purchasePrice = '$24';
    
    public function configure() { global $sociallocker;
if ( in_array( $sociallocker->license->type, array( 'free' ) ) ) {

                    $this->menuTitle = __('Social Locker', 'sociallocker');
                


                $this->menuIcon = '~/assets/admin/img/menu-icon.png';
            
}
 global $sociallocker;
if ( !in_array( $sociallocker->license->type, array( 'free' ) ) ) {

                $this->menuPostType = 'social-locker';
            
}

        

    }
}

FactoryPages320::register($sociallocker, 'OnpSL_LicenseManagerPage');
 