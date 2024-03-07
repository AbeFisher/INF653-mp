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

  echo "\nIn 'read.php':  header section completed.";

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  echo "\n\nDatabase creation succeeded.\n";
  echo var_dump($db);

  // Instantiate quote object
  $quote = new Quote($db);

  echo "\n\nQuote object created.\n";
  echo var_dump($quote);

  // quote query
  $result = $quote->read();

  echo "\n\nRead results received.\n";
  echo var_dump($result);

  // Get row count
  $num = $result->rowCount();

  echo "\n\nData rows retrieved:\n";
  echo $num;

  // Check if any quotes
  if($num > 0) {
    // quote array
    $quotes_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $quote_item = array(
        'id' => $id,
        'author_id' => $author_id,
        'author_name' => $author_name,
        'category_id' => $category_id,
        'category_name' => $category_name
      );

      // push quote_item onto array
      array_push($quotes_arr, $quote_item);
    }

    // Turn to JSON & output
    echo json_encode($quotes_arr);

  } else {
    // No Quotes in db
    echo json_encode(
      array('message' => 'No Quotes Found!')
    );

  }
