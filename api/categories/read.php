<?php 
  // category query
  $result = $category->read();

  // Get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0) {
    // category array
    $categories_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $category_item = array(
        'id' => $id,
        'category' => $category
      );

      // push category_item onto array
      array_push($categories_arr, $category_item);
    }

    // Turn to JSON & output
    echo json_encode($categories_arr);

  } else {
    // No Categories in db
    echo json_encode(
      array('message' => 'No Categories Found!')
    );

  }
