<?php 
    // Get raw category data
    $data = json_decode(file_get_contents("php://input"));
    $category->category = $data->category;
  
    // Create category
    if(!$category->create()) {
        echo json_encode(array('message' => 'Category Not Created'));
    }
