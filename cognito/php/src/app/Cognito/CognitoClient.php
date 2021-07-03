<?php

namespace App\Cognito;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Illuminate\Support\Facades\Log;

class CognitoClient
{
    protected $client;
    protected $clientId;
    protected $poolId;

    public function __construct(CognitoIdentityProviderClient $client, $clientId, $poolId)
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->poolId = $poolId;
    }

    public function register($email, $password, $phoneNumber,  array $attributes = [])
    {
        $attributes['email'] = $email;
        $attributes['phone_number'] = $phoneNumber;

        
        try {
            $response = $this->client->signUp([
                'ClientId' => $this->clientId,
                'Password' => $password,
                'UserAttributes' => $this->formatAttributes($attributes),
                'Username' => $email,
            ]);

        } catch (CognitoIdentityProviderException $e) {
            throw $e;
        }

        $data = [
            'email' => $email,
            'phone_number' => $response['CodeDeliveryDetails']['Destination'],
            'phone_number' => $phoneNumber,
        ];

        return $data;

    }

    public function confirm($request)
    {
        try {
            $response = $this->client->ConfirmSignUp([
                'ClientId' => $this->clientId,
                'ConfirmationCode' => $request->confirm,
                'Username' => $request->email,
            ]);

        } catch (CognitoIdentityProviderException $e) {
            throw $e;
        }

        return ;
    }

    public function authenticate($request)
    {
        
        try {
            $response = $this->client->adminInitiateAuth([
                'AuthFlow'       => 'ADMIN_USER_PASSWORD_AUTH',
                'AuthParameters' => [
                    'USERNAME'   => $request->email,
                    'PASSWORD'   => $request->password,
                ],
                'ClientId'       => $this->clientId,
                'UserPoolId'     => $this->poolId
            ]);

        } catch (CognitoIdentityProviderException $e) {
            throw $e;
        }

        return $response;
    }

    public function logout($request)
    {
        
        try {
            $response = $this->client->globalSignOut([
                'AccessToken' => $request->accessToken, 
            ]);

        } catch (CognitoIdentityProviderException $e) {
            throw $e;
        }

        return $response;
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