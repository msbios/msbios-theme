<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

/**
 * Class DefaultThemeIdentifierResolver
 * @package MSBios\Theme\Resolver
 */
class DefaultThemeIdentifierResolver implements OptionsAwareInterface, ResolverInterface
{
    /** @var array */
    protected $options;

    /**
     * @param array $config
     * @return $this
     */
    public function setOptions(array $config)
    {
        $this->options = $config;
        return $this;
    }

    /**
     * @return bool
     */
    public function getIdentifier()
    {
        return $this->options['default_theme_identifier'];
    }
}
