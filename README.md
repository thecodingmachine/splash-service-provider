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

This service provider is meant to install the Splash router.
Read the "standalone splash install documentation" for more details.

## Expected values / services

This *service provider* expects the following configuration / services to be available:

| Name                        | Compulsory | Description                            |
|-----------------------------|------------|----------------------------------------|
| `thecodingmachine.splash.root_url` (or `root_url`)       | *no*       | The root URL of the application. For instance: "/foo/bar" |
| `thecodingmachine.splash.controllers`              | *yes*      | An array of controller name (this is the name of the identifier of the controller in the container) |
| `thecodingmachine.splash.mode`              | *no*      | The mode of Splash (whether it allows output or not). Can be `SplashUtils::MODE_STRICT` or `SplashUtils::MODE_WEAK` |


## Provided services

This *service provider* provides the following services:

| Service name                | Description                          |
|-----------------------------|--------------------------------------|
| `TheCodingMachine\Splash\Routers\SplashRouter`              | The Splash PSR-15 Middleware |
| `thecodingmachine.splash.route-providers`              | A list of route providers |
| `TheCodingMachine\Splash\Services\ControllerRegistry`              |  |
| `ControllerAnalyzer`              |  |
| `ParameterFetcherRegistry`              |  |
| `thecodingmachine.splash.parameter-fetchers`              | A list of ParameterFetcher instances |
| `SplashRequestFetcher`              |  |
| `SplashRequestParameterFetcher`              |  |
| `thecodingmachine.splash.mode`              | Defaults to strict mode |


## Extended services

This *service provider* extends those services:

| Name                        | Compulsory | Description                            |
|-----------------------------|------------|----------------------------------------|
| `MiddlewareListServiceProvider::MIDDLEWARES_QUEUE` | *yes*      | The Splash middleware is injected in the middleware list. |


<small>Project template courtesy of <a href="https://github.com/thecodingmachine/service-provider-template">thecodingmachine/service-provider-template</a></small>
