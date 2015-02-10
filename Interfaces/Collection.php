<?php
/**
 * Created by PhpStorm.
 * User: Nav
 * Date: 28-12-2014
 * Time: 0:26
 */

class Collection implements Countable, JsonSerializable{
    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        return json_encode($this->items);
    }

    protected $items = [];

    public function add($value)
    {
        $this->items[] = $value;
    }

    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }

    public function toJson()
    {
        return json_encode($this->items);
    }
}