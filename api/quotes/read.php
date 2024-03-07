<?php 
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate quote object
  $quote = new Quote($db);

  // quote query
  $result = $quote->read();

  // Get row count
  $num = $result->rowCount();

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
