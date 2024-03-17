<?php 
   //  Set ID to delete
  $id = getID();
  $category->id = $id ? $id : die();

   // Delete category
  if($category->delete()) {
    // echo json_encode(
    //   array('message' => 'Category Deleted')
    // );
  } else {
    echo json_encode(
      array('message' => 'Category Not Deleted')
    );
  }
