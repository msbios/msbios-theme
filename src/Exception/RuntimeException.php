<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Exception;

use Exception;

/**
 * Class RuntimeException
 * @package MSBios\Theme\Exception
 */
class RuntimeException extends \RuntimeException
{
    /** @var string */
    protected $message = 'Service does not implement the required interface ResolverInterface.';
    /**
     * RuntimeException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($this->message, $code, $previous);
    }

}