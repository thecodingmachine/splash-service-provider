[![Latest Stable Version](https://poser.pugx.org/thecodingmachine/splash-service-provider/v/stable)](https://packagist.org/packages/thecodingmachine/splash-service-provider)
[![Latest Unstable Version](https://poser.pugx.org/thecodingmachine/splash-service-provider/v/unstable)](https://packagist.org/packages/thecodingmachine/splash-service-provider)
[![License](https://poser.pugx.org/thecodingmachine/splash-service-provider/license)](https://packagist.org/packages/thecodingmachine/splash-service-provider)
[![Build Status](https://travis-ci.org/thecodingmachine/splash-service-provider.svg?branch=master)](https://travis-ci.org/thecodingmachine/splash-service-provider)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/splash-service-provider/badge.svg?branch=master&service=github)](https://coveralls.io/github/thecodingmachine/splash-service-provider?branch=master)

# Splash router universal module

This package integrates thecodingmachine/splash-router in any [container-interop](https://github.com/container-interop/service-provider) compatible framework/container.

## Installation

```
composer require thecodingmachine/splash-service-provider
```

Once installed, you need to register the [`TheCodingMachine\Splash\DI\SplashServiceProvider`](src/SplashServiceProvider.php) into your container.

If your container supports [thecodingmachine/discovery](https://github.com/thecodingmachine/discovery) integration, you have nothing to do. Otherwise, refer to your framework or container's documentation to learn how to register *service providers*.

## Introduction

Splash provides a service-provider to be easily integrated in any [container-interop/service-provider](https://github.com/container-interop/service-provider) compatible framework/container.

If you need a complete working sample, check the [Splash standalone installation guide](https://thecodingmachine.github.io/splash-router/doc/install/standalone.html).

This service provider will provide a default Splash router.
 
It requires an instance of Doctrine's annotation reader to be available.

Note: you can get a service provider providing a Doctrine annotation reader using the following packages:
 
```
composer require thecodingmachine/doctrine-annotations-universal-module
```

It will use a PSR-6 cache if the cache is available.
Note: you can get a service provider providing a working PSR-6 cache using the following packages:
 
```
composer require thecodingmachine/stash-universal-module
```

This will install Stash and its related service-provider.

## Expected values / services

This *service provider* expects the following configuration / services to be available:

| Name                        | Compulsory | Description                            |
|-----------------------------|------------|----------------------------------------|
| `thecodingmachine.splash.controllers`              | *yes*      | An array of controller name (this is the name of the identifier of the controller in the container) |
| `thecodingmachine.splash.mode`              | *no*      | The mode of Splash (whether it allows output or not). Can be `SplashUtils::MODE_STRICT` or `SplashUtils::MODE_WEAK` |
| `Doctrine\Common\Annotations\Reader`  | *yes*       | An instance of Doctrine's annotation reader.  |
| `CacheItemPoolInterface::class`  | *no*       | The PSR-6 cache pool used to cache the routes  |
| `LoggerInterface::class`  | *no*       | An optional PSR-3 logger |
| `thecodingmachine.splash.debug`  | *no*       | If true, Splash will display an error with the 'echoed' output in strict mode. Defaults to true. |
| `thecodingmachine.splash.root_url` (or `root_url`)  | *no*       | The base URL of the application. Defaults to '/'. |


## Provided services

This *service provider* provides the following services:

| Service name                | Description                          |
|-----------------------------|--------------------------------------|
| `TheCodingMachine\Splash\Routers\SplashRouter`              | The Splash PSR-15 Middleware |
| `thecodingmachine.splash.route-providers`              | A list of "route providers" for Splash (an array of `UrlProviderInterface`). Each route provider is in charge of feeding routes to Splash. By default, this array contains an instance of the `ControllerRegistry` that scans routes of the controllers. |
| `TheCodingMachine\Splash\Services\ControllerRegistry`              | Instance of `ControllerRegistry`.  |
| `ControllerAnalyzer`              |  |
| `ParameterFetcherRegistry`              | Registry class referencing all parameter fetchers |
| `thecodingmachine.splash.parameter-fetchers`              | A list of ParameterFetcher instances |
| `SplashRequestFetcher`              | An instance of `SplashRequestFetcher` (to autofill the attributes type-hinted on the `ServerRequestInterface`) |
| `SplashRequestParameterFetcher`              | An instance of `SplashRequestParameterFetcher` (to autofill attributes from the request) |
| `thecodingmachine.splash.mode`              | Defaults to strict mode |


## Extended services

This *service provider* registers the `SplashDefaultRouter::class` in the `MiddlewareListServiceProvider::MIDDLEWARES_QUEUE`.

| Service name                | Description                          |
|-----------------------------|--------------------------------------|
| `MiddlewareListServiceProvider::MIDDLEWARES_QUEUE`  | Adds the Splash middleware to this queue (to be used by external routers)  |
