<?php

class databaseConnection {

    var $host;
    var $username;
    var $password;
    var $database;
    var $dbconn;

   function __construct() {
        $this->host = "";
        $this->database = "";
        $this->username = "";
        $this->password = "";
    }


    function setConnection() {
        $production = 1;


        if ($production == 1) {

            $host = "localhost";
            $username = "admin";
            $password = "dev2021";
            $database = "psc";
        }


        $this->dbconn = mysqli_connect($host, $username, $password);
        mysqli_select_db( $this->dbconn , $database) or die("could not select Database");
    }

    function runQuery($sql) {

        // Runs a SELECT query and returns the result (or dies...)

        $rsinfo = mysqli_query( $this->dbconn ,$sql);





        // Load the recordset into an array





        $totalrows = 0;

        $trecord = @mysqli_num_rows($rsinfo);

        if ($trecord != 0) {

            while ($row = mysqli_fetch_array($rsinfo ,MYSQLI_ASSOC)) {

                $result[$totalrows] = $row;

                $totalrows++;
            }



            mysqli_free_result($rsinfo);



            return $result;
        } else
            return false;
    }

    function UpdateQuery($sql_statement) {
        $check = mysqli_query($this->dbconn, $sql_statement);


        if (mysqli_affected_rows($this->dbconn) === 1) {

            $ErrorCode = 1; /* ON SUCCESS */
        } else {

            $ErrorCode = 0; /* ON FAILURE */
        }



        return $ErrorCode;
    }

    function InsertQuery($sql_statement) {



        $check = mysqli_query( $this->dbconn, $sql_statement);





        if (mysqli_affected_rows($this->dbconn) === 1) {

            $ErrorCode = mysqli_insert_id($this->dbconn);
        } else {

            $ErrorCode = 0;
        }


       
        return $ErrorCode;
    }
    
    
    
  
    
    
    
    function close() {
        mysqli_close($this->dbconn);
    }

}

?>