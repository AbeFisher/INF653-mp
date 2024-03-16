<?php

    function GetID() {
    //  First, check if it is sent as part of the URL:
        if (isset($_GET['id'])) {
            return $_GET['id'];
        }
        else {
            //  If not part of the url, check to see if it is in the body data
            $data = json_decode(file_get_contents("php://input"));
            if ($data) {
                if ($data->id !== null) {
                    return $data->id;
                }
                else {
                    //  no id was sent
                    return null;
                }
            }
            return null;
        }
    }

    function validateData() {
        $valid = true;
        $msgAry = array();

        $data = json_decode(file_get_contents("php://input"));
        if (!$data) {
            $valid = false;
            array_push($msgAry, 'message', 'Missing Data.');
        }
        else {
            //  Validate ID
            if (!isset($data->id)) {
                array_push($msgAry, 'message', 'Missing data: ID is null.');
                $valid = false;
            }
            else if (!is_int($data->id)) {
                array_push($msgAry, 'message', 'Invalid data: ID must be an integer.');
                $valid = false;            
            }
    
            //  Validate author_id
            if (!isset($data->author_id)) {
                array_push($msgAry, 'message', 'Missing data: author_id is null.');
                $valid = false;
            }
            else if (!is_int($data->author_id)) {
                array_push($msgAry, 'message', 'Invalid data: author_id must be an integer.');
                $valid = false;            
            }
    
            //  Validate category_id
            if (!isset($data->category_id)) {
                array_push($msgAry, 'message', 'Missing data: category_id is null.');
                $valid = false;
            }
            else if (!is_int($data->category_id)) {
                array_push($msgAry, 'message', 'Invalid data: category_id must be an integer.');
                $valid = false;            
            }
    
            //  Validate quote
            if (!isset($data->quote)) {
                array_push($msgAry, 'message', 'Missing data: quote is null.');
                $valid = false;
            }
     
            if (count($msgAry) > 0) {
                echo json_encode($msgAry);
            }
            return $valid;
        }
    }