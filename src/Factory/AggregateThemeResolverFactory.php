<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use MSBios\Theme\Config\Config;
use MSBios\Theme\Exception\RuntimeException;
use MSBios\Theme\Resolver\AggregateThemeResolver;
use MSBios\Theme\Resolver\ConfigAwareInterface;
use MSBios\Theme\Resolver\MvcEventAwareInterface;
use MSBios\Theme\Resolver\ResolverInterface;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class AggregateThemeResolverFactory
 * @package MSBios\Theme\Factory
 */
class AggregateThemeResolverFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return AggregateThemeResolver
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \Zend\Config\Config $config */
        $config = $container->get(Config::class);

        /** @var AggregateThemeResolver $resolver */
        $resolver = new AggregateThemeResolver;

        /**
         * @var string $resolverName
         * @var int $priority
         */
        foreach ($config->get('resolvers_configuration_themes') as $resolverName => $priority) {

            /** @var ResolverInterface $resolverService */
            $resolverService = $container->get($resolverName);

            if (! $resolverService instanceof ResolverInterface) {
                throw new RuntimeException;
            }

            if ($resolverService instanceof ConfigAwareInterface) {
                $resolverService->setConfig($config->toArray());
            }

            if ($resolverService instanceof MvcEventAwareInterface) {
                $resolverService->setMvcEvent(
                    $container->get('Application')->getMvcEvent()
                );
            }

            $resolver->attach($resolverService, $priority);
        }

        return $resolver;
    }
}
