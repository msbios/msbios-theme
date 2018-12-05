<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

use MSBios\Resolver\ResolverInterface;

/**
 * Class DefaultThemeIdentifierResolver
 * @package MSBios\Theme\Resolver
 */
class DefaultThemeIdentifierResolver implements OptionsAwareInterface, ResolverInterface
{
    /** @var array */
    protected $options;

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param mixed ...$arguments
     * @return mixed
     */
    public function resolve(...$arguments)
    {
        return $this->options['default_theme_identifier'];
    }
}
