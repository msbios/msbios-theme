<?php
///**
// * @access protected
// * @author Judzhin Miles <info[woof-woof]msbios.com>
// */
//
//namespace MSBios\Theme\Listener;
//
//use Zend\EventManager\AbstractListenerAggregate as DefaultAbstractListenerAggregate;
//use Zend\EventManager\EventInterface;
//use Zend\EventManager\EventManagerInterface;
//use Zend\Mvc\MvcEvent;
//use Zend\ServiceManager\ServiceLocatorInterface;
//
///**
// * Class AbstractListenerAggregate
// * @package MSBios\Theme\Listener
// */
//abstract class AbstractListenerAggregate extends DefaultAbstractListenerAggregate
//{
//    /** @var  ServiceLocatorInterface */
//    protected $serviceManager;
//
//    /**
//     * AbstractListenerAggregate constructor.
//     * @param ServiceLocatorInterface $serviceManager
//     */
//    public function __construct(ServiceLocatorInterface $serviceManager)
//    {
//        $this->serviceManager = $serviceManager;
//    }
//
//    /**
//     * Attach one or more listeners
//     *
//     * Implementors may add an optional $priority argument; the EventManager
//     * implementation will pass this to the aggregate.
//     *
//     * @param EventManagerInterface $events
//     * @param int $priority
//     * @return void
//     */
//    public function attach(EventManagerInterface $events, $priority = 1)
//    {
//        /** @var array $listener */
//        $listener = [$this, 'onDispatch'];
//        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER_ERROR, $listener, $priority);
//        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, $listener, $priority);
//        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, $listener, $priority);
//    }
//
//    /**
//     * @param EventInterface $event
//     * @return mixed
//     */
//    public abstract function onDispatch(EventInterface $event);
//}