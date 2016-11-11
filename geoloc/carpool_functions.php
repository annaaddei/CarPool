<?php
/**
 * @author Anna Addei
 *This script is the submission class that defines the makeSubmission function to make an IRB submission
 */
include_once("Adb2.php");
class carpool_functions extends Adb2
{
    /**
     *Constructor
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     *Adds a new user
     * @param string title title of research project
     * @param string exemption resons for exemption if requested
     * @param string subjectCharacteristics characteristics of research subjects
     * @param string specialClasses special cases if applicable
     * @param string recruitment how subjects will be recruited
     * @param string partcipnatInfo how applicants are informed ofresearch procedures
     */
    function addUser($firstname, $lastname, $username, $password, $phonenumber)
    {
        $strQuery = /** @lang MySQL */
            "INSERT into users set
						firstname = ?,
						lastname = ?,
						username = ?,
						password = ?,
						phonenumber = ?
						";
        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("ssssi", $firstname, $lastname, $username, $password, $phonenumber);
            return $statement->execute();



        }
    }

    function login($username, $password)
    {
        $strQuery = /** @lang MySQL */
            "SELECT username, password , phonenumber
              FROM users 
              WHERE username = ? 
              AND password = ?
              LIMIT 1";

        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("ss", $username, $password);
            $statement->execute();
            return $statement->get_result();
        }
    }

    function createPool($spots, $fare, $date, $destination, $username)
    {
        $strQuery = /** @lang MySQL */

            "INSERT into poollist set 
                    spotsAvailable = ?,
                    fare = ?, 
                    date = ?,
                    destination = ?,
                    owner = ?";

        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("iidss", $spots, $fare, $date, $destination, $username);
            return $statement->execute();
        }
    }

    function getPool()
    {
        $strQuery = /** @lang MySQL */
            "SELECT pid,spotsAvailable, fare, date, destination, owner
                    FROM poollist
                    WHERE spotsAvailable > 0
						";

        if ($statement = $this->prepare($strQuery)) {
            $statement->execute();
            return $statement->get_result();
        }
    }

    function getPoolsCreated($username)
    {
        $strQuery = /** @lang MySQL */
            "SELECT spotsAvailable, fare, date, destination, owner, passengers, mobilePassengers
                    FROM poollist
                    WHERE owner = ?
						";

        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("s", $username);
            $statement->execute();
            return $statement->get_result();
        }
    }

    function joinPool($pid)
    {
        $strQuery = /** @lang MySQL */
            "UPDATE poollist
                    SET spotsAvailable = (spotsAvailable - 1)
                    WHERE pid = $pid
						";

        if ($statement = $this->prepare($strQuery)) {
            return $statement->execute();

        }
    }

    function getPassengers($pid)
    {
        $strQuery = /** @lang MySQL */
            "SELECT passengers, destination, date, owner, spotsAvailable
              FROM poollist 
              WHERE pid = ? 
						";

        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("i", $pid);
            $statement->execute();
            return $statement->get_result();

        }
    }
    function getMobilePassengers($pid)
    {
        $strQuery = /** @lang MySQL */
            "SELECT mobilePassengers, destination, date, owner, spotsAvailable
              FROM poollist 
              WHERE pid = ? 
						";

        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("i", $pid);
            $statement->execute();
            return $statement->get_result();

        }
    }

    function setPassengers($passengers, $pid)
    {
        $strQuery = /** @lang MySQL */
            "UPDATE poollist 
              SET passengers = ?
              WHERE pid = ? 
						";

        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("si", $passengers, $pid);
            return $statement->execute();


        }
    }

    function setMobilePassengers($passengers, $pid)
    {
        $strQuery = /** @lang MySQL */
            "UPDATE poollist 
              SET mobilePassengers = ?
              WHERE pid = ? 
						";

        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("si", $passengers, $pid);
            return $statement->execute();


        }
    }

    function getOwnerNumber($username)
    {
        $strQuery = /** @lang MySQL */
            "SELECT phonenumber
              FROM users 
              WHERE username = ? 
						";

        if ($statement = $this->prepare($strQuery)) {
            $statement->bind_param("s", $username);
            $statement->execute();
            return $statement->get_result();

        }
    }
}
