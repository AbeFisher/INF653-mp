<?php
  class Author {
    // DB Stuff
    private $cn;
    private $table = 'authors';

    // Properties
    public $id;
    public $author;

    // Constructor with DB
    public function __construct($db) {
      $this->cn = $db;
    }

    // READ ALL
    // --------------------------------------
    public function read() {
      // Create query
      $query = 'SELECT id, author
                FROM ' . $this->table . ' 
                ORDER BY author ASC';

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
        $query = 'SELECT id, author
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
          $this->author = $row['author'];  
        }
        else {
          $this->id = null;
          $this->author = null;
          echo json_encode(array('message' => 'author_id Not Found'));
        }
    }


    // CREATE NEW AUTHOR
    // --------------------------------------
    public function create() {
        // Create Query
        $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author) RETURNING id';

        // Prepare Statement
        $stmt = $this->cn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind data
        $stmt-> bindParam(':author', $this->author);

        // Execute query
        if($stmt->execute()) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          if ($row) {
            $author_ary = array(
              'id' => $row['id'],
              'author' => $this->author,
            );
            print_r(json_encode($author_ary));
          }
          return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }


    // UPDATE AUTHOR
    // --------------------------------------
    public function update() {
        // Create Query
        $query = 'UPDATE ' . $this->table . '
                  SET author = :author
                  WHERE id = :id';

        // Prepare Statement
        $stmt = $this->cn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt-> bindParam(':author', $this->author);
        $stmt-> bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            $author_ary = array(
              'id' => $this->id,
              'author' => $this->author,
            );
            print_r(json_encode($author_ary));

            return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }


    // DELETE AUTHOR
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
          $author_ary = array(
            'id' => $this->id
          );
          print_r(json_encode($author_ary));

        return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }

  }
