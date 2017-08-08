<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme\Listener;

use MSBios\Assetic\Resolver\CollectionResolver;
use MSBios\Assetic\Resolver\MapResolver;
use MSBios\Assetic\Resolver\PathStackResolver;
use MSBios\Theme\Theme;
use MSBios\Theme\ThemeManager;
use Zend\Config\Config;
use Zend\EventManager\EventInterface;
use Zend\I18n\Exception\InvalidArgumentException;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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
        if (!$theme = $serviceManager->get(ThemeManager::class)->current()) {
            return;
        }

        /**
         * And we put our theme paths on top of the stack.
         * This way if there is template in our theme it will be taken and used
         * Otherwise we will use the ones provided earlier from the application
         */
        if ($templatePathStack = $theme->getTemplatePathStack()) {
            $serviceManager->get('ViewTemplatePathStack')
                ->addPaths($templatePathStack);
        }

        /**
         * We override the template resolver
         * Here we add the changes that need to be applied to the existing
         * template map
         */
        if ($templateMap = $theme->getTemplateMap()) {
            $serviceManager->get('ViewTemplateMapResolver')
                ->merge($templateMap);
        }

        /** @var array $templateTranslations */
        if ($templateTranslations = $theme->getTranslationFilePatterns()) {
            $this->injectTranslationFilePatterns($templateTranslations, $serviceManager);
        }

        /** @var array $asseticConfiguration */
        if ($asseticConfiguration = $theme->getAsseticManager()) {
            $this->injectAssetics($asseticConfiguration, $serviceManager);
        }

        /** @var array $widgetConfiguration */
        if ($widgetConfiguration = $theme->getWidgetManager()) {
            $this->injectWidgetManaget($widgetConfiguration, $serviceManager);
        }
    }

    /**
     * @param $templateTranslations
     * @param ServiceLocatorInterface $serviceManager
     */
    protected function injectTranslationFilePatterns($templateTranslations, ServiceLocatorInterface $serviceManager)
    {
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
     * @param $asseticConfiguration
     * @param ServiceLocatorInterface $serviceManager
     */
    protected function injectAssetics($asseticConfiguration, ServiceLocatorInterface $serviceManager)
    {

        if ($collections = $asseticConfiguration->get('collections')) {
            $serviceManager->get(CollectionResolver::class)
                ->addCollections($collections);
        }

        if ($paths = $asseticConfiguration->get('paths')) {
            $serviceManager->get(PathStackResolver::class)
                ->addPaths($paths);
        }

        if ($maps = $asseticConfiguration->get('maps')) {
            $serviceManager->get(MapResolver::class)
                ->addMaps($maps);
        }

    }

    /**
     * @param $widgetManagerConfiguration
     * @param ServiceLocatorInterface $serviceManager
     */
    protected function injectWidgetManaget($widgetManagerConfiguration, ServiceLocatorInterface $serviceManager)
    {
        /**
         * And we put our theme paths on top of the stack.
         * This way if there is template in our theme it will be taken and used
         * Otherwise we will use the ones provided earlier from the application
         */
        if ($templatePathStack = $widgetManagerConfiguration->getTemplatePathStack()) {
            $serviceManager->get('WidgetTemplatePathStack')
                ->addPaths($templatePathStack);
        }

        /**
         * We override the template resolver
         * Here we add the changes that need to be applied to the existing
         * template map
         */
        if ($templateMap = $widgetManagerConfiguration->getTemplateMap()) {
            $serviceManager->get('WidgetTemplateMapResolver')
                ->merge($templateMap);
        }
    }
}
