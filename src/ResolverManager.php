<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\Theme\Resolver\AggregateResolverInterface;
use MSBios\Theme\Resolver\ResolverInterface;
use Zend\Stdlib\PriorityQueue;

/**
 * Class ResolverManager
 * @package MSBios\Theme
 */
class ResolverManager implements AggregateResolverInterface
{
    /** @var PriorityQueue|ResolverInterface[] */
    protected $queue;

    /** @var ResolverInterface */
    protected $lastStrategyFound;

    /**
     * AggregateResolver constructor.
     */
    public function __construct()
    {
        $this->queue = new PriorityQueue;
    }

    /**
     * @param ResolverInterface $resolver
     * @param int $priority
     * @return $this
     */
    public function attach(ResolverInterface $resolver, $priority = 1)
    {
        $this->queue->insert($resolver, $priority);
        return $this;
    }

    /**
     * @return bool
     */
    public function getIdentifier()
    {

        if (count($this->queue)) {

            /** @var ResolverInterface $detector */
            foreach ($this->queue as $detector) {

                /** @var string $identifier */
                $identifier = $detector->getIdentifier();

                if (empty($identifier)) {
                    // No resource found; try next resolver
                    continue;
                }

                // Resource found; return it
                $this->lastStrategyFound = $detector;
                return $identifier;
            }
        }

        return false;
    }
}
