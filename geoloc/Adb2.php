<?php
include "setting.php";

class Adb2 extends mysqli
{
    var $result = null;

    public function __construct()
    {
        parent::__construct(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, PORT);

        if (mysqli_connect_error()) {
            die('Connection Error (' . mysqli_connect_error() . ')');
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->close();
    }


}