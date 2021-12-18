<?php

    class dbcon extends mysqli{
        private $host="localhost", $user="root", $password="", $db="emailassignmenttest";
        public $con;
        function __construct(){
                $this->con=$this->connect( $this->host , $this->user, $this->password, $this->db );
        }

    }

?>