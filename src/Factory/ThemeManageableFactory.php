<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\ThemeManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ThemeManageableFactory
 * @package MSBios\Theme\Factory
 */
class ThemeManageableFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return mixed|object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName($container->get(ThemeManager::class));
    }
}