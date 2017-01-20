<?php

namespace Vinelab\Bowler\Exceptions;

use PhpAmqpLib\Exception\AMQPProtocolChannelException;
use PhpAmqpLib\Exception\AMQPProtocolConnectionException;
use Vinelab\Bowler\Contracts\BowlerExceptionHandler as ExceptionHandler;

/**
 * @author Kinane Domloje <kinane@vinelab.com>
 */
class Handler
{
    /**
     * The BowlerExceptionHandler contract bound app's exception handler.
     */
    private $exceptionHandler;

    public function __construct(ExceptionHandler $handler)
    {
        $this->exceptionHandler = $handler;
    }

    /**
     * Map php-mqplib exceptions to Bowler's.
     *
     * @param \Exception $e
     * @param array      $parameters
     * @param array      $arguments
     *
     * @return mix
     */
    public function handleServerException(\Exception $e, $parameters = [], $arguments = [])
    {
        if ($e instanceof AMQPProtocolChannelException) {
            $e = new DeclarationMismatchException($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace(), $e->getPrevious(), $e->getTraceAsString(), $parameters,  $arguments);
        } elseif ($e instanceof AMQPProtocolConnectionException) {
            $e = new InvalidSetupException($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace(), $e->getPrevious(), $e->getTraceAsString(), $parameters, $arguments);
        } else {
            $e = new BowlerGeneralException($e->getMessage(), $e->getCode(), $e->getFile(), $e->getLine(), $e->getTrace(), $e->getPrevious(), $e->getTraceAsString(), $parameters, $arguments);
        }

        throw $e;
    }

    /**
     * Report error to the app's exceptions Handler.
     *
     * @param \Exception                         $e
     * @param mix PhpAmqpLib\Message\AMQPMessage $msg
     */
    public function reportError($e, $msg)
    {
        if(method_exists($this->exceptionHandler, 'reportQueue')) {
            $this->exceptionHandler->reportQueue($e, $msg);
        }
    }
}