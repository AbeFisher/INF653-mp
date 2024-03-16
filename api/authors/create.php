<?php 
    // Get raw author data
    $data = json_decode(file_get_contents("php://input"));
    $author->author = $data->author;
  
    // Create author
    if($author->create()) {
    echo json_encode(
        array('message' => 'Author Created')
    );
    } else {
    echo json_encode(
        array('message' => 'Author Not Created')
    );
    }
