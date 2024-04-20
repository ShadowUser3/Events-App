<?php
class Event {
    private $conn;
    private $table = 'Event';

    public $EventID;
    public $Title;
    public $Date;
    public $Time;
    public $Location;
    public $Description;
    public $AverageRating;
    public $AdminID;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = 'SELECT * FROM ' . $this->table ;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //Read a single Event
    public function read() {
        $query = 'SELECT * 
        FROM
            ' . $this->table . '
        WHERE 
            EventID = ?
        LIMIT 0,1';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->EventID);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        $this->Title = $row['Title'];
        $this->Date = $row['Date'];
        $this->Time = $row['Time'];
        $this->Location = $row['Location'];
        $this->Description = $row['Description'];
        $this->AverageRating = $row['AverageRating'];
        $this->AdminID = $row['AdminID'];
    }

    //Create Event
    public function create() {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
            AdminID = :adminID,
            Title = :title,
            Date = :date,
            Time = :time,
            Location = :location,
            Description = :description';
            
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean Data
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->Date = htmlspecialchars(strip_tags($this->Date));
        $this->Time = htmlspecialchars(strip_tags($this->Time));
        $this->Location = htmlspecialchars(strip_tags($this->Location));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->AdminID = htmlspecialchars(strip_tags($this->AdminID));

        //Bind Data
        $stmt->bindParam(':title', $this->Title);
        $stmt->bindParam(':date', $this->Date);
        $stmt->bindParam(':time', $this->Time);
        $stmt->bindParam(':location', $this->Location);
        $stmt->bindParam(':description', $this->Description);
        $stmt->bindParam(':adminID', $this->AdminID);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //print error msg if any
        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

    //Update Event
    public function update() {
        //create query
        $query = 'UPDATE ' . $this->table . '
        SET
            AdminID = :adminID,
            Title = :title,
            Date = :date,
            Time = :time,
            Location = :location,
            Description = :description
        WHERE
            EventID = :EventID';
            
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean Data
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->Date = htmlspecialchars(strip_tags($this->Date));
        $this->Time = htmlspecialchars(strip_tags($this->Time));
        $this->Location = htmlspecialchars(strip_tags($this->Location));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->AdminID = htmlspecialchars(strip_tags($this->AdminID));
        $this->EventID = htmlspecialchars(strip_tags($this->EventID));

        //Bind Data
        $stmt->bindParam(':title', $this->Title);
        $stmt->bindParam(':date', $this->Date);
        $stmt->bindParam(':time', $this->Time);
        $stmt->bindParam(':location', $this->Location);
        $stmt->bindParam(':description', $this->Description);
        $stmt->bindParam(':adminID', $this->AdminID);
        $stmt->bindParam(':EventID', $this->EventID);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //print error msg if any
        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

    // Delete Event
    public function delete() {
        //Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE EventID = :EventID';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean ID
        $this->EventID = htmlspecialchars(strip_tags($this->EventID));

        //Bind ID
        $stmt->bindParam(':EventID', $this->EventID);

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //print error msg if any
        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }
}