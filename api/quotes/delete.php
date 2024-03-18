<?php 
   //  Set ID to delete
  $id = getID();
  $quote->id = $id ? $id : die();

   // Delete quote
  if(!$quote->delete()) {
    echo json_encode(array('message' => 'Quote Not Deleted'));
  }
