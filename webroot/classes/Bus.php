<?php

namespace classes;

class Bus
{
    private $vin;
    private $make;
    private $model;
    private $passenger_capacity;
    private $odometer_reading;
    private $odometer_read_date;

    function __construct($vin, $make, $model, $passenger_capacity, $odometer_reading, $odometer_read_date)
    {
        $this->vin = $vin;
        $this->make = $make;
        $this->model = $model;
        $this->passenger_capacity = $passenger_capacity;
        $this->odometer_reading = $odometer_reading;
        $this->odometer_read_date = $odometer_read_date;
    }

    function get_vin()
    {
        return $this->vin;
    }

    function get_make()
    {
        return $this->make;
    }

    function get_model()
    {
        return $this->model;
    }

    function get_passenger_capacity()
    {
        return $this->passenger_capacity;
    }

    function get_odometer_reading()
    {
        return $this->odometer_reading;
    }

    function get_odometer_read_date()
    {
        return $this->odometer_read_date;
    }
}