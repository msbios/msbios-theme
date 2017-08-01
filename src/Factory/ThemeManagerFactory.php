<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Module;
use MSBios\Theme\Resolver\ThemeAggregateResolver;
use MSBios\Theme\ThemeManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ThemeManagerFactory
 * @package MSBios\Theme\Factory
 */
class ThemeManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return ThemeManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ThemeManager(
            $container->get(ThemeAggregateResolver::class),
            $container->get(Module::class)
        );
    }
}
