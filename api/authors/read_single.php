<?php 
    $id = getID();
    $author->id = $id ? $id : die();

    // Get author
    $author->read_single();

    // Create array, if we get back good data
    if (!is_null($author->id) and !is_null($author->author)) {
        $author_arr = array(
            'id' => $author->id,
            'author' => $author->author
        );

        // Make JSON
        print_r(json_encode($author_arr));            
    }
