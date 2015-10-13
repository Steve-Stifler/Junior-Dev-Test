<?php

/**
 * Description of furniture_class
 *
 * @author Nikolajs Koņkovs <nikolajskonkovs@gmail.com>
 */
class Furniture_class {
    var $title;
    var $price;
    var $size;
    var $material;

    /*
     * Constructor
     * 
     * @param string $t Title of the "Furniture" product
     * @param int $p Price of the "Furniture" product
     * @param string $s Size of the "Furniture" product (like 100x100x100)
     * @param string $m Materal of the "Furniture" product (wood or plastic)
     */
    function Furniture_class($t, $p, $s, $m) {
        $this->title = $t;
        $this->price = $p;
        $this->size = $s;
        $this->material = $m;
    }

    /*
     * Returns name of the product
     * 
     * @return string
     */
    function get_name() {
        return $this->title;
    }

    /*
     * Returns value of the product's attribute
     * 
     * @param string $attribute_name Name of the attribute which value must be returned
     * @return string
     */
    function get_attribute($attribute_name) {
        $attributes = get_object_vars($this);
        $attribute_value = $attributes[$attribute_name];
        return $attribute_value;
    }

    /*
     * Returns values of all product's attributes sepparated by comma
     * 
     * @return string
     */
    function get_all_attributes() {
        $attribute_names = array_keys(get_object_vars($this));
        $all_attributes = "";
        foreach ($attribute_names as $key) {
            if ($key == end($attribute_names)) {
                $all_attributes = $all_attributes . $this->get_attribute($key);
            } else {
                $all_attributes = $all_attributes . $this->get_attribute($key) . ", ";
            }
        }
        return $all_attributes;
    }
}
