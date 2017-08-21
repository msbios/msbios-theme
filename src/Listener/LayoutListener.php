<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */

namespace MSBios\Theme\Listener;

use Zend\EventManager\EventInterface;
use Zend\Mvc\Application;
use Zend\Router\RouteMatch;
use Zend\View\Model\ModelInterface;

/**
 * Class LayoutListener
 * @package MSBios\Theme\Listener
 */
class LayoutListener
{
    /** @const IDENTIFIER */
    const IDENTIFIER = 'layout_identifier';

    /**
     * @param EventInterface $event
     */
    public function onDispatch(EventInterface $event)
    {
        /** @var string $error */
        $error = $event->getError();

        if (empty($error) || Application::ERROR_EXCEPTION == $error) {
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
}
