<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Resolver;

use Zend\Mvc\MvcEvent;

/**
 * Interface MvcEventAwareInterface
 * @package MSBios\Theme\Resolver
 */
interface MvcEventAwareInterface
{
    /**
     * @param MvcEvent $event
     * @return mixed
     */
    public function setMvcEvent(MvcEvent $event);
}
