<?php 
/**
 * Copyright 2015 Dirk Groenen 
 *
 * (c) Dirk Groenen <dirk@bitlabs.nl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirkGroenen\Pinterest\Models;

use DirkGroenen\Pinterest\Exceptions\PinterestException;

class Model {

    /**
     * The model's attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The available object keys
     * 
     * @var array
     */
    protected $fillable = [];

    /**
     * Create a new model instance
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        $this->fill($attributes);
    }

    /**
     * Get the model's attribute
     * 
     * @access public
     * @param  string   $key
     * @return mixed
     */
    public function __get($key)
    {
        return isset($this->attributes[$key]) ? $this->attributes[$key] : null;
    }

    /**
     * Set the model's attribute
     * 
     * @access public
     * @param  string   $key
     * @param  mixed   $value
     * @throws Exceptions\PinterestException
     * @return void
     */
    public function __set($key, $value)
    {
        if($this->isFillable($key)){
            $this->attributes[$key] = $value;
        }
        else{
            throw new PinterestException( sprintf("%s is not a fillable attribute.", $key) );
        }
    }

    /**
     * Fill the attributes
     *
     * @access private
     * @param  array   $attributes
     * @return void
     */
    private function fill(array $attributes)
    {
        foreach($attributes as $key => $value){
            if($this->isFillable($key)){
                $this->attributes[$key] = $value;
            }
        }
    }

    /**
     * Check if the key is fillable
     * 
     * @access public
     * @param  string   $key
     * @return boolean      
     */
    public function isFillable($key)
    {
        return in_array($key, $this->fillable);
    }

    /**
     * Convert the model instance to an array
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();
        
        foreach($this->fillable as $key){
            $array[$key] = $this->{$key};
        }

        return $array;
    }

    /**
     * Convert the model instance to JSON
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Convert the model to its string representation
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

}