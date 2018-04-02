<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme;

/**
 * Class ConfigProvider
 * @package MSBios\Theme
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return dependency mappings for this component.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'factories' => [
                'ThemeManager' =>
                    Factory\ThemeManagerFactory::class,
            ],
            'aliases' => [
                ThemeManager::class =>
                    'ThemeManager',
                ThemeManagerInterface::class =>
                    ThemeManager::class
            ]
        ];
    }
}
