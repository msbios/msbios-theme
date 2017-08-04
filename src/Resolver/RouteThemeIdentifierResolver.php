<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

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
     * @param MvcEvent $e
     */
    public function setMvcEvent(MvcEvent $e)
    {
        $this->event = $e;
    }

    /**
     * @return bool|mixed
     */
    public function getIdentifier()
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
