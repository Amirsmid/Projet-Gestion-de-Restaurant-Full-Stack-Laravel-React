<?php

return [

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Secret
    |--------------------------------------------------------------------------
    |
    | Don't forget to set this in your .env file, as it will be used to sign
    | your tokens. A helper command is provided for this:
    | `php artisan jwt:secret`
    |
    | Note: This will be used for the lifetime of your token, so
    | make sure you have a strong secret set.
    |
    */

    'secret' => env('JWT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | JWT Authentication Keys
    |--------------------------------------------------------------------------
    |
    | The algorithm you are using, will determine the token's lifetime, and
    | other properties of the JWT. The default is HS256 (HMAC with SHA256).
    |
    | Supported algorithms: HS256, HS384, HS512, RS256, RS384, RS512
    |
    */

    'algorithms' => [
        'HS256' => env('JWT_ALGO', 'HS256'),
        'HS384' => env('JWT_ALGO', 'HS384'),
        'HS512' => env('JWT_ALGO', 'HS512'),
        'RS256' => env('JWT_ALGO', 'RS256'),
        'RS384' => env('JWT_ALGO', 'RS384'),
        'RS512' => env('JWT_ALGO', 'RS512'),
    ],

    /*
    |--------------------------------------------------------------------------
    | JWT time to live
    |--------------------------------------------------------------------------
    |
    | Specify the length of time (in minutes) that the token will be valid for.
    | Defaults to 1 hour (60 minutes).
    |
    | You can also set this to 0, to yield a never expiring token. Some
    | applications may want this behaviour for e.g. a mobile app.
    |
    */

    'ttl' => env('JWT_TTL', 60),

    /*
    |--------------------------------------------------------------------------
    | JWT refresh time to live
    |--------------------------------------------------------------------------
    |
    | Specify the length of time (in minutes) that the token can be refreshed
    | within. I.E. The user can refresh their token within a 2 week window of
    | the original token being created until they must re-authenticate.
    | Defaults to 2 weeks (20160 minutes).
    |
    | You can also set this to null, to yield an infinite refresh time.
    | Some may want this instead of never expiring tokens for e.g. a mobile app.
    |
    */

    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160),

    /*
    |--------------------------------------------------------------------------
    | JWT hashing algorithm
    |--------------------------------------------------------------------------
    |
    | Specify the hashing algorithm that will be used to create the JWT.
    | See the Supported Algorithms section for more details.
    |
    */

    'hash' => env('JWT_HASH', 'HS256'),

    /*
    |--------------------------------------------------------------------------
    | JWT required claims
    |--------------------------------------------------------------------------
    |
    | Specify the required claims that must exist in any token. A TokenInvalid
    | exception will be thrown if any of these claims are not present.
    |
    */

    'required_claims' => [
        'iss',
        'iat',
        'exp',
        'nbf',
        'sub',
        'jti',
    ],

    /*
    |--------------------------------------------------------------------------
    | JWT persistent claims
    |--------------------------------------------------------------------------
    |
    | Specify the claim keys to be persisted when refreshing a token. The
    | claims specified here will be added to the token when it is refreshed.
    | The claims will be persisted in the refresh token and will be available
    | in the refreshed token.
    |
    */

    'persistent_claims' => [
        // 'foo',
        // 'bar',
    ],

    /*
    |--------------------------------------------------------------------------
    | JWT lock subject
    |--------------------------------------------------------------------------
    |
    | This will determine whether a `prv` claim is automatically added to
    | the token. The purpose of this is to ensure that if you have multiple
    | authentication models e.g. `App\User` and `App\OtherPerson`, then we
    | should prevent one authentication request from impersonating another,
    | if this is not set then the `prv` claim will be added to the token.
    |
    */

    'lock_subject' => true,

    /*
    |--------------------------------------------------------------------------
    | JWT leeway
    |--------------------------------------------------------------------------
    |
    | This property gives the jwt timestamp claims some "leeway".
    | Meaning that if you have any unavoidable slight clock skew between
    | applications then the JWT will not be marked as invalid.
    |
    | Specified in seconds.
    |
    | Defaults to 0.
    |
    */

    'leeway' => env('JWT_LEEWAY', 0),

    /*
    |--------------------------------------------------------------------------
    | JWT blacklist enabled
    |--------------------------------------------------------------------------
    |
    | In order to invalidate tokens, you must have the blacklist enabled.
    | If you do not want or need this functionality, then you can
    | set this to false.
    |
    */

    'blacklist_enabled' => env('JWT_BLACKLIST_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | JWT blacklist grace period
    |--------------------------------------------------------------------------
    |
    | When multiple concurrent requests are made with the same JWT,
    | it is possible that some of them fail, due to token regeneration
    | on every request.
    |
    | Set grace period in seconds to prevent this issue.
    |
    */

    'blacklist_grace_period' => env('JWT_BLACKLIST_GRACE_PERIOD', 0),

    /*
    |--------------------------------------------------------------------------
    | JWT show blacklisted exception
    |--------------------------------------------------------------------------
    |
    | When trying to get a blacklisted token, an exception will be thrown.
    | Set this to true to show the blacklisted exception message.
    |
    */

    'show_blacklisted_exception' => env('JWT_SHOW_BLACKLISTED_EXCEPTION', true),

    /*
    |--------------------------------------------------------------------------
    | JWT decrypt cookies
    |--------------------------------------------------------------------------
    |
    | By default, JWT cookies are encrypted. If you want to decrypt them,
    | set this to true.
    |
    */

    'decrypt_cookies' => false,

];
