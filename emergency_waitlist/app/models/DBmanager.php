<?php
namespace DBmanager;
session_start();
$_SESSION["patient"];


use DateTime;

abstract class SeverityTime{
    public const SeverityOne = "00:15:00";   //15mins
    public const SeverityTwo = "00:30:00";   //30mins
    public const SeverityThree = "00:45:00"; //45mins
    public const SeverityFour = "01:00:00";  //1hr
    public const SeverityFive = "02:00:00";  //2hrs
}

Class SeverityLevel{
    public static function severityLevelToTime($severity){
        switch($severity){
            case 1:
                return SeverityTime::SeverityOne;
                break;
            case 2:
                return SeverityTime::SeverityTwo;
                break;
            case 3:
                return SeverityTime::SeverityThree;
                break;
            case 4:
                return SeverityTime::SeverityFour;
                break;
            case 5:
                return SeverityTime::SeverityFive;
                break;
        }
    }
}


class DBmanager{

    public $appName;
    public $connection_string;
    public $dbconnection;
    public $currentPatient;

    public function __construct()
    {
        $this->appName = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $this->connection_string = "host=localhost port=5432 dbname=emergency-waitlist user=postgres password=postgres options='--application_name=$this->appName'";
        $this->dbconnection = pg_connect($this->connection_string);
    }

    //generate 3 char code
    private function generateCode(){
        $chars = "abcdefghijklmnopqrstuvwxyz1234567890!@#$%&";
        $code = "";
        
        for($i = 0; $i<3; $i++){
            $code .= $chars[rand(0, strlen($chars)-1)];
        }
        return $code;
    }

    private function compareTimestamp($timestamp){
        $dt = new DateTime();
        $dt->setTimestamp(time() - strtotime($timestamp));
        return $dt->format('H:i:s');
    }

    private function compareTwoTimestamp($timestamp, $timestampOther, $injurtyTime){
        $dt = new DateTime();
        $dt->setTimestamp(((strtotime($timestamp) - strtotime($timestampOther))+$injurtyTime));
        return $dt->format('H:i:s');
    }

    public function validateAdmin($data){
        $username = $data["username"];
        $password = $data["password"];
        $query = "SELECT username, password FROM admin WHERE username like '{$username}' AND password like '{$password}'";
        $result = pg_query($this->dbconnection, $query) or die(pg_last_error());
        $row = pg_fetch_assoc($result);
        if($row == false){
            return false; //rows returns with no data
        }
        if($row["username"] == $username && $row["password"] == $password){
            return "admin"; //admin exists
        }
        return false; //query did not find the login data
    }

    public function validatePatient($data){
        $name = $data["name"];
        $code = $data["code"];
        $query = "SELECT name, code FROM patient WHERE name like '{$name}' AND code like '{$code}'";
        $result = pg_query($this->dbconnection, $query) or die(pg_last_error());
        $row = pg_fetch_assoc($result);
        if($row == false){
            return false; //rows returns with no data
        }
        if($row["name"] == $name && $row["code"] == $code){
            $_SESSION["patient"] = $row;
            return $row; //patient exists
        }
        return false; //query did not find the login data

    }

    public function insertPatient($data){
        $name = $data["name"];
        $injury_severity = $data["injury_severity"];
        $code = $this->generateCode();
        $query = "INSERT INTO patient(name, code, injury_severity, operating) VALUES('{$name}', '{$code}', {$injury_severity}, false)"; //create new patient
        pg_query($this->dbconnection, $query) or die(pg_last_error());
        $query = "INSERT INTO waitlist(patient, patient_code) VALUES ('{$name}', '{$code}')"; //add patient to wait list
        pg_query($this->dbconnection, $query) or die(pg_last_error());
        return "patient";
    }

    public function getOrderedWaitlistByTime(){
        //TODO: change so patients who are being operated are filtered out
        $query = "SELECT patient, patient_code, start_of_wait FROM waitlist ORDER BY start_of_wait"; 
        $result = pg_query($this->dbconnection, $query) or die(pg_last_error());
        $result_array = [];
        while ($row = pg_fetch_assoc($result)) {
            $row["start_of_wait"] = $this->compareTimestamp($row["start_of_wait"]);
            array_push($result_array, $row);
        }
        return $result_array;
    }

    public function getOrderedWaitlistBySeverity(){
        $query = "SELECT name, code, injury_severity FROM patient WHERE EXISTS ( 
            SELECT patient, patient_code FROM waitlist 
            WHERE patient.name = waitlist.patient AND patient.code = waitlist.patient_code) 
            ORDER BY injury_severity";
        $result = pg_query($this->dbconnection, $query) or die(pg_last_error());
        $table = pg_fetch_all($result);
        return $table;

    }

    public function getAllPatients(){
        $query = "SELECT name, code FROM patient";
        $result = pg_query($this->dbconnection, $query) or die(pg_last_error());
        $table = pg_fetch_all($result);
        return $table;
    }


    public function removePatientFromWaitlist(){

    }

    public function getApproximateWaitTime(){
        //show time and patient code
        $this->currentPatient = $_SESSION["patient"];
        $name = $this->currentPatient["name"];
        $code = $this->currentPatient["code"];

        $query = "SELECT patient, patient_code, start_of_wait, injury_severity 
                    FROM waitlist JOIN patient ON patient = name AND patient_code = code ORDER BY start_of_wait ASC"; //get first in waitlist
        $result = pg_query($this->dbconnection, $query);
        $row = pg_fetch_assoc($result); //get first row
        if($row["patient"] == $name && $row["patient_code"] == $code){ //patient is first in line
            return ["name" => $name, "code" => $code, "waitTime" => "You are first in line. The doctor will get to you shortly."]; //
        }
        $first_in_line_time = $row["start_of_wait"];
        $total_injury_time = strtotime(SeverityLevel::severityLevelToTime($row["injury_severity"]));
        while($row = pg_fetch_assoc($result)){
            if($row["patient"] != $name && $row["patient_code"] != $code){
                $severity = $row["injury_severity"];
                $total_injury_time += strtotime(SeverityLevel::severityLevelToTime($severity));
            }
            break;
        }
        $query = "SELECT patient, patient_code, start_of_wait FROM waitlist WHERE patient = '{$name}' AND patient_code = '{$code}'"; //get the current patient data
        $result = pg_query($this->dbconnection, $query);
        $row = pg_fetch_assoc($result);
        $patient_time = $row["start_of_wait"];
        $waitTime = $this->compareTwoTimestamp($patient_time, $first_in_line_time, $total_injury_time);
        return ["name" => $name, "code" => $code, "waitTime" => $waitTime];
    }

}



