<?php

function get_ip() {
    if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
            $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function redirect($http_referer = '')
{
    if($http_referer)
    {
        header("Location: {$http_referer}");
    }
    else
    {
        header('Location: http://mytinysecrets.com/');
    }
    exit();
}

$http_referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$http_referer = filter_var($http_referer, FILTER_VALIDATE_URL) ? $http_referer : '';

if (isset($_POST['email']) && $_POST['email']) {

    $email = (isset($_POST['email']) && $_POST['email']) ? $_POST['email'] : '';

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        redirect($http_referer);
    }

    $api_key = '359af3ce40340178eabcb8ff22f29e53';
    $name = (isset($_POST['name']) && $_POST['name']) ? $_POST['name'] : '';
    $origin = 'www';
    $optin = 'single';
    $ip = get_ip();
    $sign_up_new_date = date('Y-m-d H:i:s',  time());
    $form_type = (isset($_POST['form_type']) && $_POST['form_type']) ? $_POST['form_type'] : '';

    $data = file_get_contents('http://www.telize.com/geoip/' . $ip);
    $user_info = json_decode($data);

    $latitude = isset($user_info->latitude) ? $user_info->latitude : '';
    $longitude = isset($user_info->longitude) ? $user_info->longitude : '';
    $country = isset($user_info->country) ? $user_info->country : '';
    $region = isset($user_info->region) ? $user_info->region : '';
    $city = isset($user_info->city) ? $user_info->city : '';
    $country_code = isset($user_info->country_code) ? $user_info->country_code : '';
    $postal_code = isset($user_info->postal_code) ? $user_info->postal_code : '';
    $dma_code = isset($user_info->dma_code) ? $user_info->dma_code : '';
    $continent_code = isset($user_info->continent_code) ? $user_info->continent_code : '';
    $time_zone = isset($user_info->timezone) ? $user_info->timezone : '';

    $fields = array(
            'name' => urlencode($name),
            'email' => urlencode($email),
            'origin' => urlencode($origin),
            'optin' => urlencode($optin),
            'ip' => urlencode($ip),
            'http_referer' => urlencode($http_referer),
            'sign_up_new_date' => urlencode($sign_up_new_date),
            'latitude' => urlencode($latitude),
            'longitude' => urlencode($longitude),
            'country' => urlencode($country),
            'region' => urlencode($region),
            'city' => urlencode($city),
            'country_code' => urlencode($country_code),
            'postal_code' => urlencode($postal_code),
            'dma_code' => urlencode($dma_code),
            'continent_code' => urlencode($continent_code),
            'time_zone' => urlencode($time_zone),
            'form_type' => urlencode($form_type),
            'api_key' => urlencode($api_key),
    );

    foreach($fields as $key=>$value) {
        $fields_string .= $key.'='.$value.'&';
    }

    rtrim($fields_string, '&');

    $ch = curl_init();

    $url = 'http://newsletter.mytinysecrets.com/subscriber/subscribe';

    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

    $result = curl_exec($ch);

    curl_close($ch);

    if($result = 'OK' || $result = 'user already subscribed') {
            header('Location: http://mytinysecrets.com/thank-you');
            exit();
    } else {
        redirect($http_referer);
    }
}

redirect($http_referer);
die();
?>
