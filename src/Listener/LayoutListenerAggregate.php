<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme\Listener;

use Zend\EventManager\EventInterface;
use Zend\Router\RouteMatch;
use Zend\View\Model\ModelInterface;

/**
 * Class LayoutListenerAggregate
 * @package MSBios\Theme\Listener
 */
class LayoutListenerAggregate extends AbstractListenerAggregate
{
    /** @const IDENTIFIER */
    const IDENTIFIER = 'layout_identifier';

    /**
     * @param EventInterface $event
     */
    public function onDispatch(EventInterface $event)
    {
        if (! is_null($event->getResult())) {
            return;
        }

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
