<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Widget;

use MSBios\Widget\AbstractRendererWidget;

/**
 * Class FollowDevelopmentWidget
 * @package MSBios\Theme\Widget
 */
class FollowDevelopmentWidget extends AbstractRendererWidget
{

    /**
     * @param null $data
     * @return string
     */
    public function output($data = null)
    {
        return $this->render('follow-development');
    }
}