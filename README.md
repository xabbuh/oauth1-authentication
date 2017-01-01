OAuth1 Authentication for HTTPlug
=================================

[![Build Status](https://travis-ci.org/xabbuh/oauth1-authentication.svg?branch=master)](https://travis-ci.org/xabbuh/oauth1-authentication)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xabbuh/oauth1-authentication/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xabbuh/oauth1-authentication/?branch=master)

Sign PSR-7 requests using OAuth1 when using them with HTTPlug clients.

Installation
------------

Install the OAuth1 integration using Composer:

```bash
$ composer require xabbuh/oauth1-authentication:^1.0
```

Usage
-----

1. Configure the request signer with your consumer key and secret:

    ```php
    use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerKey;
    use ApiClients\Tools\Psr7\Oauth1\Definition\ConsumerSecret;
    use ApiClients\Tools\Psr7\Oauth1\RequestSigning\RequestSigner;

    $requestSigner = new RequestSigner(
        new ConsumerKey('consumer_key'),
        new ConsumerSecret('consumer_secret')
    );
    ```

    You can also optionally specify the hash algorithm to use. Read more about that in the
    [api-clients/psr7-oauth1 documentation](https://github.com/php-api-clients/psr7-oauth1/blob/master/README.md).

1. Set up the OAuth1 authentication passing the configured request signer together with
   your access token and token secret:

   ```php
   // ...
   use ApiClients\Tools\Psr7\Oauth1\Definition\AccessToken;
   use ApiClients\Tools\Psr7\Oauth1\Definition\TokenSecret;
   use Xabbuh\Http\Authentication\OAuth1;

   // ...

   $oauth = new OAuth1(
       $requestSigner,
       new AccessToken('access_token'),
       new TokenSecret('token_secret')
   );
   ```

1. Use the configured authentication with the [authentication plugin](http://php-http.org/en/latest/plugins/authentication.html):

   ```php
   // ...
   use Http\Discovery\HttpClientDiscovery;
   use Http\Client\Common\PluginClient;
   use Http\Client\Common\Plugin\AuthenticationPlugin;

   // ...

   $authenticationPlugin = new AuthenticationPlugin($oauth);

   $pluginClient = new PluginClient(
       HttpClientDiscovery::find(),
       [$authenticationPlugin]
   );
   ```
