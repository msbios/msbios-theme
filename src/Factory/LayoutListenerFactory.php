<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Listener\LayoutListener;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class LayoutListenerFactory
 * @package MSBios\Theme\Factory
 */
class LayoutListenerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return LayoutListener
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new LayoutListener;
    }
}