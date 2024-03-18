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
            echo json_encode(array('message' => 'Missing Required Parameters'));
            exit();
        }
        else {
            //  Validate ID
            $valid = validateID($method);

            //  Validate author_id:
            $result = Get_Author($data->id);
            if (!$result->rowCount()) {
                echo json_encode(array('message' => 'author_id Not Found'));
                exit();
            }

            // //  Validate author_id
            // if (!isset($data->author_id)) {
            //     echo json_encode(array('message' => 'author_id Not Found'));
            //     exit();
            // }
            // else if (!is_int($data->author_id)) {
            //     echo json_encode(array('message' => 'Invalid data: author_id must be an integer'));
            //     exit();
            // }

            //  Validate category_id:
            $result = Get_Category($data->id);
            if (!$result->rowCount()) {
                echo json_encode(array('message' => 'category_id Not Found'));
                exit();
            }            
            
            // //  Validate category_id
            // if (!isset($data->category_id)) {
            //     echo json_encode(array('message' => 'category_id Not Found'));
            //     exit();
            // }
            // else if (!is_int($data->category_id)) {
            //     echo json_encode(array('message' => 'Invalid data: category_id must be an integer'));
            //     exit();
            // }
    
            //  Validate parameters
            if (!isset($data->id) or !isset($data->quote) or 
                !isset($data->author_id) or !isset($data->category_id)) {
                echo json_encode(array('message' => 'Missing Required Parameters'));
                exit();
            }

        }
     
        // if (count($msgAry) > 0) {
        //     echo json_encode($msgAry);
        // }

        return $valid;
    }

    function validateAuthorData($method) {
        $valid = true;
        $msgAry = array();

        $data = json_decode(file_get_contents("php://input"));

        if (!$data) {
            echo json_encode(array("message" => "Missing Required Parameters"));
            exit();
        }
        else {
            //  Validate ID
            $valid = validateID($method);
        
            //  Validate author name
            if (!isset($data->author)) {
                echo json_encode(array("message" => "Missing Required Parameters"));
                exit();
                }
        }
     
        // if (count($msgAry) > 0) {
        //     echo json_encode($msgAry);
        // }

        return $valid;
    }

    function validateCategoryData($method) {
        $valid = true;
        $msgAry = array();

        $data = json_decode(file_get_contents("php://input"));
        if (!$data) {
            echo json_encode(array("message" => "Missing Required Parameters"));
            exit();
        }
        else {
            //  Validate ID
            $valid = validateID($method);
        
            //  Validate catgegory name
            if (!isset($data->category)) {
                echo json_encode(array("message" => "Missing Required Parameters"));
                exit();
                }
        }

        // if (count($msgAry) > 0) {
        //     echo json_encode($msgAry);
        // }

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

    function Get_Author($id){
        // Create query
        $query = 'SELECT * from authors where id = :id';

        //Prepare statement
        $stmt = $this->cn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $id);

        // Execute query
        $stmt->execute();
        
        //  Return query results
        return $stmt;
    }

    function Get_Category($id){
        // Create query
        $query = 'SELECT * from categories where id = :id';

        //Prepare statement
        $stmt = $this->cn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $id);

        // Execute query
        $stmt->execute();
        
        //  Return query results
        return $stmt;
    }
