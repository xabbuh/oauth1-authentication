<?php

namespace Xabbuh\Http\Authentication;

use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\RequestSigning\RequestSigner;
use Http\Message\Authentication;
use Psr\Http\Message\RequestInterface;

/**
 * Adds a signed Authorization header using the configured OAuth1 request signer and credentials.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class OAuth1 implements Authentication
{
    private $requestSigner;

    public function __construct(RequestSigner $requestSigner, AccessToken $accessToken, TokenSecret $tokenSecret)
    {
        $this->requestSigner = $requestSigner->withAccessToken($accessToken, $tokenSecret);
    }

    public function authenticate(RequestInterface $request)
    {
        return $this->requestSigner->sign($request);
    }
}
