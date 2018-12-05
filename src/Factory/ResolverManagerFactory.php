<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Resolver\ResolverInterface;
use MSBios\Resolver\ResolverManagerInterface;
use MSBios\Theme\Exception\RuntimeException;
use MSBios\Theme\Module;
use MSBios\Theme\Resolver\OptionsAwareInterface;
use MSBios\Theme\Resolver\MvcEventAwareInterface;
use MSBios\Theme\ResolverManager;
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
     * @return ResolverManagerInterface|ResolverManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var array $options */
        $options = $container->get(Module::class);

        /** @var ResolverManagerInterface $resolverManager */
        $resolverManager = new ResolverManager;

        /**
         * @var string $resolverName
         * @var int $priority
         */
        foreach ($options['resolvers_configuration_themes'] as $resolverName => $priority) {

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

            $resolverManager->attach($resolver, $priority);
        }

        return $resolverManager;
    }
}
