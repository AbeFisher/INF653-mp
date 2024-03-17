<?php 
    // Get raw quote data
    $data = json_decode(file_get_contents("php://input"));

    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Create quote
    if($quote->create()) {
        //  return JSON object with new quote data
        // $quote->read_single();
        // $quote_ary = array(
        //     'id' => $quote->id,
        //     'quote' => $quote->quote,
        //     'author' => $quote->author_name,
        //     'category' => $quote->category_name
        // );
        // print_r(json_encode($quote_ary));
    } else {
        echo json_encode(array('message' => 'Quote Not Created')
    );
    }

