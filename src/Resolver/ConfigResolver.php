<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;
use Zend\Config\Config;

/**
 * Class ConfigResolver
 * @package MSBios\Theme\Resolver
 */
class ConfigResolver implements OptionsAwareInterface, ResolverInterface
{
    /** @var Config */
    protected $options;

    /**
     * @param Config $config
     * @return $this
     */
    public function setOptions(Config $config)
    {
        $this->options = $config;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIdentifier()
    {
        return $this->options->get('default_theme_identifier');
    }
}
