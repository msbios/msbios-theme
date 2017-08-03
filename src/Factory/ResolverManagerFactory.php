<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Exception\RuntimeException;
use MSBios\Theme\Module;
use MSBios\Theme\Resolver\AggregateResolverManager;
use MSBios\Theme\Resolver\OptionsAwareInterface;
use MSBios\Theme\Resolver\MvcEventAwareInterface;
use MSBios\Theme\Resolver\ResolverInterface;
use MSBios\Theme\ResolverManagerInterface;
use Zend\Config\Config;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ResolverManagerFactory
 * @package MSBios\Theme\Factory
 */
class ResolverManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return AggregateResolverManager|ResolverManagerInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var Config $options */
        $options = $container->get(Module::class);

        /** @var ResolverManagerInterface $aggregateResolver */
        $aggregateResolver = new AggregateResolverManager;

        /**
         * @var string $resolverName
         * @var int $priority
         */
        foreach ($options->get('resolvers_configuration_themes') as $resolverName => $priority) {

            /** @var ResolverInterface $resolver */
            $resolver = $container->get($resolverName);

            if (! $resolver instanceof ResolverInterface) {
                throw new RuntimeException;
            }

            if ($resolver instanceof OptionsAwareInterface) {
                $resolver->setOptions($options);
            }

            if ($resolver instanceof MvcEventAwareInterface) {
                $resolver->setMvcEvent(
                    $container->get('Application')->getMvcEvent()
                );
            }

            $aggregateResolver->attach($resolver, $priority);
        }

        return $aggregateResolver;
    }
}
