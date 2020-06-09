<?php

namespace App;

class SimpleContainer
{
    protected array $instances;

    public function set(string $interface, string $class = null): SimpleContainer
    {
        if (!$class) {
            $class = $interface;
        }
        $this->instances[$interface] = $class;

        return $this;
    }

    public function get(string $interface)
    {
        if (!isset($this->instances[$interface])) {
            $this->set($interface);
        }

        return $this->resolve($this->instances[$interface]);
    }

    protected function resolve(string $class)
    {
        $reflector = new \ReflectionClass($class);
        $constructor = $reflector->getConstructor();

        if (!$constructor) {
            return $reflector->newInstance();
        }

        $params         = $constructor->getParameters();
        $dependencies   = $this->getDependencies($params);

        return $reflector->newInstanceArgs($dependencies);
    }

    protected function getDependencies(array $params)
    {
        $dependencies = [];
        foreach ($params as $param) {
            $dependency = $param->getClass();
            if ($dependency) {
                $dependencies[] = $this->get($dependency->getName());
            }
        }

        return $dependencies;
    }
}
