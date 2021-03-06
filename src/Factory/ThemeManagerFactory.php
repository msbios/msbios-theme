<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Module;
use MSBios\Theme\ResolverManager;
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
     * @param string $requestedName
     * @param array|null $options
     * @return ThemeManager|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var array $defaultOptions */
        $defaultOptions = $container->get(Module::class);

        return new ThemeManager(
            $container->get(ResolverManager::class),
            $defaultOptions
        );
    }
}
