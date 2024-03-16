<?php 
   //  Set ID to delete
  $id = getID();
  $author->id = $id ? $id : die();

   // Delete author
  if($author->delete()) {
    echo json_encode(
      array('message' => 'Author Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Author Not Deleted')
    );
  }
