<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\Resolver\AbstractResolverManager;
use MSBios\Resolver\ResolverInterface;

/**
 * Class ResolverManager
 * @package MSBios\Theme
 */
class ResolverManager extends AbstractResolverManager
{
    /** @var ResolverInterface */
    protected $lastStrategyFound;

    /**
     * <code>
     *     foreach ($this->queue as $resolver) {
     *         if ($resource = $resolver->resolve($arguments)) {
     *             return $resource;
     *         }
     *     }
     * </code>
     *
     * @param array ...$arguments
     * @return mixed
     */
    public function resolve(array ...$arguments)
    {
        if (count($this->queue)) {

            /** @var ResolverInterface $detector */
            foreach ($this->queue as $detector) {

                /** @var string $identifier */
                $identifier = $detector->resolve($arguments);

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
