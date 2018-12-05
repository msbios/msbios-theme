<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\Theme\Exception\InvalidArgumentException;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Resolver\AggregateResolver;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\View\Resolver\TemplatePathStack;

/**
 * Class ListenerAggregate
 * @package MSBios\Theme
 */
class ListenerAggregate extends AbstractListenerAggregate
{
    /** @var ThemeManagerInterface */
    protected $themeManager;

    // /**
    //  * ListenerAggregate constructor.
    //  * @param ThemeManagerInterface $themeManager
    //  */
    // public function __construct(ThemeManagerInterface $themeManager)
    // {
    //     $this->themeManager = $themeManager;
    // }

    /**
     * @inheritdoc
     *
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events
            ->attach(MvcEvent::EVENT_RENDER, [$this, 'onRender'], $priority);
    }

    /**
     * @param EventInterface $event
     */
    public function onRender(EventInterface $event)
    {
        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $event->getTarget()
            ->getServiceManager();

        /** @var Theme $theme */
        if (! $theme = $this->themeManager->current()) {
            return;
        }

        /** @var AggregateResolver $viewResolver */
        $viewResolver = $serviceManager->get('ViewResolver');

        /** @var AggregateResolver $themeResolver */
        $themeResolver = new AggregateResolver;

        /**
         * We override the template resolver
         * Here we add the changes that need to be applied to the existing
         * template map
         */
        if ($templateMap = $theme->getTemplateMap()) {
            $viewMapResolver = $serviceManager->get('ViewTemplateMapResolver');
            $viewMapResolver->add($templateMap);

            $mapResolver = new TemplateMapResolver($templateMap);
            $themeResolver->attach($mapResolver);
        }

        /**
         * And we put our theme paths on top of the stack.
         * This way if there is template in our theme it will be taken and used
         * Otherwise we will use the ones provided earlier from the application
         */
        if ($templatePathStack = $theme->getTemplatePathStack()) {
            $viewResolverPathStack = $serviceManager->get('ViewTemplatePathStack');
            $viewResolverPathStack->addPaths($templatePathStack);
            $pathResolver = new TemplatePathStack(['script_paths' => $templatePathStack]);

            $defaultPathStack = $serviceManager->get('ViewTemplatePathStack');
            $pathResolver->setDefaultSuffix($defaultPathStack->getDefaultSuffix());
            $themeResolver->attach($pathResolver);
        }

        /** @var array $templateTranslations */
        if ($templateTranslations = $theme->getTranslationFilePatterns()) {
            $this->injectTranslationFilePatterns(
                $templateTranslations,
                $serviceManager
            );
        }

        if ($widgetManager = $theme->getWidgetManager()) {
            $this->injectWidgetManaget($widgetManager, $serviceManager);
        }

        $viewResolver->attach($themeResolver, 100);

        /** @var \Zend\View\Renderer\PhpRenderer $phpRenderer */
        $phpRenderer = $serviceManager->get('Zend\View\Renderer\PhpRenderer');
        $phpRenderer->setResolver($viewResolver);

        // TODO: Fix???
        $serviceManager->get('ViewHelperManager')
            ->get('partial')
            ->setView($phpRenderer);
    }

    /**
     * @param $templateTranslations
     * @param ServiceLocatorInterface $serviceManager
     */
    protected function injectTranslationFilePatterns($templateTranslations, ServiceLocatorInterface $serviceManager) {

        /** @var array $pattern */
        foreach ($templateTranslations as $pattern) {

            /** @var array $requiredKeys */
            $requiredKeys = ['type', 'base_dir', 'pattern'];
            foreach ($requiredKeys as $key) {
                if (! isset($pattern[$key])) {
                    throw new InvalidArgumentException(
                        "'{$key}' is missing for translation pattern options"
                    );
                }
            }

            $serviceManager->get(TranslatorInterface::class)->addTranslationFilePattern(
                $pattern['type'],
                $pattern['base_dir'],
                $pattern['pattern'],
                isset($pattern['text_domain']) ? $pattern['text_domain'] : 'default'
            );
        }
    }

    /**
     * @param $widgetManager
     * @param ServiceLocatorInterface $serviceManager
     */
    protected function injectWidgetManaget($widgetManager, ServiceLocatorInterface $serviceManager)
    {
        /** @var array $templatePathStack */
        if ($templatePathStack = $widgetManager['template_path_stack']) {
            $serviceManager->get('WidgetTemplatePathStack')
                ->addPaths($templatePathStack);
        }

        /** @var array $templateMap */
        if ($templateMap = $widgetManager['template_map']) {
            $serviceManager->get('WidgetTemplateMapResolver')
                ->merge($templateMap);
        }
    }
}
