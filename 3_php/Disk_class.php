<?php

/**
 * Description of disk_class
 *
 * @author Nikolajs Koņkovs <nikolajskonkovs@gmail.com>
 */
class Disk_class {
    var $title;
    var $price;
    var $size;
    var $manufacturer;

    /*
     * Constructor
     * 
     * @param string $t Title of the "CD/DVD disks" product
     * @param int $p Price of the "CD/DVD disks" product
     * @param int $s Size in megabytes of the "CD/DVD disks" product
     * @param string $m Manufacturer of the "CD/DVD disks" product
     */
    function Disk_class($t, $p, $s, $m) {
        $this->title = $t;
        $this->price = $p;
        $this->size = $s;
        $this->manufacturer = $m;
    }

    /*
     * Returns name of the product
     * 
     * @return string
     */
    function get_name() {
        return $this->title . " " . $this->size . "MB";
    }

    /*
     * Returns value of the product's attribute
     * Value of the "size" attribute must have “MB” appended to it
     * 
     * @param string $attribute_name Name of the attribute which value must be returned
     * @return string
     */
    function get_attribute($attribute_name) {
        $attributes = get_object_vars($this);
        $attribute_value = $attributes[$attribute_name];
        if ($attribute_name == "size") {
            return $attribute_value . "MB";
        } else {
            return $attribute_value;
        }
    }

    /*
     * Returns values of all product's attributes sepparated by comma
     * Value of the "size" attribute must have “MB” appended to it
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