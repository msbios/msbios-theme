<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Listener;

/**
 * Class AbstractListener
 * @package MSBios\Theme\Listener
 */
abstract class AbstractListener
{
    /**
     * @var ListenerOptions
     */
    protected $options;

    /**
     * AbstractListener constructor.
     * @param ListenerOptions|null $options
     */
    public function __construct(ListenerOptions $options = null)
    {
        $options = $options ?: new ListenerOptions;
        $this->setOptions($options);
    }

    /**
     * Get options.
     *
     * @return ListenerOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set options.
     *
     * @param ListenerOptions $options the value to be set
     * @return AbstractListener
     */
    public function setOptions(ListenerOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Write a simple array of scalars to a file
     *
     * @param $filePath
     * @param $array
     * @return $this
     */
    protected function writeArrayToFile($filePath, $array)
    {
        $content = "<?php\nreturn " . var_export($array, 1) . ';';
        file_put_contents($filePath, $content, LOCK_EX);
        return $this;
    }
}
