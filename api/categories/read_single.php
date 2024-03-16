<?php 
    $id = getID();

    $category->id = $id ? $id : die();

    // Get category
    $category->read_single();

    // Create array, if we get back good data
    if (!is_null($category->id) and !is_null($category->category)) {
        $category_arr = array(
            'id' => $category->id,
            'category' => $category->category
        );

        // Make JSON
        print_r(json_encode($category_arr));            
    }
