<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme\Listener;

use MSBios\Theme\Theme;
use MSBios\Theme\ThemeManager;
use Zend\EventManager\EventInterface;
use Zend\I18n\Exception\InvalidArgumentException;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorInterface;

/**
 * Class ThemeListenerAggregate
 * @package MSBios\Theme\Listener
 */
class ThemeListenerAggregate extends AbstractListenerAggregate
{
    /**
     * @param EventInterface $event
     */
    public function onDispatch(EventInterface $event)
    {
        /** @var ThemeManager $themeManager */
        $themeManager = $this->serviceManager->get(ThemeManager::class);

        /** @var Theme $theme */
        if (! $theme = $themeManager->current()) {
            return;
        }

        /**
         * And we put our theme paths on top of the stack.
         * This way if there is template in our theme it will be taken and used
         * Otherwise we will use the ones provided earlier from the application
         */
        if ($templatePathStack = $theme->getTemplatePathStack()) {
            $stack = $this->serviceManager->get('ViewTemplatePathStack');
            $stack->addPaths($templatePathStack);
        }

        /**
         * We override the template resolver
         * Here we add the changes that need to be applied to the existing template map
         */
        if ($templateMap = $theme->getTemplateMap()) {
            $map = $this->serviceManager->get('ViewTemplateMapResolver');
            $map->merge($templateMap);
        }

        /** @var array $templateTranslations */
        if ($templateTranslations = $theme->getTranslationFilePatterns()) {

            /** @var null $translator */
            $translator = null;

            /** @var array $pattern */
            foreach ($templateTranslations as $pattern) {
                if (is_null($translator)) {
                    /** @var Translator $translator */
                    $translator = $this->serviceManager->get(TranslatorInterface::class);
                }

                /** @var array $requiredKeys */
                $requiredKeys = ['type', 'base_dir', 'pattern'];
                foreach ($requiredKeys as $key) {
                    if (! isset($pattern[$key])) {
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
