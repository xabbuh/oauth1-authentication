<?php

namespace spec\Xabbuh\Http\Authentication;

use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;
use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
use ApiClients\Tools\Psr7\Oauth1\RequestSigning\RequestSigner;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;

class OAuth1Spec extends ObjectBehavior
{
    function let(RequestSigner $requestSigner, RequestSigner $accessTokenRequestSigner)
    {
        $accessToken = new AccessToken('AccessToken');
        $tokenSecret = new TokenSecret('TokenSecret');
        $this->beConstructedWith($requestSigner, $accessToken, $tokenSecret);

        $requestSigner->withAccessToken($accessToken, $tokenSecret)->willReturn($accessTokenRequestSigner);
    }

    function it_is_an_authentication()
    {
        $this->shouldHaveType('Http\Message\Authentication');
    }

    function it_returns_an_authenticated_request_signed_with_the_configured_access_token(RequestSigner $accessTokenRequestSigner, RequestInterface $originalRequest, RequestInterface $signedRequest)
    {
        $accessTokenRequestSigner->sign($originalRequest)->willReturn($signedRequest);

        $this->authenticate($originalRequest)->shouldReturn($signedRequest);
    }
}
