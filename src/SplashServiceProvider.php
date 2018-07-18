<?php

namespace TheCodingMachine\Splash\DI;

use Doctrine\Common\Annotations\Reader;
use Psr\Container\ContainerInterface;
use TheCodingMachine\Funky\Annotations\Extension;
use TheCodingMachine\Funky\Annotations\Factory;
use TheCodingMachine\Funky\ServiceProvider;
use TheCodingMachine\Splash\Routers\SplashRouter;
use TheCodingMachine\Splash\Services\ControllerAnalyzer;
use TheCodingMachine\Splash\Services\ControllerRegistry;
use TheCodingMachine\Splash\Services\ParameterFetcher;
use TheCodingMachine\Splash\Services\ParameterFetcherRegistry;
use TheCodingMachine\Splash\Services\SplashRequestFetcher;
use TheCodingMachine\Splash\Services\SplashRequestParameterFetcher;
use TheCodingMachine\Splash\Services\SplashUtils;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use TheCodingMachine\MiddlewareListServiceProvider;
use TheCodingMachine\MiddlewareOrder;
use TheCodingMachine\Splash\Services\UrlProviderInterface;

class SplashServiceProvider extends ServiceProvider
{
    /**
     * @Factory()
     */
    public static function createDefaultRouter(
        ContainerInterface $container,
        ParameterFetcherRegistry $parameterFetcherRegistry,
        LoggerInterface $logger = null,
        CacheItemPoolInterface $cache = null
    ) : SplashRouter {
        $routeProviders = $container->get('thecodingmachine.splash.route-providers');

        $router = new SplashRouter(
            $container,
            $routeProviders,
            $parameterFetcherRegistry,
            $cache,
            $logger,
            SplashUtils::MODE_STRICT,
            true,
            self::getRootUrl($container)
        );

        return $router;
    }

    private static function getRootUrl(ContainerInterface $container): string
    {
        if ($container->has('thecodingmachine.splash.root_url')) {
            return $container->get('thecodingmachine.splash.root_url');
        } elseif ($container->has('root_url')) {
            return $container->get('root_url');
        } else {
            return '/';
        }
    }

    /**
     * @Factory(name="thecodingmachine.splash.route-providers")
     * @return UrlProviderInterface[]
     */
    public static function createRouteProviders(ControllerRegistry $controllerRegistry) : array
    {
        return [
            $controllerRegistry,
        ];
    }

    /**
     * @Factory()
     * @param ContainerInterface $container
     * @param ControllerAnalyzer $controllerAnalyzer
     * @return ControllerRegistry
     */
    public static function createControllerRegistry(
        ContainerInterface $container,
        ControllerAnalyzer $controllerAnalyzer
    ) : ControllerRegistry {
        return new ControllerRegistry(
            $controllerAnalyzer,
            $container->get('thecodingmachine.splash.controllers')
        );
    }

    /**
     * @Factory()
     * @param ContainerInterface $container
     * @return ControllerAnalyzer
     */
    public static function createControllerAnalyzer(
        ContainerInterface $container,
        ParameterFetcherRegistry $parameterFetcherRegistry,
        Reader $reader
    ) : ControllerAnalyzer {
        return new ControllerAnalyzer(
            $container,
            $parameterFetcherRegistry,
            $reader
        );
    }

    /**
     * @Factory()
     * @param ContainerInterface $container
     * @return ParameterFetcherRegistry
     */
    public static function createParameterFetcherRegistry(ContainerInterface $container) : ParameterFetcherRegistry
    {
        return new ParameterFetcherRegistry($container->get('thecodingmachine.splash.parameter-fetchers'));
    }

    /**
     * @Factory(name="thecodingmachine.splash.parameter-fetchers")
     * @return ParameterFetcher[]
     */
    public static function createParameterFetchers(
        SplashRequestFetcher $splashRequestFetcher,
        SplashRequestParameterFetcher $splashRequestParameterFetcher
    ) : array {
        return [
            $splashRequestFetcher,
            $splashRequestParameterFetcher,
        ];
    }

    /**
     * @Factory()
     * @return SplashRequestFetcher
     */
    public static function createSplashRequestFetcher() : SplashRequestFetcher
    {
        return new SplashRequestFetcher();
    }

    /**
     * @Factory()
     * @return SplashRequestParameterFetcher
     */
    public static function createSplashRequestParameterFetcher() : SplashRequestParameterFetcher
    {
        return new SplashRequestParameterFetcher();
    }

    /**
     * @Factory(name="thecodingmachine.splash.mode")
     */
    public static function getMode(): string
    {
        return SplashUtils::MODE_STRICT;
    }

    /**
     * @Factory(name="thecodingmachine.splash.controllers")
     * @return string[]
     */
    public static function getControllers(): array
    {
        return [];
    }

    /**
     * @Extension(name=MiddlewareListServiceProvider::MIDDLEWARES_QUEUE)
     */
    public static function updatePriorityQueue(
        \SplPriorityQueue $priorityQueue,
        SplashRouter $splashRouter
    ) : \SplPriorityQueue {
        $priorityQueue->insert($splashRouter, MiddlewareOrder::ROUTER);
        return $priorityQueue;
    }
}
