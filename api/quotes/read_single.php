<?php 
    $id = getID();
    $quote->id = $id ? $id : die();

    // Get quote
    $quote->read_single();

    // Create array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author_name,
        'category' => $quote->category_name
    );

    // Make JSON
    print_r(json_encode($quote_arr));