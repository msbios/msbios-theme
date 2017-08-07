<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme;

use MSBios\Theme\Resolver\ResolverInterface;

/**
 * Class ResolverManager
 * @package MSBios\Theme
 */
interface ResolverManagerInterface extends ResolverInterface
{
    /**
     * @param ResolverInterface $resolver
     * @param int $priority
     * @return mixed
     */
    public function attach(ResolverInterface $resolver, $priority = 1);
}
