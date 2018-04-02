<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme;

use Zend\EventManager\Event;

/**
 * Custom event for use with theme manager
 * Composes Module objects
 *
 * @method ThemeManager getTarget()
 */
class ThemeEvent extends Event
{
    /**
     * Module events triggered by eventmanager
     */
    const EVENT_MERGE_CONFIG = 'mergeConfig';
    const EVENT_LOAD_THEMES = 'loadThemes';
    const EVENT_LOAD_THEME_RESOLVE = 'loadTheme.resolve';
    const EVENT_LOAD_THEME = 'loadTheme';
    const EVENT_LOAD_THEMES_POST = 'loadThemes.post';

    /**
     * @var mixed
     */
    protected $theme;

    /**
     * @var string
     */
    protected $themeName;

    /**
     * @var Listener\ConfigMergerInterface
     */
    protected $configListener;

    /**
     * Get the name of a given module
     *
     * @return string
     */
    public function getThemeName()
    {
        return $this->themeName;
    }

    /**
     * Set the name of a given theme
     *
     * @param  string $themeName
     * @throws Exception\InvalidArgumentException
     * @return $this
     */
    public function setThemeName($themeName)
    {
        if (! is_string($themeName)) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects a string as an argument; %s provided',
                    __METHOD__,
                    gettype($themeName)
                )
            );
        }
        // Performance tweak, don't add it as param.
        $this->themeName = $themeName;

        return $this;
    }

    /**
     * Get module object
     *
     * @return null|object
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set module object to compose in this event
     *
     * @param  object $theme
     * @throws Exception\InvalidArgumentException
     * @return $this
     */
    public function setTheme($theme)
    {
        if (! is_object($theme)) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects a module object as an argument; %s provided',
                    __METHOD__,
                    gettype($theme)
                )
            );
        }
        // Performance tweak, don't add it as param.
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get the config listener
     *
     * @return null|Listener\ConfigMergerInterface
     */
    public function getConfigListener()
    {
        return $this->configListener;
    }

    /**
     * Set module object to compose in this event
     *
     * @param  Listener\ConfigMergerInterface $configListener
     * @return ModuleEvent
     */
    public function setConfigListener(Listener\ConfigMergerInterface $configListener)
    {
        $this->setParam('configListener', $configListener);
        $this->configListener = $configListener;

        return $this;
    }
}
