<?php

namespace App\Helpers;

// use Lcobucci\JWT\Configuration;
// use Lcobucci\JWT\Signer\Ecdsa\Sha256;
// use Lcobucci\JWT\Signer\Key\InMemory;
// use Lcobucci\JWT\Signer\Ecdsa\MultibyteStringConverter;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Ecdsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Ecdsa;

class AppleSignInHelper
{

    // public function boot()
    // {
    //     config([
    //         'services.apple.client_secret' => $this->generateAppleClientSecret(),
    //     ]);
    // }
        
    // public static function generateAppleClientSecret()
    // {
    //     // Fetching environment variables
    //     $teamId = env('APPLE_TEAM_ID');
    //     $clientId = env('APPLE_CLIENT_ID');
    //     $keyId = env('APPLE_KEY_ID');
    //     $privateKey = InMemory::plainText(env('APPLE_PRIVATE_KEY'));

    //     // Create configuration for ES256 (ECDSA with SHA256)
    //     $config = Configuration::forSymmetricSigner(
    //         Ecdsa::create(Sha256::create()),
    //         $privateKey
    //     );

    //     // Get the current time
    //     $now = new \DateTimeImmutable();

    //     // Build the token
    //     $token = $config->builder()
    //         ->issuedBy($teamId) // "iss" claim
    //         ->issuedAt($now)    // "iat" claim
    //         ->expiresAt($now->modify('+6 months')) // "exp" claim
    //         ->permittedFor('https://appleid.apple.com') // "aud" claim
    //         ->relatedTo($clientId) // "sub" claim
    //         ->withHeader('kid', $keyId) // Add the Key ID header
    //         ->getToken($config->signer(), $config->signingKey()); // Generate the token

    //     // Return the token as a string
    //     return $token->toString();
    // }
}
