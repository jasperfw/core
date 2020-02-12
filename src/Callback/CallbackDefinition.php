<?php

namespace JasperFW\Core\Callback;

/**
 * Class CallbackDefinition
 *
 * Contains the definition of a callback.
 *
 * @package JasperFW\Core\Callback
 */
class CallbackDefinition
{
    protected $object_or_class;
    protected $method;
    protected $arguments;

    /**
     * CallbackDefinition constructor.
     *
     * @param mixed $object_or_class The class or object that contains the method
     * @param callable $method The method to be called
     * @param array $arguments An array of arguments to be passed to the method when it is called
     */
    public function __construct($object_or_class, $method, $arguments = [])
    {
        $this->object_or_class = $object_or_class;
        $this->method = $method;
        $this->arguments = $arguments;
    }

    /**
     * Executes the specified callback.
     *
     * @return mixed The value returned by the callback
     */
    public function execute()
    {
        return call_user_func_array(array($this->object_or_class, $this->method), $this->arguments);
    }
}