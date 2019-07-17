<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../data/standen.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$stand = new Stand($db);
 
// query products
$stmt = $stand->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $standen = array();
    $standen["records"] = array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $stand_gegevens = array(
            "id" => $id,
            "naam" => $naam,
            "gewonnen" => $gewonnen,
            "gelijk" => $gelijk,
            "verloren" => $verloren,
            "dpv" => $dpv,
            "dpt" => $dpt,
            "pnt" => (($gewonnen * 3) + $gelijk),
            "saldo" => ($dpv - $dpt),
            "gespeeld" => ($gewonnen + $gelijk + $verloren)
        );
 
        array_push($standen["records"], $stand_gegevens);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($standen);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "Geen standen gevonden.")
    );
}

?>