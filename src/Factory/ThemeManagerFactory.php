<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Listener\ListenerOptions;
use MSBios\Theme\Module;
use MSBios\Theme\ResolverManager;
use MSBios\Theme\ThemeManager;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ThemeManagerFactory
 * @package MSBios\Theme\Factory
 */
class ThemeManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ThemeManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        /** @var array $config */
        $config = $container->get(Module::class);

        /** @var EventManagerInterface $eventManager */
        $eventManager = $container->get('EventManager');
        // $configuration    = $container->get('ApplicationConfig');
        // $listenerOptions  = new ListenerOptions($configuration['module_listener_options']);
        // $defaultListeners = new DefaultListenerAggregate($listenerOptions);
        // $serviceListener  = $container->get('ServiceListener');

        return new ThemeManager(
            $config['themes'],
            $eventManager,
            $container->get(ResolverManager::class),
            $container->get(Module::class)
        );
    }
}
