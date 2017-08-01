<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

use MSBios\Theme\Config\Config;

/**
 * Interface ConfigAwareInterface
 * @package MSBios\Theme\Resolver
 */
interface ConfigAwareInterface
{
    /**
     * @param Config $config
     * @return mixed
     */
    public function setConfig(Config $config);
}
