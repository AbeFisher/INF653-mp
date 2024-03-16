<?php 
  // author query
  $result = $author->read();

  // Get row count
  $num = $result->rowCount();

  // Check if any authors
  if($num > 0) {
    // author array
    $authors_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $author_item = array(
        'id' => $id,
        'author' => $author
      );

      // push author_item onto array
      array_push($authors_arr, $author_item);
    }

    // Turn to JSON & output
    echo json_encode($authors_arr);

  } else {
    // No Authors in db
    echo json_encode(
      array('message' => 'No Authors Found!')
    );

  }
