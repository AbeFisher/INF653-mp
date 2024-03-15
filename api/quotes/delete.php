<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Quote object
  $quote = new Quote($db);

  // Get raw quote data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to delete
  $quote->id = $data->id;

  // Delete quote
  if($quote->delete()) {
    echo json_encode(
      array('message' => 'Quote Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Quote Not Deleted')
    );
  }
