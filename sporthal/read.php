<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../data/sporthallen.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$sporthal = new Sporthal($db);
 
// query products
$stmt = $sporthal->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $sporthallen = array();
    $sporthallen["records"] = array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $hal_gegevens = array(
            "naam" => $naam,
            "adres" => $adres,
            "postcode" => $postcode,
            "woonplaats" => $woonplaats,
            "telefoon" => $telefoon
        );
 
        array_push($sporthallen["records"], $hal_gegevens);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($sporthallen);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "Geen sporthallen gevonden.")
    );
}


?>