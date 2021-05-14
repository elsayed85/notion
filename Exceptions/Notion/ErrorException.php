<?php
namespace Elsayed85\Notion;

use Exception;

class ErrorException extends Exception
{
    public $message;
    public $data;
    public $status;
    public function __construct($message,  $status)
    {
        $this->message = $message;
        $this->status = $status;
    }

    public function context()
    {
        return $this->data;
    }

    public function setExtraData($data = [])
    {
        $this->data = $data;
        return $this;
    }
}
