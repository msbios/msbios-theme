<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\ModuleInterface;
use Zend\Config\Config;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\LazyListenerAggregate;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class Module
 * @package MSBios\Theme
 *
 * @TODO: Модуль перезатерает изменения леяута, в контролере нет возможности изменить леяут
 */
class Module implements
    ModuleInterface,
    BootstrapListenerInterface,
    AutoloaderProviderInterface
{
    /** @const VERSIOn */
    const VERSION = '1.0.5';

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @param EventInterface $e
     */
    public function onBootstrap(EventInterface $e)
    {
        /** @var Application $target */
        $target = $e->getTarget();

        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $target->getServiceManager();

        (new LazyListenerAggregate(
            $serviceManager->get(self::class)['listeners'],
            $serviceManager
        ))->attach($target->getEventManager());
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
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
