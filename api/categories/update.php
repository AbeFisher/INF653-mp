<?php 
  // Get raw category data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $category->id = $data->id;
  $category->category = $data->category;

  // Update category
  if(!$category->update()) {
    echo json_encode(array('message' => 'Category Not Updated'));
  }
