<?php
  class Category {
    // DB Stuff
    private $cn;
    private $table = 'categories';

    // Properties
    public $id;
    public $category;

    // Constructor with DB
    public function __construct($db) {
      $this->cn = $db;
    }

    // READ ALL
    // --------------------------------------
    public function read() {
      // Create query
      $query = 'SELECT id, category
                FROM ' . $this->table . '
                ORDER BY category ASC';

      // Prepare statement
      $stmt = $this->cn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // READ SINGLE
    // --------------------------------------
    public function read_single(){
        // Create query
        $query = 'SELECT id, category
                FROM ' . $this->table . '
                WHERE id = :id
                LIMIT 1';

        //Prepare statement
        $stmt = $this->cn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        if ($row) {
          $this->id = $row['id'];
          $this->category = $row['category'];  
        }
        else {
          $this->id = null;
          $this->category = null;
          echo json_encode(array("message" => "category_id Not Found"));
        }
        
    }


    // CREATE NEW CATEGORY
    // --------------------------------------
    public function create() {
        // Create Query
        $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category) RETURNING id';

        // Prepare Statement
        $stmt = $this->cn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind data
        $stmt-> bindParam(':category', $this->category);

        // Execute query
        if($stmt->execute()) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          if ($row) {
            $category_ary = array(
              'id' => $row['id'],
              'category' => $this->category,
            );
            print_r(json_encode($category_ary));
          }
          return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }


    // UPDATE CATEGORY
    // --------------------------------------
    public function update() {
        // Create Query
        $query = 'UPDATE ' . $this->table . '
                  SET category = :category
                  WHERE id = :id';

        // Prepare Statement
        $stmt = $this->cn->prepare($query);

        // Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt-> bindParam(':category', $this->category);
        $stmt-> bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            $category_ary = array(
              'id' => $this->id,
              'category' => $this->category,
            );
            print_r(json_encode($category_ary));

            return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }


    // DELETE CATEGORY
    // --------------------------------------
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare Statement
        $stmt = $this->cn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $stmt-> bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
          $category_ary = array(
            'id' => $this->id
          );
          print_r(json_encode($category_ary));

        return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }

  }
