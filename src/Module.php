<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\ModuleInterface;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Stdlib\ArrayUtils;

/**
 * Class Module
 * @package MSBios\Theme
 */
class Module implements ModuleInterface, AutoloaderProviderInterface
{
    /** @const VERSION */
    const VERSION = '1.0.16';

    /**
     * @inheritdoc
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return ArrayUtils::merge(
            include __DIR__ . '/../config/module.config.php',
            [
                'service_manager' => (new ConfigProvider)->getDependencyConfig()
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            AutoloaderFactory::STANDARD_AUTOLOADER => [
                StandardAutoloader::LOAD_NS => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }
}
