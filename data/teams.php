<?php
class Team{
 
    // database connection and table name
    private $conn;
    private $table_name = "teams";
 
    // object properties
    public $id;
    public $kleding;
    public $comp;
    public $naam;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
     
        // select all query
        $query = "SELECT id, idKleding, idComp, naam
                    FROM " . $this->table_name . "
                    ORDER BY idComp DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }  

    // create team
    function create(){
     
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    idKleding=:kleding, idComp=:comp, naam=:naam";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->kleding=htmlspecialchars(strip_tags($this->kleding));
        $this->comp=htmlspecialchars(strip_tags($this->comp));
        $this->naam=htmlspecialchars(strip_tags($this->naam));
     
        // bind values
        $stmt->bindParam(":kleding", $this->kleding);
        $stmt->bindParam(":comp", $this->comp);
        $stmt->bindParam(":naam", $this->naam);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
}