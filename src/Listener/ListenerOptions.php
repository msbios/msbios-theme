<?php
/**
 * Created by PhpStorm.
 * User: judzhin
 * Date: 11/27/17
 * Time: 6:10 PM
 */

namespace MSBios\Theme\Listener;

use Zend\Stdlib\AbstractOptions;

/**
 * Class ListenerOptions
 * @package MSBios\Theme\Listener
 */
class ListenerOptions extends AbstractOptions
{
    /** @var array */
    protected $defaultGlobalPaths = [];

    /** @var bool */
    protected $configCacheEnabled = false;

    /** @var string */
    protected $configCacheKey;

    /** @var string */
    protected $cahceDir;

    /**
     * @return array
     */
    public function getDefaultGlobalPaths()
    {
        return $this->defaultGlobalPaths;
    }

    /**
     * @param array $defaultGlobalPaths
     */
    public function setDefaultGlobalPaths($defaultGlobalPaths)
    {
        $this->defaultGlobalPaths = $defaultGlobalPaths;
    }

    /**
     * @return bool
     */
    public function isConfigCacheEnabled()
    {
        return $this->configCacheEnabled;
    }

    /**
     * @param bool $configCacheEnabled
     */
    public function setConfigCacheEnabled($configCacheEnabled)
    {
        $this->configCacheEnabled = $configCacheEnabled;
    }

    /**
     * @return string
     */
    public function getConfigCacheKey()
    {
        return $this->configCacheKey;
    }

    /**
     * @param string $configCacheKey
     */
    public function setConfigCacheKey($configCacheKey)
    {
        $this->configCacheKey = $configCacheKey;
    }

    /**
     * @return string
     */
    public function getCahceDir()
    {
        return $this->cahceDir;
    }

    /**
     * @param string $cahceDir
     */
    public function setCahceDir($cahceDir)
    {
        $this->cahceDir = $cahceDir;
    }

    /**
     * Get the path to the config cache
     *
     * Should this be an option, or should the dir option include the
     * filename, or should it simply remain hard-coded? Thoughts?
     *
     * @return string
     */
    public function getConfigCacheFile()
    {
        if ($this->getConfigCacheKey()) {
            return $this->getCacheDir() . '/theme-config-cache.' . $this->getConfigCacheKey().'.php';
        }

        return $this->getCacheDir() . '/theme-config-cache.php';
    }
}
