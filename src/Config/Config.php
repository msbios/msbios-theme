<?php
/**
 *
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Config;

use Zend\Config\Config as DefaultConfig;

/**
 * Class Config
 * @package MSBios\Theme\Config
 */
class Config extends DefaultConfig
{

    /**
     * @return mixed
     */
    public function getResolversConfigurationThemes()
    {
        return $this->get('resolvers_configuration_themes');
    }

    /**
     * @return mixed
     */
    public function getDefaultThemeIdentifier()
    {
        return $this->get('default_theme_identifier');
    }

    /**
     * @return mixed
     */
    public function getDefaultLayoutIdentifier()
    {
        return $this->get('default_layout_identifier');
    }

    /**
     * @return mixed
     */
    public function getGlobalPaths()
    {
        return $this->get('default_global_paths');
    }

    /**
     * @return mixed
     */
    public function getThemes()
    {
        return $this->get('themes');
    }
}
