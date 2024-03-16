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
                if (isset($data->id)) {
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

    function validateQuoteData($method) {
        $valid = true;
        $msgAry = array();

        $data = json_decode(file_get_contents("php://input"));
        if (!$data) {
            $valid = false;
            array_push($msgAry, 'ValidateQuoteData', 'Missing or improperly formatted Data.');
        }
        else {
            //  Validate ID
            $valid = validateID($method);

            //  Validate author_id
            if (!isset($data->author_id)) {
                array_push($msgAry, 'ValidateQuoteData', 'Missing data: author_id is null.');
                $valid = false;
            }
            else if (!is_int($data->author_id)) {
                array_push($msgAry, 'ValidateQuoteData', 'Invalid data: author_id must be an integer.');
                $valid = false;            
            }
    
            //  Validate category_id
            if (!isset($data->category_id)) {
                array_push($msgAry, 'ValidateQuoteData', 'Missing data: category_id is null.');
                $valid = false;
            }
            else if (!is_int($data->category_id)) {
                array_push($msgAry, 'ValidateQuoteData', 'Invalid data: category_id must be an integer.');
                $valid = false;            
            }
    
            //  Validate quote
            if (!isset($data->quote)) {
                array_push($msgAry, 'ValidateQuoteData', 'Missing data: quote is null.');
                $valid = false;
            }
        }
     
        if (count($msgAry) > 0) {
            echo json_encode($msgAry);
        }
        return $valid;
    }

    function validateAuthorData($method) {
        $valid = true;
        $msgAry = array();

        $data = json_decode(file_get_contents("php://input"));

        if (!$data) {
            $valid = false;
            array_push($msgAry, 'ValidateAuthorData', 'Missing or improperly formatted Data.');
        }
        else {
            //  Validate ID
            $valid = validateID($method);
        
            //  Validate author name
            if (!isset($data->author)) {
                array_push($msgAry, 'ValidateAuthorData', 'Missing data: author is null.');
                $valid = false;
            }
        }
     
        if (count($msgAry) > 0) {
            echo json_encode($msgAry);
        }
        return $valid;
    }

    function validateCategoryData($method) {
        $valid = true;
        $msgAry = array();

        $data = json_decode(file_get_contents("php://input"));
        if (!$data) {
            $valid = false;
            array_push($msgAry, 'ValidateCategoryData', 'Missing or improperly formatted Data.');
        }
        else {
            //  Validate ID
            $valid = validateID($method);
        
            //  Validate catgegory name
            if (!isset($data->category)) {
                array_push($msgAry, 'ValidateCategoryData', 'Missing data: category is null.');
                $valid = false;
            }
        }

        if (count($msgAry) > 0) {
            echo json_encode($msgAry);
        }
        return $valid;
    }

    function validateID($method) {
        $id = GetID();

        //  Don't need to validate ID if it is a POST operation:
        //  autoincrement supplies ID
        if ($method === 'POST') { return true; }

        if (!$id) {
            echo json_encode(array('ValidateID' => 'Missing data: ID is null.'));
            return false;
        }
        else {
            if (!is_int($id) and (!is_numeric($id) or !ctype_digit($id))) {    
                echo json_encode(array('ValidateID' => 'Invalid data: ID must be an integer.'));
                return false;
            }
        }

        return true;
    }