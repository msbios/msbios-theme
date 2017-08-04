<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Factory;

use Interop\Container\ContainerInterface;
use MSBios\Theme\Listener\ThemeListener;
use MSBios\Theme\ThemeManager;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ThemeListenerFactory
 * @package MSBios\Theme\Factory
 */
class ThemeListenerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return ThemeListener
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ThemeListener(
            $container->get(ThemeManager::class),
            $container->get('ViewTemplatePathStack'),
            $container->get('ViewTemplateMapResolver'),
            $container->get(TranslatorInterface::class)
        );
    }
}