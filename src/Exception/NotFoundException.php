<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\Theme\Exception;

use Exception;

/**
 * Class NotFoundException
 * @package MSBios\Theme\Exception
 */
class NotFoundException extends Exception
{
    /** @var string */
    protected $message = 'Theme not found.';

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