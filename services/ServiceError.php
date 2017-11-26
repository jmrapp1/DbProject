<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */

class ServiceError
{
    private $error;

    function __construct($error) {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }

}