<?php
/**
 * @access protected
 * @author Jduzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Config\Config;
use MSBios\Theme\Module;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ConfigFactory
 * @package MSBios\Theme\Factory
 */
class ConfigFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Config
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Config($container->get('config')[Module::class]);
    }
}
