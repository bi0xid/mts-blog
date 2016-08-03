<?php


//function get_ip() {
//    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
//            $ip = $_SERVER['HTTP_CLIENT_IP'];
//    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
//            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//    } else {
//            $ip = $_SERVER['REMOTE_ADDR'];
//    }
//
//    return $ip;
//}
//
//function redirect($http_referer = '')
//{
//    if($http_referer)
//    {
//        header("Location: {$http_referer}");
//    }
//    else
//    {
//        header('Location: http://mytinysecrets.com/');
//    }
//    exit();
//}
//
//$http_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
//$http_referer = filter_var($http_referer, FILTER_VALIDATE_URL) ? $http_referer : '';

//if (isset($_POST['email']) && $_POST['email']) {
//
//    $email = (isset($_POST['email']) && $_POST['email']) ? $_POST['email'] : '';
//
//    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
//    {
//        redirect($http_referer);
//    }
//
//    $api_key = 'Vl6rr4wdvvE5zlJWkPtKZg';
//    $name = (isset($_POST['name']) && $_POST['name']) ? $_POST['name'] : '';
//    $origin = 'www';
//    $optin = 'single';
//    $ip = get_ip();
//    $sign_up_new_date = date('Y-m-d H:i:s',  time());
//    $form_type = (isset($_POST['form_type']) && $_POST['form_type']) ? $_POST['form_type'] : '';
//
//    $data = file_get_contents('http://www.telize.com/geoip/' . $ip);
//    $user_info = json_decode($data);
//    
//    $latitude = isset($user_info->latitude) ? $user_info->latitude : '';
//    $longitude = isset($user_info->longitude) ? $user_info->longitude : '';
//    $country = isset($user_info->country) ? $user_info->country : '';
//    $region = isset($user_info->region) ? $user_info->region : '';
//    $city = isset($user_info->city) ? $user_info->city : '';
//    $country_code = isset($user_info->country_code) ? $user_info->country_code : '';
//    $postal_code = isset($user_info->postal_code) ? $user_info->postal_code : '';
//    $dma_code = isset($user_info->dma_code) ? $user_info->dma_code : '';
//    $continent_code = isset($user_info->continent_code) ? $user_info->continent_code : '';
//    $time_zone = isset($user_info->timezone) ? $user_info->timezone : '';
//
//    $form  = '47065';
//    $thankyou = 'http://mytinysecrets.com/thank-you/';
//    if ( $name == '' ) $name = 'Beautiful';
//    $name = ucfirst($name);
//
//    $fields = array(
//            'ip' => $ip,
//            'http_referer' => $http_referer,
//            'latitude' => $latitude,
//            'longitude' => $longitude,
//            'country' => $country,
//            'region' => $region,
//            'city' => $city,
//            'country_code' => $country_code,
//            'postal_code' => $postal_code,
//            'dma_code' => $dma_code,
//            'continent_code' => $continent_code,
//            'time_zone' => $time_zone
//    );
//
//    // we get all vars        
//    $vars = array(
//        'api_key'  => $api_key,
//        'name'     => $name,
//        'email'    => $email,
//        'tags'     => $tags,
//        'form_id'  => $form,
//        'thankyou' => $thankyou,
//        'fields'   => $fields
//    );
//
//
//
//
//        // and we send the form to ConvertKit
//        $url = 'https://api.convertkit.com/v3/forms/47065/subscribe';
//        $vars = json_encode($vars);
//        $curl = curl_init($url);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($curl, CURLOPT_HTTPHEADER,
//          array("Content-type: application/json"));
//        curl_setopt($curl, CURLOPT_POST, true);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
//        $json_response = curl_exec($curl);
//        curl_close($curl);
//
//        // we go to the thank-you page to finish the process
//        header( "Location: $thankyou" );
//
//
//}
