<?php 
    $id = getID();
    $quote->id = $id ? $id : die();

    // Get quote
    $quote->read_single();

    // Create array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'author_name' => $quote->author_name,
        'category_id' => $quote->category_id,
        'category_name' => $quote->category_name
    );

    // Make JSON
    print_r(json_encode($quote_arr));