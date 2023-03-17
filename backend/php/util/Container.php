<?php

namespace backend\php\util;


//dependency injection container that automatically creates instances of all the dependencies of a class that is resolved out the IoC util.
use Exception;
use ReflectionClass;

class Container
{
    protected array $bindings = [];

    protected static ?Container $instance = null;

    protected function __construct(){

    }

    public function bind($abstract, $concrete)
    {
        $this->bindings[ $abstract ] = $concrete;
    }

    public function resolve($abstract)
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


    protected function ensureClassIsInstantiable($class){
        $reflection = new ReflectionClass($class);

        if(!$reflection->isInstantiable()){
            throw new Exception("{$class} is not instantiable");
        }
    }

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

    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new static();
        }

        return self::$instance;
    }

}