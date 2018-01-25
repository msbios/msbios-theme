<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme;

use MSBios\Theme\Exception\InvalidArgumentException;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\InitializableInterface;

/**
 * Class ThemeManager
 * @package MSBios\Theme
 * @link https://github.com/gregorius90/zf2-themes
 */
class ThemeManager implements ThemeManagerInterface, InitializableInterface
{
    /** @var  ResolverManagerInterface */
    protected $resolver;

    /** @var array */
    protected $options;

    /** @var array */
    protected $themes = [];

    /** @var Theme */
    protected $current;

    /**
     * ThemeManager constructor.
     * @param ResolverManagerInterface $resolver
     * @param array $options
     */
    public function __construct(ResolverManagerInterface $resolver, array $options)
    {
        $this->resolver = $resolver;
        $this->options = $options;
        $this->init();
    }

    /**
     * Init an object
     *
     * @return void
     */
    public function init()
    {
        /** @var array $fromFiles */
        $fromFiles = [];

        /** @var array $globalPaths */
        $globalPaths = $this->options['default_global_paths'];

        /** @var string $path */
        foreach ($globalPaths as $path) {
            if (! is_dir($path)) {
                continue;
            }

            /** @var \DirectoryIterator $item */
            foreach (new \DirectoryIterator($path) as $item) {
                if (! $item->isDot() && $item->isDir()) {

                    /** @var string $path */
                    foreach ($globalPaths as $path) {

                        /** @var string $filename */
                        $filename = implode(DIRECTORY_SEPARATOR, [
                            $path, $item->getFilename(), $this->options['default_config_filename']
                        ]);

                        if (file_exists($filename)) {

                            /** @var array $config */
                            $config = require_once $filename;

                            if (! is_array($config) || ! isset($config['identifier'])) {
                                continue;
                            }

                            $fromFiles[$config['identifier']] = $config;
                        }
                    }
                }
            }
        }

        /** @var array $themes */
        $themes = ArrayUtils::merge(
            $this->options['themes'],
            $fromFiles
        );

        /** @var array $theme */
        foreach ($themes as $theme) {
            $this->addTheme(new Theme($theme));
        }
    }

    /**
     * @param $identifierOrInstance
     */
    public function hasTheme($identifierOrInstance)
    {
        if (! is_string($identifierOrInstance) && ! $identifierOrInstance instanceof Theme) {
            throw new InvalidArgumentException(
                "Illegal argument! \$identifierOrInstance must either be a string or an instance of " . Theme::class
            );
        }

        /** @var string $identifier */
        $identifier = is_string($identifierOrInstance)
            ? $identifierOrInstance : $identifierOrInstance->getIdentifier();

        return ! is_null($this->getTheme($identifier));
    }

    /**
     * @param Theme $theme
     * @return $this
     */
    public function addTheme(Theme $theme)
    {
        if (! $this->hasTheme($theme)) {
            $this->themes[] = $theme;
        }

        return $this;
    }

    /**
     * @param $identityOrInstance
     * @return bool
     */
    public function removeTheme($identityOrInstance)
    {

        if (! $this->hasTheme($identityOrInstance)) {
            return false;
        }

        if (is_string($identityOrInstance)) {
            $identityOrInstance = $this->getTheme($identityOrInstance);
        }

        /** @var int $index */
        $index = array_search($identityOrInstance, $this->themes);
        if ($index !== false) {
            array_splice($this->themes, $index, 1);
            return true;
        }

        return false;
    }

    /**
     * @param $identifier
     * @return Theme|null
     */
    public function getTheme($identifier)
    {
        /** @var Theme $theme */
        foreach ($this->themes as $theme) {
            if ($theme->getIdentifier() == $identifier) {
                return $theme;
            }
        }

        return null;
    }

    /**
     * @return Theme|null
     */
    public function current()
    {
        /** @var string $identifier */
        $identifier = $this->resolver->getIdentifier();

        /** @var Theme $theme */
        $theme = $this->getTheme($identifier);

        if (! $theme) {
            /** @var Theme $theme */
            $theme = $this->getDefaultTheme();
            // TODO: if not find default theme must be throw exception
        }

        return $theme;
    }

    /**
     * @return Theme|null
     */
    public function getDefaultTheme()
    {
        return $this->getTheme(
            $this->options['default_theme_identifier']
        );
    }
}
