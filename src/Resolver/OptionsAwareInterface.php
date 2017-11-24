<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

/**
 * Interface OptionsAwareInterface
 * @package MSBios\Theme\Resolver
 */
interface OptionsAwareInterface
{
    /**
     * @param array $config
     * @return mixed
     */
    public function setOptions(array $config);
}
