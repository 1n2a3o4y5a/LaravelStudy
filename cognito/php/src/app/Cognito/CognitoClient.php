<?php
    namespace App\Cognito;

    use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;

    class CognitoClient
    {
        protected $client;
        protected $clientId;
        protected $clientSecret;
        protected $poolId;

        /**
         * CognitoClient constructor
         */
        public function __construct(
            CognitoIdentityProviderClient $client,
            $clientId,
            $clientSecret,
            $poolId
        ) {
            $this->client       = $client;
            $this->clientId     = $clientId;
            $this->clientSecret = $clientSecret;
            $this->poolId       = $poolId;
        }
    }