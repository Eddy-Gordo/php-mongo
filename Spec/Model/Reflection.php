<?php

class Spec_Model_Reflection
{
    /**
     * @var array
     */
    protected static $_instances = array();

    /**
     * @var string
     */
    protected $_className;

    /**
     * @var array
     */
    protected $_properties = array();

    /**
     * @var ReflectionClass
     */
    protected $_reflectionClass;

    /**
     * @static
     *
     * @param $className
     *
     * @return Spec_Model_Reflection
     */
    public static function instance($className)
    {
        if (!isset(self::$_instances[$className])) {
            self::$_instances[$className] = new self($className);
        }

        return self::$_instances[$className];
    }

    /**
     * @param $className
     *
     * @throws Exception
     */
    protected function __construct($className)
    {

        if (!class_exists($className)) {
            throw new Zend_Exception($className.' not exists');
        }

        $this->_className = $className;
        $this->_reflectionClass = new ReflectionClass($className);

        $this->_init();
    }

    /**
     * @return Zend_Cache_Core
     */
    protected function _getCache()
    {
        return Zend_Registry::get('cache');
    }

    /**
     * @return bool
     */
    protected function _isCaching()
    {
        $config = Zend_Registry::get('config');

        return (boolean)$config['db']['cache'];
    }

    protected function _init()
    {
        $caching = $this->_isCaching();

        if ($caching) {
            $cache = $this->_getCache();

            $key = __CLASS__.'_'.$this->_className;
            $properties = $cache->load($key);

            if (is_array($properties)) {
                $this->_properties = $properties;

                return;
            }
        }

        $docComment = $this->_reflectionClass->getDocComment();
        $rows = explode("\n", $docComment);

        foreach ($rows as $row) {
            if (preg_match('/\@property/ui', $row)) {
                $property = new Spec_Model_Reflection_Property($row);
                if ($property->name) {
                    $this->_properties[$property->name] = $property;
                }
            }
        }

        if ($caching) {
            $cache->save($this->_properties, $key);
        }
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * @param string $name
     *
     * @return Spec_Model_Reflection_Property
     */
    public function getProperty($name)
    {
        return isset($this->_properties[$name]) ? $this->_properties[$name] : new Spec_Model_Reflection_Property('');
    }
}