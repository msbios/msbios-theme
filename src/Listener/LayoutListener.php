<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use Zend\View\Model\ModelInterface;

/**
 * Class LayoutListener
 * @package MSBios\Theme\Listener
 */
class LayoutListener extends AbstractListenerAggregate
{
    /** @const IDENTIFIER */
    const IDENTIFIER = 'layout_identifier';

    /**
     * @param EventManagerInterface $events
     * @param int $priority
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        /** @var array $listener */
        $listener = [$this, 'onRender'];
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER, $listener, $priority);
        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, $listener, $priority);
    }

    /**
     * @param EventInterface $event
     */
    public function onRender(EventInterface $event)
    {
        /** @var RouteMatch $routeMatch */
        $routeMatch = $event->getRouteMatch();

        if (! $routeMatch instanceof RouteMatch) {
            return;
        }

        /** @var string $identifier */
        if ($identifier = $routeMatch->getParam(self::IDENTIFIER)) {

            /** @var ModelInterface $viewModel */
            $viewModel = $event->getViewModel();
            if (! $viewModel instanceof ModelInterface) {
                return;
            }

            $viewModel->setTemplate("layout/{$identifier}");
        }
    }
}
