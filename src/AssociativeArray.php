<?php

namespace oliverde8\AssociativeArraySimplified;

use oliverde8\AssociativeArraySimplified\Exception\ReadOnlyException;

/**
 * Class AssociativeArray
 *
 * @author    de Cramer Oliver<oldec@smile.fr>
 * @copyright 2017 Smile
 * @package oliverde8\AssociativeArraySimplified
 */
class AssociativeArray
{
    /**
     * True associative array storing the data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Separation string for recursive search.
     *
     * @var
     */
    protected $separator;

    /**
     * Block this object so that it can't be modified
     *
     * @var bool
     */
    protected $readOnly = false;

    /**
     * AssociativeArray constructor.
     *
     * @param array $data
     * @param string $keySeparator
     */
    function __construct($data = [], $keySeparator = '/')
    {
        $this->data = $data;
        $this->separator = $keySeparator;
    }

    /**
     * Get value from, if is not set then return default value(null)
     *
     * @param string[]|string $key       Key or path to the value
     *                                   (either array or string separated with the separator)
     * @param mixed           $default   Default value to return if none was find
     *
     * @return mixed
     */
    public function get($key, $default = null) {
        return self::getFromKey($this->data, $key, $default, $this->separator);
    }

    /**
     * Set data inside
     *
     * @param string[]|string $key       Key or path to the value to set
     *                                   (either array or string separated with the separator)
     * @param mixed           $value     Value to put
     */
    public function set($key, $value) {
        $this->checkReadOnly();
        self::setFromKey($this->data, $key, $value, $this->separator);
    }

    public function clear()
    {
        $this->checkReadOnly();
        $this->data = [];
    }


    /**
     * @return array All the data
     */
    public function getArray(){
        return $this->data;
    }


    /**
     * Replace the data
     *
     * @param array $data new data
     */
    public function setData($data) {
        $this->checkReadOnly();
        $this->data = $data;
    }

    /**
     * Makes the data inside read only !!
     */
    public function makeReadOnly() {
        $this->readOnly = true;
    }

    /**
     * Checks if the associative array is read only.
     *
     * @throws ReadOnlyException
     */
    public function checkReadOnly() {
        if ($this->readOnly) {
            throw new ReadOnlyException('Trying to edit content in read only AssociativeArray !');
        }
    }

    /**
     * Get value from array, if is not set then return default value(null)
     *
     * @param array           $data      Array to get data from
     * @param string[]|string $key       Key or path to the value
     *                                   (either array or string separated with the separator)
     * @param mixed           $default   Default value to return if none was find
     * @param string          $separator Separator to use
     *
     * @return mixed
     */
    public static function getFromKey($data, $key, $default = null, $separator = '/')
    {
        if (!is_array($key)) {
            $key = explode($separator, $key);
        }
        return self::recurseiveGetFromKey($data, $key, $default);
    }

    /**
     * Set data inside an array
     *
     * @param array           $data      array to set new value in
     * @param string[]|string $key       Key or path to the value to set
     *                                   (either array or string separated with the separator)
     * @param mixed           $value     Value to put
     * @param string          $separator separator to use with the string
     */
    public static function setFromKey(&$data, $key, $value, $separator = '/')
    {
        if (is_string($key)) {
            $key = explode($separator, $key);
        }
        $data = self::recursiveSetFromKey($data, $key, $value);
    }

    /**
     * Private unsecured method to set data in array
     *
     * @param $data
     * @param $key
     * @param $value
     *
     * @return array
     */
    private static function recursiveSetFromKey($data, $key, $value)
    {
        if (empty($key)) {
            return $value;
        } else {
            if (!is_array($data)) {
                $data = [];
            }
            $currentKey = array_shift($key);

            if (!isset($data[$currentKey])) {
                $data[$currentKey] = [];
            }

            $data[$currentKey] = self::recursiveSetFromKey($data[$currentKey], $key, $value);
            return $data;
        }
    }

    /**
     * Private unsecured function for getFromKey
     *
     * @param $data
     * @param $key
     * @param $default
     *
     * @return mixed
     */
    private static function recurseiveGetFromKey($data, $key, $default)
    {
        if (empty($key)) {
            return $data;
        } else {
            $currentKey = array_shift($key);
            return isset($data[$currentKey]) ? self::recurseiveGetFromKey($data[$currentKey], $key, $default) : $default;
        }
    }
}