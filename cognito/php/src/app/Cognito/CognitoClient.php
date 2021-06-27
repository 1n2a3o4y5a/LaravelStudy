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
            Log::info("e", ['e' => $e]);
            throw $e;
        }

        return;
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