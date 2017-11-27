<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Listener;

/**
 * Class ConfigListener
 * @package MSBios\Theme\Listener
 */
class ConfigListener
{
    /** @var ListenerOptions */
    protected $options;

    /**
     * ConfigListener constructor.
     * @param ListenerOptions $options
     */
    public function __construct(ListenerOptions $options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    protected function getCachedConfig()
    {
        return include $this->options->getConfigCacheFile();
    }
}