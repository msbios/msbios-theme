<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme\Listener;

use MSBios\Theme\Theme;
use MSBios\Theme\ThemeManager;
use Zend\Config\Config;
use Zend\EventManager\EventInterface;
use Zend\I18n\Exception\InvalidArgumentException;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Resolver\AggregateResolver;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\View\Resolver\TemplatePathStack;

/**
 * Class ThemeListener
 * @package MSBios\Theme\Listener
 */
class ThemeListener
{
    /**
     * @param EventInterface $event
     */
    public function onRender(EventInterface $event)
    {
        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $event->getTarget()
            ->getServiceManager();

        /** @var Theme $theme */
        if (! $theme = $serviceManager->get(ThemeManager::class)->current()) {
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
            $this->injectWidgetManaget(new Config($widgetManager), $serviceManager);
        }

        ///**
        // * We override the template resolver
        // * Here we add the changes that need to be applied to the existing
        // * template map
        // */
        //if ($templateMap = $theme->getTemplateMap()) {
        //    $serviceManager->get('ViewTemplateMapResolver')
        //        ->merge($templateMap);
        //}
        //
        ///**
        // * And we put our theme paths on top of the stack.
        // * This way if there is template in our theme it will be taken and used
        // * Otherwise we will use the ones provided earlier from the application
        // */
        //if ($templatePathStack = $theme->getTemplatePathStack()) {
        //    $serviceManager->get('ViewTemplatePathStack')
        //        ->addPaths($templatePathStack);
        //}
        //
        ///** @var array $templateTranslations */
        //if ($templateTranslations = $theme->getTranslationFilePatterns()) {
        //    $this->injectTranslationFilePatterns(
        //        $templateTranslations,
        //        $serviceManager
        //    );
        //}
        //
        //if ($widgetManager = $theme->getWidgetManager()) {
        //    $this->injectWidgetManaget(new Config($widgetManager), $serviceManager);
        //}

        $viewResolver->attach($themeResolver, 100);
    }

    /**
     * @param $templateTranslations
     * @param ServiceLocatorInterface $serviceManager
     */
    protected function injectTranslationFilePatterns(
        $templateTranslations,
        ServiceLocatorInterface $serviceManager
    ) {

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
     * @param Config $widgetManager
     * @param ServiceLocatorInterface $serviceManager
     */
    protected function injectWidgetManaget(Config $widgetManager, ServiceLocatorInterface $serviceManager)
    {
        /** @var Config $templatePathStack */
        if ($templatePathStack = $widgetManager->get('template_path_stack')) {
            $serviceManager->get('WidgetTemplatePathStack')
                ->addPaths($templatePathStack->toArray());
        }

        /** @var Config $templateMap */
        if ($templateMap = $widgetManager->get('template_map')) {
            $serviceManager->get('WidgetTemplateMapResolver')
                ->merge($templateMap->toArray());
        }
    }
}
