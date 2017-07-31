<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Config\Config;
use MSBios\Theme\Module;
use MSBios\Theme\Resolver\AggregateThemeResolver;
use MSBios\Theme\ThemeManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ManagerFactory
 * @package MSBios\Theme\Factory
 */
class ManagerFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ThemeManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ThemeManager(
            $container->get(AggregateThemeResolver::class),
            $container->get(Module::class)
        );
    }
}
