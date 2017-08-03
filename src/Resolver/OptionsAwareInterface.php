<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

use Zend\Config\Config;

/**
 * Interface OptionsAwareInterface
 * @package MSBios\Theme\Resolver
 */
interface OptionsAwareInterface
{
    /**
     * @param Config $config
     * @return mixed
     */
    public function setOptions(Config $config);
}
