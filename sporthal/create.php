<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate product object
include_once '../data/sporthallen.php';
 
$database = new Database();
$db = $database->getConnection();
 
$sporthal = new Sporthal($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->naam) &&
    !empty($data->adres)  &&
    !empty($data->postcode)    &&
    !empty($data->woonplaats)    &&
    !empty($data->telefoon)
){
 
    // set product property values
    $sporthal->naam = $data->naam;
    $sporthal->adres = $data->adres;
    $sporthal->postcode = $data->postcode;
    $sporthal->woonplaats = $data->woonplaats;
    $sporthal->telefoon = $data->telefoon;
 
    // create the product
    if($sporthal->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Sporthal is toegevoegd."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Kan geen sporthal toevoegen. Geen verbinding."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Kan geen sporthal toevoegen. Gegevens zijn niet compleet."));
}
?>