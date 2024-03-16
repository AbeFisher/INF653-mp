<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';  
    include_once '../../Utilities/getID.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    switch ($method) {
        case 'GET':
            if (getID()) { require 'read_single.php'; }
            else { require 'read.php'; }
            break;

        case 'PUT':
            require 'update.php';
            break;

        case 'POST':
            require 'create.php';
            break;

        case 'DELETE':
            require 'delete.php';
            break;

        case 'OPTIONS':
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
            header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
            exit();
            break;
    }
