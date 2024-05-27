<?php 

    function base64UrlEncode($text) {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($text)
        );
    }

    function getGoogleAuthToken(string $filePath) {
        $authConfigString = file_get_contents($filePath);
        // Parse service account details
        $authConfig = json_decode($authConfigString);
        // Read private key from service account details
        $secret = openssl_get_privatekey($authConfig->private_key);
        // Create the token header
        $header = json_encode([
          'typ' => 'JWT',
          'alg' => 'RS256'
        ]);
        // Get seconds since 1 January 1970
        $time = time();
    
        // Allow 1 minute time deviation between client en server (not sure if this is necessary)
        $start = $time - 60;
        $end = $start + 3600;
    
        // Create payload
        $payload = json_encode([
            "iss" => $authConfig->client_email,
            "scope" => "https://www.googleapis.com/auth/firebase.messaging",
            "aud" => "https://oauth2.googleapis.com/token",
            "exp" => $end,
            "iat" => $start
        ]);
        // Encode Header
        $base64UrlHeader = base64UrlEncode($header);
        // Encode Payload
        $base64UrlPayload = base64UrlEncode($payload);
        // Create Signature Hash
        $result = openssl_sign($base64UrlHeader . "." . $base64UrlPayload, $signature, $secret, OPENSSL_ALGO_SHA256);
        // Encode Signature to Base64Url String
        $base64UrlSignature = base64UrlEncode($signature);
        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
        //-----Request token, with an http post request------
        $options = array('http' => array(
          'method'  => 'POST',
          'content' => 'grant_type=urn:ietf:params:oauth:grant-type:jwt-bearer&assertion='.$jwt,
          'header'  => "Content-Type: application/x-www-form-urlencoded"
        ));
        $context  = stream_context_create($options);
        $responseText = file_get_contents("https://oauth2.googleapis.com/token", false, $context);
        $accessToken = json_decode($responseText);
        return $accessToken;
      }

?>