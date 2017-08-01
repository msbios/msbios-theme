<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\Theme\Config\Config;
use MSBios\Theme\Resolver\AggregateResolverInterface;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\InitializableInterface;

/**
 * Class ThemeManager
 * @package MSBios\Theme
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
        /** @var Config $themes */
        $themes = $this->options->getThemes()->toArray();

        /** @var Config $theme */
        foreach ($themes as $theme) {
            $this->themes[$theme['identifier']] = $theme;
        }

        /** @var array $tmp */
        $tmp = [];

        /** @var string $path */
        foreach ($this->options->getGlobalPaths() as $path) {
            if (!is_dir($path)) {
                continue;
            }

            /** @var \DirectoryIterator $item */
            foreach (new \DirectoryIterator($path) as $item) {
                if (!$item->isDot() && $item->isDir()) {

                    /** @var string $path */
                    foreach ($this->options->getGlobalPaths() as $path) {

                        /** @var string $filename */
                        $filename = implode(DIRECTORY_SEPARATOR, [
                            $path, $item->getFilename(), $this->options->get('default_config_filename')
                        ]);

                        if (file_exists($filename)) {

                            /** @var array $config */
                            $config = require_once $filename;
                            $tmp[$config['identifier']] = $config;
                        }
                    }
                }
            }
        }

        $this->themes = new \Zend\Config\Config(ArrayUtils::merge($this->themes, $tmp));
    }

    /**
     * @return Theme
     */
    public function current()
    {
        /** @var string $identifier */
        $identifier = $this->resolver->getIdentifier();
        return new Theme($this->themes->get($identifier));
    }

    ///** @var ResolverInterface */
    //protected $themeResolver;
    //
    ///** @var Config */
    //protected $config;
    //
    ///**
    // * @var array An array of Theme classes of loaded themes
    // */
    //protected $loadedThemes = [];
    //
    ///**
    // * ThemeManager constructor.
    // * @param Config $config
    // */
    //public function __construct(AggregateThemeResolver $themeResolver, Config $config)
    //{
    //    $this->themeResolver = $themeResolver;
    //    $this->config = $config;
    //    $this->loadThemes();
    //}
    //
    ///**
    // * @return mixed
    // */
    //public function loadThemes()
    //{
    //    /** @var array $themes */
    //    $themes = $this->config->getThemes()->toArray();
    //
    //    /** @var string $path */
    //    foreach ($this->config->getGlobalPaths() as $path) {
    //        if (! is_dir($path)) {
    //            continue;
    //        }
    //
    //        /** @var \DirectoryIterator $item */
    //        foreach (new \DirectoryIterator($path) as $item) {
    //            if (! $item->isDot() && $item->isDir()) {
    //
    //                /** @var string $path */
    //                foreach ($this->config->get('default_global_paths') as $path) {
    //
    //                    /** @var string $filename */
    //                    $filename = implode(DIRECTORY_SEPARATOR, [
    //                        $path, $item->getFilename(), $this->config->get('default_config_filename')
    //                    ]);
    //
    //                    if (file_exists($filename)) {
    //
    //                        /** @var array $config */
    //                        $config = require_once $filename;
    //
    //                        foreach ($themes as $key => $theme) {
    //                            if ($theme['identifier'] == $config['identifier']) {
    //                                $themes[$key] = ArrayUtils::merge($themes[$key], $config);
    //                                continue;
    //                            } else {
    //                                $themes[$config['identifier']] = $config;
    //                            }
    //                        }
    //                    }
    //                }
    //            }
    //        }
    //    }
    //
    //    foreach ($themes as $theme) {
    //        $this->loadTheme($theme);
    //    }
    //}
    //
    ///**
    // * @param array $config
    // */
    //public function loadTheme(array $config)
    //{
    //    /** @var Theme $object */
    //    $object = new Theme(new Config($config));
    //    $this->loadedThemes[$object->getIdentifier()] = $object;
    //}
    //
    ///**
    // * @param $themeIdentifier
    // * @return mixed
    // */
    //public function getLoadedThemes($themeIdentifier)
    //{
    //    // TODO: Implement getLoadedThemes() method.
    //}
    //
    ///**
    // * @return mixed
    // */
    //public function getThemes()
    //{
    //    // TODO: Implement getThemes() method.
    //}
    //
    ///**
    // * @param $themes
    // * @return mixed
    // */
    //public function setThemes($themes)
    //{
    //    // TODO: Implement setThemes() method.
    //}
    //
    ///**
    // * @return mixed
    // */
    //public function getGlobalPaths()
    //{
    //    return $this->config->getGlobalPaths();
    //}
    //
    ///**
    // * @return mixed|Theme
    // */
    //public function current()
    //{
    //    /** @var string $identifier */
    //    $identifier = $this->themeResolver->getIdentifier();
    //
    //    /** @var Theme $object */
    //    foreach ($this->loadedThemes as $object) {
    //        if ($object->getIdentifier() == $identifier) {
    //            return $object;
    //        }
    //    }
    //
    //    /** @var string $identifier */
    //    $identifier = $this->config->getDefaultThemeIdentifier();
    //
    //    if (isset($this->loadedThemes[$identifier])) {
    //        return $this->loadedThemes[$identifier];
    //    }
    //
    //    new NotFoundException;
    //}
}
