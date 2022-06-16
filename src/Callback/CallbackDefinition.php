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
    protected mixed $object_or_class;
    protected string $method;
    protected array $arguments;

    /**
     * CallbackDefinition constructor.
     *
     * @param mixed  $object_or_class The class or object that contains the method
     * @param string $method          The method to be called
     * @param array  $arguments       An array of arguments to be passed to the method when it is called
     */
    public function __construct(mixed $object_or_class, string $method, array $arguments = [])
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
    public function execute(): mixed
    {
        return call_user_func_array(array($this->object_or_class, $this->method), $this->arguments);
    }
}
