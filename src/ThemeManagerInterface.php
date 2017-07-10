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
     * @return mixed
     */
    public function loadThemes();

    /**
     * @param array $config
     * @return mixed
     */
    public function loadTheme(array $config);

    /**
     * @param $themeIdentifier
     * @return mixed
     */
    public function getLoadedThemes($themeIdentifier);

    /**
     * @return mixed
     */
    public function getThemes();

    /**
     * @param $themes
     * @return mixed
     */
    public function setThemes($themes);
}
