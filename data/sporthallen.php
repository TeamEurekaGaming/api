<?php
class Sporthal{
 
    // database connection and table name
    private $conn;
    private $table_name = "sporthallen";
 
    // object properties
    public $id;
    public $naam;
    public $adres;
    public $postcode;
    public $woonplaats;
    public $telefoon;

 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
     
        // select all query
        $query = "SELECT id, naam, adres, postcode, woonplaats, telefoon
                    FROM " . $this->table_name . "
                    ORDER BY id DESC";
     
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
                    naam=:naam, adres=:adres, postcode=:postcode, woonplaats=:woonplaats, telefoon=:telefoon";
     
        // prepare query
        $stmt = $this->conn->prepare($query);
     
        // sanitize
        $this->naam=htmlspecialchars(strip_tags($this->naam));
        $this->adres=htmlspecialchars(strip_tags($this->adres));
        $this->postcode=htmlspecialchars(strip_tags($this->postcode));
        $this->woonplaats=htmlspecialchars(strip_tags($this->woonplaats));
        $this->telefoon=htmlspecialchars(strip_tags($this->telefoon));
     
        // bind values
        $stmt->bindParam(":naam", $this->naam);
        $stmt->bindParam(":adres", $this->adres);
        $stmt->bindParam(":postcode", $this->postcode);
        $stmt->bindParam(":woonplaats", $this->woonplaats);
        $stmt->bindParam(":telefoon", $this->telefoon);
     
        // execute query
        if($stmt->execute()){
            return true;
        }
     
        return false;
         
    }
}