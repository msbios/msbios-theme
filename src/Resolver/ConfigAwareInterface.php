<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

/**
 * Interface ConfigAwareInterface
 * @package MSBios\Theme\Resolver
 */
interface ConfigAwareInterface
{
    /**
     * @param array $config
     * @return mixed
     */
    public function setConfig(array $config);
}
