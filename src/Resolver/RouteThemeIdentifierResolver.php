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
 * Class RouteThemeIdentifierResolver
 * @package MSBios\Theme\Resolver
 */
class RouteThemeIdentifierResolver implements MvcEventAwareInterface, ResolverInterface
{
    /** @var MvcEvent */
    protected $event;

    /**
     * @param MvcEvent $event
     */
    public function setMvcEvent(MvcEvent $event)
    {
        $this->event = $event;
    }

    /**
     * @param mixed ...$arguments
     * @return bool|mixed
     */
    public function resolve(...$arguments)
    {
        /** @var RouteMatch $routeMatch */
        $routeMatch = $this->event
            ->getRouteMatch();

        if ($routeMatch instanceof RouteMatch) {
            return $routeMatch->getParam('theme_identifier');
        }

        return false;
    }
}
