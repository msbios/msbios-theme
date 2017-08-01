<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

use MSBios\Theme\Config\Config;

/**
 * Class ConfigResolver
 * @package MSBios\Theme\Resolver
 */
class ConfigResolver implements ConfigAwareInterface, ResolverInterface
{
    /** @var Config */
    protected $config;

    /**
     * @param Config $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIdentifier()
    {
        return $this->config->getDefaultThemeIdentifier();
    }
}
