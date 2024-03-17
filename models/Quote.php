<?php
  class Quote {
    // DB Stuff
    private $cn;
    private $table = 'quotes';

    // Properties
    public $id;
    public $quote;
    public $author_id;
    public $author_name;
    public $category_id;
    public $category_name;
    
    // Constructor with DB
    public function __construct($db) {
        $this->cn = $db;
    }

    // READ ALL
    // --------------------------------------
    public function read() {
      // Create query
      $query = "SELECT
                  c.category as category_name,
                  a.author as author_name,
                  q.id, q.quote, q.author_id, q.category_id
                FROM " . $this->table . " q
                  LEFT JOIN categories c ON q.category_id = c.id
                  LEFT JOIN authors a ON q.author_id = a.id
                ORDER BY id ASC";

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
        $query = 'SELECT
                    c.category as category_name,
                    a.author as author_name,
                    q.id, q.quote, q.author_id, q.category_id
                  FROM ' . $this->table . ' q
                    LEFT JOIN categories c ON q.category_id = c.id
                    LEFT JOIN authors a ON q.author_id = a.id
                  WHERE q.id = :id
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
          $this->quote = $row['quote'];
          $this->author_id = $row['author_id'];
          $this->author_name = $row['author_name'];
          $this->category_id = $row['category_id'];
          $this->category_name = $row['category_name'];  
        }
        else {
          $this->id = null;
          $this->quote = null;
          $this->author_id = null;
          $this->author_name = null;
          $this->category_id = null;
          $this->category_name = null;
          echo json_encode(array("message" => "No Quotes Found"));          
        }        
    }

    // CREATE NEW QUOTE
    // --------------------------------------
    public function create() {
        // Create Query
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) 
                  VALUES (:quote, :author_id, :category_id) RETURNING id';

        // Prepare Statement
        $stmt = $this->cn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind data
        $stmt-> bindParam(':quote', $this->quote);
        $stmt-> bindParam(':author_id', $this->author_id);
        $stmt-> bindParam(':category_id', $this->category_id);

        // Execute query
        if($stmt->execute()) {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
            $quote_ary = array(
              'id' => $row['id'],
              'quote' => $this->quote,
              'author_id' => $this->author_id,
              'category_id' => $this->category_id
            );
            print_r(json_encode($quote_ary));
          }

          return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }


    // UPDATE QUOTE
    // --------------------------------------
    public function update() {
        // Create Query
        $query = 'UPDATE ' . $this->table . '
                  SET
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id
                  WHERE id = :id';

        // Prepare Statement
        $stmt = $this->cn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind data
        $stmt-> bindParam(':id', $this->id);
        $stmt-> bindParam(':quote', $this->quote);
        $stmt-> bindParam(':author_id', $this->author_id);
        $stmt-> bindParam(':category_id', $this->category_id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }


    // DELETE QUOTE
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
        return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }

  }
