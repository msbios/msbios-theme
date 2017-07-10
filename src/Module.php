<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\ModuleInterface;
use MSBios\Portal\Router\Http\RouteMatch;
use MSBios\Portal\Router\Http\RouteMatchInterface;
use Zend\EventManager\EventInterface;
use Zend\EventManager\SharedEventManager;
use Zend\I18n\Exception\InvalidArgumentException;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\Mvc\Application;
use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ModelInterface;

/**
 * Class Module
 * @package MSBios\Theme
 */
class Module implements ModuleInterface, BootstrapListenerInterface, AutoloaderProviderInterface
{
    const VERSION = '0.0.1';

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
        /** @var ApplicationInterface $application */
        $application = $e->getApplication();

        /** @var SharedEventManager $sharedManager */
        $sharedManager = $application->getEventManager()->getSharedManager();

        $sharedManager->attach(Application::class, MvcEvent::EVENT_RENDER_ERROR, [$this, 'prepareTheme'], -100500);
        $sharedManager->attach(Application::class, MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'prepareTheme'], -100500);
        $sharedManager->attach(Application::class, MvcEvent::EVENT_DISPATCH, [$this, 'prepareTheme'], -100500);

        $sharedManager->attach(Application::class, MvcEvent::EVENT_RENDER_ERROR, [$this, 'injectLayout'], 100500);
        $sharedManager->attach(Application::class, MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'injectLayout'], 100500);
        $sharedManager->attach(Application::class, MvcEvent::EVENT_DISPATCH, [$this, 'injectLayout'], 100500);
    }

    /**
     * @param MvcEvent $e
     */
    public function prepareTheme(MvcEvent $e)
    {
        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $e->getApplication()->getServiceManager();

        /** @var Manager $themeManager */
        $themeManager = $serviceManager->get(Manager::class);

        /** @var Theme $themeObject */
        if ($themeObject = $themeManager->current()) {

            /**
             * And we put our theme paths on top of the stack.
             * This way if there is template in our theme it will be taken and used
             * Otherwise we will use the ones provided earlier from the application
             */
            if ($templatePathStack = $themeObject->getTemplatePathStack()) {
                $stack = $serviceManager->get('ViewTemplatePathStack');
                $stack->addPaths($templatePathStack);
            }

            /**
             * We override the template resolver
             * Here we add the changes that need to be applied to the existing template map
             */
            if ($templateMap = $themeObject->getTemplateMap()) {
                $map = $serviceManager->get('ViewTemplateMapResolver');
                $map->merge($templateMap);
            }

            /** @var array $templateTranslations */
            if ($templateTranslations = $themeObject->getTranslationFilePatterns()) {

                /** @var null $translator */
                $translator = null;

                /** @var array $pattern */
                foreach ($templateTranslations as $pattern) {

                    if (is_null($translator)) {
                        /** @var Translator $translator */
                        $translator = $serviceManager->get(TranslatorInterface::class);
                    }

                    /** @var array $requiredKeys */
                    $requiredKeys = ['type', 'base_dir', 'pattern'];
                    foreach ($requiredKeys as $key) {
                        if (!isset($pattern[$key])) {
                            throw new InvalidArgumentException(
                                "'{$key}' is missing for translation pattern options"
                            );
                        }
                    }

                    $translator->addTranslationFilePattern(
                        $pattern['type'],
                        $pattern['base_dir'],
                        $pattern['pattern'],
                        isset($pattern['text_domain']) ? $pattern['text_domain'] : 'default'
                    );
                }
            }
        }
    }

    /**
     * @param MvcEvent $e
     */
    public function injectLayout(MvcEvent $e)
    {

        /** @var RouteMatch $routeMatch */
        $routeMatch = $e->getRouteMatch();

        if (!$routeMatch instanceof RouteMatchInterface) {
            return;
        }

        /** @var string $identifier */
        if ($identifier = $routeMatch->getLayoutIdentifier()) {

            /** @var ModelInterface $viewModel */
            $viewModel = $e->getViewModel();
            if (!$viewModel instanceof ModelInterface) {
                return;
            }

            $viewModel->setTemplate("layout/{$identifier}");
        }

        // we want theme pathstack registered before
        // $this->addPathStack($e);

        // $identifier = $this->manager->getCurrentLayoutName();
        // if ($identifier) {
        //     $viewModel = $e->getViewModel();
        //     $viewModel->setTemplate("layout/{$identifier}");
        // }
    }

    /**
     * @param MvcEvent $e
     */
    public function prepareTranslator(MvcEvent $e)
    {

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