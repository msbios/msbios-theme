<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

/**
 * Interface ThemeManagerInterface
 * @package MSBios\Theme
 */
interface ThemeManagerInterface
{
    /**
     * @param $identifierOrInstance
     * @return mixed
     */
    public function hasTheme($identifierOrInstance);

    /**
     * @param Theme $theme
     * @return mixed
     */
    public function addTheme(Theme $theme);

    /**
     * @param $identityOrInstance
     * @return mixed
     */
    public function removeTheme($identityOrInstance);

    /**
     * @param $identifier
     * @return mixed
     */
    public function getTheme($identifier);

    /**
     * @return mixed
     */
    public function current();

    /**
     * @return mixed
     */
    public function getDefaultTheme();
}
