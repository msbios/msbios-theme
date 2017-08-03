<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\Theme\Exception\InvalidArgumentException;
use MSBios\Theme\Resolver\AggregateResolverInterface;
use Zend\Config\Config;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\InitializableInterface;

/**
 * Class ThemeManager
 * @package MSBios\Theme
 * @link https://github.com/gregorius90/zf2-themes
 */
class ThemeManager implements ThemeManagerInterface, InitializableInterface
{
    /** @var  AggregateResolverInterface */
    protected $resolver;

    /** @var Config */
    protected $options;

    /** @var \Zend\Config\Config */
    protected $themes = [];

    /**
     * ThemeManager constructor.
     * @param AggregateResolverInterface $resolver
     * @param Config $options
     */
    public function __construct(AggregateResolverInterface $resolver, Config $options)
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
        /** @var array $themes */
        $themes = $this->options
            ->get('themes')
            ->toArray();

        /** @var array $optionsFromFile */
        $optionsFromFile = [];

        /** @var string $path */
        foreach ($this->options->get('default_global_paths') as $path) {
            if (!is_dir($path)) {
                continue;
            }

            /** @var \DirectoryIterator $item */
            foreach (new \DirectoryIterator($path) as $item) {
                if (!$item->isDot() && $item->isDir()) {

                    /** @var string $path */
                    foreach ($this->options->get('default_global_paths') as $path) {

                        /** @var string $filename */
                        $filename = implode(DIRECTORY_SEPARATOR, [
                            $path, $item->getFilename(), $this->options->get('default_config_filename')
                        ]);

                        if (file_exists($filename)) {
                            /** @var array $config */
                            $config = require_once $filename;
                            $optionsFromFile[$config['identifier']] = $config;
                        }
                    }
                }
            }
        }

        /** @var Config $themes */
        $themes = new Config(
            ArrayUtils::merge($themes, $optionsFromFile)
        );

        /** @var Config $theme */
        foreach ($themes as $theme) {
            $this->addTheme(new Theme($theme));
        }
    }

    /**
     * @param $identifierOrInstance
     */
    public function hasTheme($identifierOrInstance)
    {
        if (!is_string($identifierOrInstance) && !$identifierOrInstance instanceof Theme) {
            throw new InvalidArgumentException("Illegal argument! \$identifierOrInstance must either be a string or an instance of " . Theme::class);
        }

        /** @var string $identifier */
        $identifier = is_string($identifierOrInstance)
            ? $identifierOrInstance : $identifierOrInstance->getIdentifier();

        return !is_null($this->getTheme($identifier));
    }

    /**
     * @param Theme $theme
     * @return $this
     */
    public function addTheme(Theme $theme)
    {
        if (!$this->hasTheme($theme)) {
            $this->themes[] = $theme;
        }

        return $this;
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

        if (!$theme) {
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
            $this->options->get('default_theme_identifier')
        );
    }
}
