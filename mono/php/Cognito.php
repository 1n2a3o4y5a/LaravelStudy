<?php
require './config.php';

class Cognito
{
    public $settings;
    public $signupFlag;

    public function __construct(){
        $this->settings = get_settings();
    }

    public function signUp($form)
    {
        $attributes['email'] = $form['email'];
        $attributes['phone_number'] = $form['phone_number'];

        $headers = array(
            'Content-Type: application/x-amz-json-1.1',
            'X-Amz-Target:AWSCognitoIdentityProviderService.SignUp'
        );

        $postData = array(
            "ClientId"    => $this->settings['app_client_id'],
            'Username' => $form['email'],
            'UserPoolId' => $this->settings['user_pool_id'],
            'Password' => $form['password'],
            'UserAttributes' => $this->formatAttributes($attributes)
        );


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->settings['cognito_domain']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $response =  json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        return $response;
    }

    public function confirm($form)
    {
        $headers = array(
            'Content-Type: application/x-amz-json-1.1',
            'X-Amz-Target:AWSCognitoIdentityProviderService.ConfirmSignUp'
        );

        $postData = array(
            "ClientId"    => $this->settings['app_client_id'],
            'Username' => $form['email'],
            'UserPoolId' => $this->settings['user_pool_id'],
            'ConfirmationCode' => $form['confirmation_code'],
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->settings['cognito_domain']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $response =  json_decode(curl_exec($ch));
        curl_close($ch);

        return $response;
    }

    public function login($form)
    {
        
        $postData = array(
            'AuthFlow'       => 'ADMIN_USER_PASSWORD_AUTH',
            "ClientId"    => $this->settings['app_client_id'],
            'UserPoolId' => $this->settings['user_pool_id'],
            'AuthParameters' => [
                'USERNAME'   => $form['email'],
                'PASSWORD'   => $form['password'],
            ],
        );

        $headers = $this->signature($postData);
        $header = array();
        foreach ($headers as $key => $value) {
            $header[] = $key . ": " . $value;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->settings['cognito_domain']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $response =  json_decode(curl_exec($ch));
        $response_info = curl_getinfo($ch);
        curl_close($ch);

        $response_data = [
            'status_code' => $response_info['http_code'],
            'body' => $response
        ];
        
        return $response_data;
        // return $response;
    }

    protected function formatAttributes(array $attributes)
    {
        $userAttributes = [];
        foreach ($attributes as $key => $value) {
            $userAttributes[] = [
                'Name' => $key,
                'Value' => $value,
            ];
        }
        return $userAttributes;
    }

    public function signature($postData)
    {
        $now = time();
        
        $longDate   = date("Ymd\THis\Z", $now);
        $shortDate  = date("Ymd", $now);
        $credentialScope = $shortDate .'/'. $this->settings['region'] . '/cognito/aws4_request';
        $host = parse_url($this->settings['cognito_domain'], PHP_URL_HOST);
        $path = parse_url($this->settings['cognito_domain'], PHP_URL_PATH);
        $payload = json_encode($postData);
        $method = 'POST';

        $headers = array(
            'Content-Type' => 'application/x-amz-json-1.1',
            'X-Amz-Target' => 'AWSCognitoIdentityProviderService.AdminInitiateAuth',
            'Host' => $host,
            'X-Amz-Date' => $longDate,
        );


        $kSecret = $this->settings['aws_secret_access_key'];
        $kDate = hash_hmac('sha256' ,$shortDate, 'NIFTY4'. $kSecret, true);
        $kRegion = hash_hmac('sha256', $this->settings['region'] ,$kDate, true);
        $kSevice = hash_hmac('sha256', 'cognito' ,$kRegion, true);
        $kSigning = hash_hmac('sha256', 'nifty4_request', $kSevice, true);

        $canonicalRequest = $this->createCanonicalRequest($headers, $payload, $method, $host, $path);
        $signedRequest = hash('sha256', $canonicalRequest);
        $signString = "AWS4-HMAC-SHA256\n{$longDate}\n{$credentialScope}\n" .$signedRequest;
        $signature = hash_hmac('sha256', $signString, $kSigning, true);

        $authorization = "AWS4-HMAC-SHA256 Credential={$this->settings['aws_access_key_id']}/{$credentialScope}, " .
                         "SignedHeaders=" . implode(";", array_keys($headers))  . ", " .
                         "Signature=" . bin2hex($signature);
        
        $headers['Authorization'] = $authorization;

        return $headers; 
    }

    public function createCanonicalRequest( Array $headers, $payload, $method, $host, $path)
    {
        $canonicalRequest      = array();
        $canonicalRequest[]    = $method;
        $canonicalRequest[]    = $path;
        $canonicalRequest[]    = '';
        foreach($headers as $key => $value)
            $canonicalHeaders[ strtolower($key) ] = trim($value);
        uksort($canonicalHeaders, 'strcmp');
        foreach($canonicalHeaders as $key => $value) {
            $canonicalRequest[] = $key . ':' . $value;
        }
        $canonicalRequest[] = '';
        $canonicalRequest[] = implode(';', array_keys($canonicalHeaders));
        $canonicalRequest[] = hash('sha256', $payload);
        $canonicalRequest = implode("\n", $canonicalRequest);

        return $canonicalRequest;
    }
}
?>