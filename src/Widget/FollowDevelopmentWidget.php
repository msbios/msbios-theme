<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Widget;

use MSBios\Widget\RendererWidgetAwareInterface;
use MSBios\Widget\RendererWidgetAwareTrait;
use MSBios\Widget\WidgetInterface;

/**
 * Class FollowDevelopmentWidget
 * @package MSBios\Theme\Widget
 */
class FollowDevelopmentWidget implements WidgetInterface, RendererWidgetAwareInterface
{
    use RendererWidgetAwareTrait;

    /**
     * @param null $data
     * @param callable|null $callback
     * @return mixed|string
     */
    public function output($data = null, callable $callback = null)
    {
        return $this->render('follow-development');
    }
}
