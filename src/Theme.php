<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\Stdlib\AbstractObject;

/**
 * Class Theme
 * @package MSBios\Theme
 */
class Theme extends AbstractObject
{
    /** @var array */
    protected $options;

    /**
     * Theme constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->addData($options);
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->getData('description');
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->getData('identifier');
    }

    /**
     * @return mixed
     */
    public function getTemplateMap()
    {
        return $this->getData('template_map');
    }

    /**
     * @return mixed
     */
    public function getTemplatePathStack()
    {
        return $this->getData('template_path_stack');
    }

    /**
     * @return mixed
     */
    public function getControllerMap()
    {
        return $this->getData('controller_map');
    }

    /**
     * @return mixed
     */
    public function getTranslationFilePatterns()
    {
        return $this->getData('translation_file_patterns');
    }

    /**
     * @return mixed
     */
    public function getWidgetManager()
    {
        return $this->getData('widget_manager');
    }
}
