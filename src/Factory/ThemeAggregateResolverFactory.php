<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Config\Config;
use MSBios\Theme\Exception\RuntimeException;
use MSBios\Theme\Module;
use MSBios\Theme\Resolver\ThemeAggregateResolver;
use MSBios\Theme\Resolver\ConfigAwareInterface;
use MSBios\Theme\Resolver\MvcEventAwareInterface;
use MSBios\Theme\Resolver\ResolverInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ThemeAggregateResolverFactory
 * @package MSBios\Theme\Factory
 */
class ThemeAggregateResolverFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ThemeAggregateResolver
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Config $config */
        $config = $container->get(Module::class);

        /** @var ThemeAggregateResolver $resolver */
        $resolver = new ThemeAggregateResolver;

        /**
         * @var string $resolverName
         * @var int $priority
         */
        foreach ($config->getResolversConfigurationThemes() as $resolverName => $priority) {

            if ($container->has($resolverName)) {
                /** @var ResolverInterface $resolverService */
                $resolverService = $container->get($resolverName);
            } else {
                /** @var ResolverInterface $resolverService */
                $resolverService = new $resolverName($container);
            }

            if (! $resolverService instanceof ResolverInterface) {
                throw new RuntimeException;
            }

            if ($resolverService instanceof ConfigAwareInterface) {
                $resolverService->setConfig($config);
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
