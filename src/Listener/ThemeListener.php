<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme\Listener;

use MSBios\Theme\Theme;
use MSBios\Theme\ThemeManager;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\I18n\Exception\InvalidArgumentException;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\View\Resolver\TemplatePathStack;

/**
 * Class ThemeListener
 * @package MSBios\Theme\Listener
 */
class ThemeListener extends AbstractListenerAggregate
{

    /** @var ThemeManager */
    protected $themeManager;

    /** @var ThemeManager */
    protected $templatePathStack;

    /** @var TemplateMapResolver */
    protected $templateMapResolver;

    /** @var TranslatorInterface */
    protected $translator;

    /**
     * ThemeListener constructor.
     * @param ThemeManager $themeManager
     * @param TemplatePathStack $templatePathStack
     * @param TemplateMapResolver $templateMapResolver
     * @param TranslatorInterface $translator
     */
    public function __construct(
        ThemeManager $themeManager,
        TemplatePathStack $templatePathStack,
        TemplateMapResolver $templateMapResolver,
        TranslatorInterface $translator)
    {
        $this->themeManager = $themeManager;
        $this->templatePathStack = $templatePathStack;
        $this->templateMapResolver = $templateMapResolver;
        $this->translator = $translator;
    }

    /**
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        /** @var array $listener */
        $listener = [$this, 'onRender'];
        // $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, $listener, $priority);
        // $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, $listener, $priority);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, $listener, $priority);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, $listener, $priority);
    }

    /**
     * @param EventInterface $event
     */
    public function onRender(EventInterface $event)
    {
        /** @var Theme $theme */
        if (!$theme = $this->themeManager->current()) {
            return;
        }

        /**
         * And we put our theme paths on top of the stack.
         * This way if there is template in our theme it will be taken and used
         * Otherwise we will use the ones provided earlier from the application
         */
        if ($templatePathStack = $theme->getTemplatePathStack()) {
            $this->templatePathStack->addPaths($templatePathStack);
        }

        /**
         * We override the template resolver
         * Here we add the changes that need to be applied to the existing template map
         */
        if ($templateMap = $theme->getTemplateMap()) {
            $this->templateMapResolver->merge($templateMap);
        }

        /** @var array $templateTranslations */
        if ($templateTranslations = $theme->getTranslationFilePatterns()) {

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

                $this->translator->addTranslationFilePattern(
                    $pattern['type'],
                    $pattern['base_dir'],
                    $pattern['pattern'],
                    isset($pattern['text_domain']) ? $pattern['text_domain'] : 'default'
                );
            }
        }
    }
}