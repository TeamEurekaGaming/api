<?php
class Stand{
 
    // database connection and table name
    private $conn;
    private $table_name = "standen";
 
    // object properties
    public $id;
    public $naam;
    public $gespeeld;
    public $gewonnen;
    public $gelijk;
    public $verloren;
    public $punten;
    public $dpv;
    public $dpt;
    public $saldo;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
     
        // select all query
        $query = "SELECT teams.idComp AS id, teams.naam AS naam, gewonnen, gelijk, verloren, dpv, dpt 
        FROM " . $this->table_name . " LEFT JOIN teams ON standen.idTeam = teams.id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }  
}
