<?php

namespace backend\php\util;

use Exception;
use ReflectionClass;

/**
 * Dependency Injection Container
 * Binds the abstract and concrete,
 *      typically Interfaces(abstract) to their respective Classes(concrete)
 *
 *      abstract can be anything: classes, interfaces, string, int
 *      concrete has to be something that can be instantiated (functions or classes)
 *
 * Creates Class(concrete) instances by resolving the abstract given
 *
 * Has the ability to pass parameters and instances needed by the instance being constructed.
 *
 * This class is fully based on this YouTube video
 * https://www.youtube.com/watch?v=HOVWXa7HBZY
 * @author Beng
 */
class Container
{
    protected array $bindings = [];

    protected static ?Container $instance = null;

    /**
     * Constructor is protected so that other files cannot create multiple instances of this class
     * @author Beng
     */
    protected function __construct(){

    }

    /**
     * Binds the abstracts with their respective concretes
     * Bindings are saved to an array with the $abstract as the key
     * and the $concrete as the value
     *
     * @param $abstract
     * @param $concrete
     * @return void
     * @author Beng
     */
    public function bind($abstract, $concrete): void
    {
        $this->bindings[ $abstract ] = $concrete;
    }

    /**
     * When given an $abstract,
     *
     * if $abstract is not bound,
     * checks if the $abstract itself can be instantiated,
     * else error
     *
     * $concrete will be the bound instantiable,
     * or the instantiable $abstract itself
     *
     * if $concrete is a function, calls the function
     *
     * else build the class instance using buildInstance()
     *
     * @param $abstract
     * @return mixed
     * @throws Exception
     * @author Beng
     */
    public function resolve($abstract): mixed
    {
        if(!isset($this->bindings[$abstract])){
            $this->ensureClassIsInstantiable($abstract);
        }

        $concrete = $this->bindings[ $abstract ] ?? $abstract;

        if(is_callable($concrete)){
            return call_user_func($concrete);
        }

        return $this->buildInstance($concrete);
    }

    /**
     * Uses the ReflectionClass to check if $class can be instantiated
     * Throws an error otherwise
     * @param $class
     * @return void
     * @throws \ReflectionException
     * @author Beng
     */
    protected function ensureClassIsInstantiable($class){
        $reflection = new ReflectionClass($class);

        if(!$reflection->isInstantiable()){
            throw new Exception("{$class} is not instantiable");
        }
    }

    /**
     * Builds the instance
     *
     * Checks if this class is bound to a function, return and call the function
     *
     * Else, if there's no constructor for this class, return a new instance of this class
     *
     * Else, if this class is bound to another class, return and build an instance of the new class
     *
     * Else, if there's no constructor and is not bound to something else and is still not instantiated, then throw exception
     *
     * Else, the instance must have a constructor.
     * Create instances of all the required parameters
     * If the parameters for the constructor is not optional and cannot be instantiated, the return error
     *
     * Return the new class instance with the instantiated parameters in the constructor
     *
     * Notice how we can chain the container bindings, I have some examples in backend_dummy_index.php
     * @param $class
     * @return mixed
     * @throws \ReflectionException
     * @author Beng
     */
    protected function buildInstance($class){
        $reflection = new ReflectionClass($class);

        $constructor = $reflection->getConstructor();

        if(isset($this->bindings[$class]) && is_callable($this->bindings[$class])){
            return call_user_func($this->bindings[$class]);
        }

        if(!$constructor && $reflection->isInstantiable()){
            return new $class;
        }

        if(!$constructor && isset($this->bindings[$class])){
            $class = $this->bindings[$class];

            return $this->buildInstance($class);
        }

        if(!$constructor && !isset($this->bindings[$class])){
            throw new Exception("$class is not instantiable");
        }

        $parameters = $constructor->getParameters();

        $parameterInstance = [];

        foreach ($parameters as $parameter){

            if(!$parameter->getType() && !$parameter->isOptional()){
                throw new Exception("parameter {$parameter->getName()} for {$class} is not instantiable");
            }

            $parameterInstance[] = $this->buildInstance($parameter->getType()->getName());

        }


        return new $class(...$parameterInstance);

    }

    /**
     * Checks if an instance of this Class exists, create a new instance if not
     * Returns an instance of this class
     *
     * @return Container|static|null
     * @author Beng
     */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new static();
        }

        return self::$instance;
    }

}