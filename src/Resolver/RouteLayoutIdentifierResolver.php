<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

use MSBios\Resolver\ResolverInterface;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;

/**
 * Class RouteLayoutIdentifierResolver
 * @package MSBios\Theme\Resolver
 */
class RouteLayoutIdentifierResolver implements MvcEventAwareInterface, ResolverInterface
{
    /** @var MvcEvent */
    protected $event;

    /**
     * @param MvcEvent $event
     * @return $this|mixed
     */
    public function setMvcEvent(MvcEvent $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @param array ...$arguments
     * @return mixed
     */
    public function resolve(array ...$arguments)
    {
        /** @var RouteMatch $routeMatch */
        $routeMatch = $this->event
            ->getRouteMatch();

        if ($routeMatch instanceof RouteMatch) {
            return $routeMatch->getParam('layout_identifier');
        }

        return false;
    }
}
