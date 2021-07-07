<?php
require './config.php';

class Cognito
{
    protected $settings;
    public $signupFlag;

    public function __construct(){
        $this->settings = get_settings();
        $this->signupFlag = !$_POST? true: false;
    }

    public function signUp($form)
    {
        $attributes['email'] = $form['email'];
        $attributes['phone_number'] = $form['phone_number'];

        $headers = array(
            'Content-Type: application/x-amz-json-1.1',
            'X-Amz-Target:AWSCognitoIdentityProviderService.SignUp'
        );

        $post_data = array(
            "ClientId"    => $this->settings['app_client_id'],
            'Username' => $form['email'],
            'UserPoolId' => $this->settings['user_pool_id'],
            'Password' => $form['password'],
            'RedirectUri' => 'http://localhost:8080/confirm.php',
            'UserAttributes' => $this->formatAttributes($attributes)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->settings['cognito_domain']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        $response =  curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        var_dump($data);
        
        return ;
    }

    public function confirm($form)
    {
        $headers = array(
            'Content-Type: application/x-amz-json-1.1',
            'X-Amz-Target:AWSCognitoIdentityProviderService.ConfirmSignUp'
        );

        $post_data = array(
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        $response =  curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        var_dump($data);
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