<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

/**
 * Class ConfigResolver
 * @package MSBios\Theme\Resolver
 */
class ConfigResolver implements ConfigAwareInterface, ResolverInterface
{
    /** @var null */
    protected $config = null;

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIdentifier()
    {
        return false;
    }
}