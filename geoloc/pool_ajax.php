<?php
//echo '{"result":1,"message":"valid login"}';
$cmd = $_REQUEST['cmd'];
switch ($cmd) {
    case 1:
        login();        //if cmd=1 the call login
        break;
    case 2:
        signUp();        //if cmd=2 the call sign up
        break;
    case 3:
        createPool();        //if cmd=2 the call sign up
        break;
    case 4:
        getPool();        //if cmd=2 the call sign up
        break;
    case 5:
        joinPool();        //if cmd=2 the call sign up
        break;
    case 6:
        getPoolsCreated();        //if cmd=2 the call sign up
        break;

}

function login()
{
    include_once("carpool_functions.php");
    $obj = new carpool_functions();

    if (!isset($_GET['username'])) {
        exit();
    }
    $username = $_GET['username'];
    $password = $_GET['password'];

    $result = $obj->login($username, $password);
    $row = $result->fetch_assoc();
    if ($row) {
        echo '{"result":1,"message":"valid login"}';

        session_start();
        $_SESSION['username'] = $row['username'];
        $_SESSION['phonenumber'] = $row['phonenumber'];

       
    } else {
        echo '{"result":0,"message":"invalid login"}';
    }
}


function signUp()
{
    include_once("carpool_functions.php");
    $obj = new carpool_functions();

    if (!isset($_GET['username'])) {
        exit();
    }
    $firstname = $_GET['firstname'];
    $lastname = $_GET['lastname'];
    $username = $_GET['username'];
    $password = $_GET['password'];
    $phoneNumber = $_GET['phoneNumber'];

    $result = $obj->addUser($firstname, $lastname, $username, $password, $phoneNumber);



    if($result) {

        echo '{"result":1,"message":"sign up successful"}';
    } else {
        echo '{"result":0,"message":"sign up failed"}';
    }

}

function createPool()
{
    include_once("carpool_functions.php");
    $obj = new carpool_functions();




    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location:http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#homepage");
        exit();
    } else {

        $username = $_SESSION['username'];
    }
    $spots = $_GET['spotsAvailable'];
    $fare = $_GET['fare'];
    $date = $_GET['date'];
    $destination = $_GET['destination'];

    $result = $obj->createPool($spots, $fare, $date, $destination, $username);


    if($result) {
       echo '{"result":1,"message":"join successful"}';
    } else {
      echo '{"result":0,"message":"join failed"}';

    }

}

function getPool()
{
    include_once("carpool_functions.php");
    $obj = new carpool_functions();

    session_start();

    if(!isset($_SESSION['username'])){
        header("Location:http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#homepage");
        exit();
    }else{

        $username = $_SESSION['username'];
    }


    $result = $obj->getPool();


    if($result==true){

        $row=$result->fetch_assoc();
        echo '{"result":1,"pool":[';
        while($row){
            echo json_encode($row);

            $row=$result->fetch_assoc();
            if($row!=false){
                echo ",";
            }
        }
        echo "]}";

}

    else{

        echo '{"result":0,"message":"Could not fetch pools"}';
    }


}

function joinPool()
{
    include_once("carpool_functions.php");
    $obj = new carpool_functions();

    session_start();

    if(!isset($_SESSION['username'])){
        header("Location:index.html#homepage");
        exit();
    }else{

        $username = $_SESSION['username'];
        $phonenumber = $_SESSION['phonenumber'];
    }

    $pid = $_GET['pid'];
    $pay = $_GET['pay'];

    $result = $obj->joinPool($pid);


    if($result) {
        if($pay == "cash") {
            $row = $obj->getPassengers($pid);
        }else{
            $row = $obj->getMobilePassengers($pid);
        }
        $passengers = $row->fetch_assoc();
        if($pay == "cash") {
            $newPassengers =  $passengers['passengers'] . ",".$username;
        }else{
            $newPassengers =  $passengers['mobilePassengers'] . ",".$username;

        }

        $destination = $passengers['destination'];
        $date = $passengers['date'];
        $owner = $passengers['owner'];
        $spotsAvailable = $passengers['spotsAvailable'];

        $message = "You have joined a carpool owned by " . $owner . " going from " . $destination . " on " . $date;
        if ($pay == "cash") {
            $row = $obj->setPassengers($newPassengers, $pid);
        } else {
            $row = $obj->setMobilePassengers($newPassengers, $pid);
        }


        if ($row == 1) {

            $ch = curl_init();
            $url = "http://52.89.116.249:13013/cgi-bin/sendsms?username=mobileapp&password=foobar&to=" . $phonenumber . "&from='Car Pool'&smsc=esstigo&text=" . $message;
            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            session_write_close();
            curl_exec($ch);
            curl_close($ch);
            echo '{"result":1,"message":"join successful"}';
            if ($spotsAvailable <= 0) {
                $myRow = $obj->getOwnerNumber($owner);
                $myResult = $myRow->fetch_assoc();
                $ownerNumber = $myResult['phonenumber'];
                $message = "Dear car pool owner, you pool created to go from " . $destination . "on" . $date . "is full";
                $ch = curl_init();
                $url = "http://52.89.116.249:13013/cgi-bin/sendsms?username=mobileapp&password=foobar&to=" . $ownerNumber . "&from=233274446115&smsc=esstigo&text=" . $message;
                // set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
                curl_exec($ch);
                curl_close($ch);
=======
        $message = "You have joined a carpool owned by ". $owner. " going from ". $destination . " on " . $date;
        if($pay == "cash") {
            $row = $obj->setPassengers($newPassengers,$pid);
        }else{
            $row = $obj->setMobilePassengers($newPassengers,$pid);
        }


        if($row == 1) {

            echo '{"result":1,"message":"join successful"}';
            $ch = curl_init();
            $url = "http://52.89.116.249:13013/cgi-bin/sendsms?username=mobileapp&password=foobar&to=".$phonenumber."&from=233274446115&smsc=esstigo&text=".$message;
           // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            curl_exec($ch);
            curl_close($ch);
            if ($spotsAvailable <= 0){
                $myRow = $obj->getOwnerNumber($owner);
                $myResult = $myRow->fetch_assoc();
                $ownerNumber = $myResult['phonenumber'];
                $message = "Dear car pool owner, you pool created to go from ".$destination."on".$date."is full";
                $ch = curl_init();
              $url = "http://52.89.116.249:13013/cgi-bin/sendsms?username=mobileapp&password=foobar&to=".$ownerNumber."&from=233274446115&smsc=esstigo&text=".$message;
            // set URL and other appropriate options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
           curl_exec($ch);
            curl_close($ch);

            }
        }
    } else {
        echo '{"result":0,"message":"join failed"}';
    }

}

function getPoolsCreated()
{
    include_once("carpool_functions.php");
    $obj = new carpool_functions();

    session_start();

    if(!isset($_SESSION['username'])){
        header("Location:http://52.89.116.249/~anna.addei/CarPool/geoloc/index.html#homepage");
        exit();
    }else{

        $username = $_SESSION['username'];
    }


    $result = $obj->getPoolsCreated($username);


    if($result==true){

        $row=$result->fetch_assoc();
        echo '{"result":1,"pool":[';
        while($row){
            echo json_encode($row);

            $row=$result->fetch_assoc();
            if($row!=false){

                echo ",";
            }
        }
        echo "]}";


    }

    else{

        echo '{"result":0,"message":"Could not fetch pools"}';
    }


}