<?php
require './config.php';

class Cognito
{
    protected $settings;

    public function __construct(){
        $this->settings = get_settings();
    }

    public function initialOauth($form)
    {
        $attributes['email'] = $form['email'];
        $attributes['phone_number'] = $form['phone_number'];

        $tokenEndpointPath = '/oauth2/authorize';

        $headers = array(
            'Content-Type: application/x-amz-json-1.1',
            'X-Amz-Target:AWSCognitoIdentityProviderService.SignUp'
        );

        $post_data = array(
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        $html =  curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);

        $contents = json_decode($html, true);
        var_dump($contents);
        var_dump($errno, $error);
        
        return ;
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

}
?>