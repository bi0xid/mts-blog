<?php 
    // We get the variables
    extract($_POST);

    // Connect to the database and initializate variables
    $stop = 'false';
    $servername = "10.30.200.51";
    $username = "mytiuser";
    $password = "Q2w3e4r5t";
    $db = "featurex_wp770";

    // Databse connection
    $conn = mysql_connect( $servername, $username, $password );
    mysql_select_db( $db,$conn );
 
    // Look in the database if the email already exists
    $query = "SELECT ID FROM wppv_leads WHERE user_email = '$email' AND form_id = '$form_id'";
    //var_dump($query);
    $existing_email = mysql_query($query, $conn);
    // If exists, $stop is true    
    while( $row = mysql_fetch_array( $existing_email ) ){
        $stop = 'true';
        //var_dump($row);
    }

    // If $stop is true, we go back and show a message
    if ( $stop == 'true' ) {

         header( "Location: http://mytinysecrets.com/energy-orgasm-course/?existing_email=true" );

    // If the email is not in the database
    } else {

        // we add the email to the database
        $query = "INSERT INTO `wppv_leads` (`form_id`, `user_email`) VALUES ('$form_id', '$email')";
        $insert = mysql_query($query, $conn);

        // we capitalize the name
        $name = ucfirst($name);

        // we get all vars        
        $vars = array(
            'api_key'  => $api_key,
            'name'     => $name,
            'email'    => $email,
            'tags'     => $tags,
            'form_id'  => $form,
            'thankyou' => $thankyou
        );

        // and we send the form to ConvertKit
        $url = 'https://api.convertkit.com/v3/forms/47351/subscribe';
        $vars = json_encode($vars);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
          array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
        $json_response = curl_exec($curl);
        curl_close($curl);

        // we go to the than-you page to finish the process
        header( "Location: $thankyou" );

    }
