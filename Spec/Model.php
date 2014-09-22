<?php

class Spec_Model extends Spec_Model_Abstract
{
    /**
     * @var array
     */
    protected static $_mappers = array();

    /**
     * @var string
     */
    protected static $_mapperClass = 'Spec_Model_Mapper_Mongo';

    /**
     * @param Spec_Model_Mapper_Interface $mapper
     *
     * @throws Exception
     */
    public static function setMapper(Spec_Model_Mapper_Interface $mapper)
    {
        $decorators = $mapper->getDecorators();
        $mapper->setDecorators($decorators);

        if (!empty($decorators)) {

            foreach ($decorators as $decorator) {

                if (class_exists($decorator)) {

                    $mapper = new $decorator($mapper);
                }
                else {
                    throw new Exception("Mapper decorator $decorator not found");
                }
            }
        }
        self::$_mappers[self::_getClassName()] = $mapper;
    }

    /**
     * @static
     * @return Spec_Model_Mapper_Mongo
     */
    public static function getMapper()
    {
        $class_name = self::_getClassName();

        if (empty(self::$_mappers[$class_name])) {
            $mapper_class = static::getMapperClassName();

            $mapper_obj = new $mapper_class($class_name);
            static::setMapper($mapper_obj);
        }

        return self::$_mappers[$class_name];
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function getMapperClassName()
    {
        $class_name = self::_getClassName();

        if (null !== static::$_mapperClass) {
            $mapper_class = static::$_mapperClass;
        }
        else {
            $mapper_class = $class_name.'_Mapper';
        }

        if (!class_exists($mapper_class)) {
            throw new Exception("Mapper class $mapper_class does not exist");
        }

        return $mapper_class;
    }

    public static function clearMappers()
    {
        self::$_mappers = array();
    }

    /**
     * @return bool
     */
    public function save()
    {
        return self::getMapper()->save($this);
    }

    /**
     * @param bool $safe
     *
     * @return bool
     */
    public function upsert($safe = false)
    {
        return (boolean)self::getMapper()->upsert($this, $safe);
    }

    /**
     * @param bool $safe
     *
     * @return bool
     */
    public function delete($safe = true)
    {
        return (bool)self::getMapper()->delete($this, $safe);
    }

    /**
     * @param $methodName
     * @param $params
     *
     * @return mixed
     * @throws Zend_Exception
     */
    public static function __callStatic($methodName, $params)
    {
        $method = array(
            self::getMapper(),
            $methodName
        );

        if (is_callable($method)) {
            return call_user_func_array($method, $params);
        }

        throw new Zend_Exception('Unable to call mapper method '.$methodName);
    }
}