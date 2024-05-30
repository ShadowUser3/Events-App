<?php
class Event {
    private $conn;
    private $table = 'Event';

    public $EventID;
    public $Title;
    public $Location;
    public $Description;
    public $AverageRating;
    public $Category;
    public $CoverPicture;
    public $DateTime;
    public $Duration;
    public $Interested;
    public $Going;
    public $Organizer;
    public $LocationLink;

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

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $this->Title = $row['Title'];
            $this->Location = $row['Location'];
            $this->Description = $row['Description'];
            $this->AverageRating = $row['AverageRating'];
            $this->Category = $row['Category'];
            $this->CoverPicture = $row['CoverPicture'];
            $this->DateTime = $row['DateTime'];
            $this->Duration = $row['Duration'];
            $this->Interested = $row['Interested'];
            $this->Going = $row['Going'];
            $this->Organizer = $row['Organizer'];
            $this->LocationLink = $row['LocationLink'];
        } else {
            // Set appropriate error message or response
            die(json_encode(array('message' => 'Event not found.')));
        }
    }

    //get Images frm the Gallery
    public function getGalleryImages($eventID) {
        // Check if the event exists in the database
        if (!$this->eventExists($eventID)) {
            return null;
        }
    
        $query = 'SELECT ImageURL FROM eventgallery WHERE EventID = ?';
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $eventID);
        $stmt->execute();
    
        $gallery = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $gallery;
    }

    //Create Event
    public function create() {
        //create query
        $query = 'INSERT INTO ' . $this->table . '
        SET
            Title = :title,
            Location = :location,
            Description = :description,
            AverageRating = :rate,
            Category = :category,
            CoverPicture = :cover,
            DateTime = :datetime,
            Duration = :duration,
            Interested = :interested,
            Going = :going,
            Organizer = :organizer,
            LocationLink = :locationlink';
            
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean Data
        $this->Title = htmlspecialchars(strip_tags($this->Title));
        $this->Location = htmlspecialchars(strip_tags($this->Location));
        $this->Description = htmlspecialchars(strip_tags($this->Description));
        $this->AverageRating = htmlspecialchars(strip_tags($this->AverageRating));
        $this->Category = htmlspecialchars(strip_tags($this->Category));
        $this->CoverPicture = htmlspecialchars(strip_tags($this->CoverPicture));
        $this->DateTime = htmlspecialchars(strip_tags($this->DateTime));
        $this->Duration = htmlspecialchars(strip_tags($this->Duration));
        $this->Interested = htmlspecialchars(strip_tags($this->Interested));
        $this->Going = htmlspecialchars(strip_tags($this->Going));
        $this->Organizer = htmlspecialchars(strip_tags($this->Organizer));
        $this->LocationLink = htmlspecialchars(strip_tags($this->LocationLink));

        //Bind Data
        $stmt->bindParam(':title', $this->Title);
        $stmt->bindParam(':location', $this->Location);
        $stmt->bindParam(':description', $this->Description);
        $stmt->bindParam(':rate', $this->AverageRating);
        $stmt->bindParam(':category', $this->Category);
        $stmt->bindParam(':cover', $this->CoverPicture);
        $stmt->bindParam(':datetime', $this->DateTime);
        $stmt->bindParam(':duration', $this->Duration);
        $stmt->bindParam(':interested', $this->Interested);
        $stmt->bindParam(':going', $this->Going);
        $stmt->bindParam(':organizer', $this->Organizer);
        $stmt->bindParam(':locationlink', $this->LocationLink);

        

        //Execute query
        if($stmt->execute()) {
            return true;
        }

        //print error msg if any
        printf("Error: %s.\n", $stmt->error);
        
        return false;
    }

    // Update Average Rating
    public function updateAverageRating() {
         // Check if the event exists
         if (!$this->eventExists($this->EventID)) {
            return false;
        }
    
        $query = 'UPDATE ' . $this->table . '
        SET AverageRating = :rate
        WHERE EventID = :EventID';
    
        $stmt = $this->conn->prepare($query);
    
        $this->EventID = htmlspecialchars(strip_tags($this->EventID));
        $this->AverageRating = htmlspecialchars(strip_tags($this->AverageRating));
    
        $stmt->bindParam(':EventID', $this->EventID);
        $stmt->bindParam(':rate', $this->AverageRating);
    
        if ($stmt->execute()) {
            return true;
        }
    
        printf("Error: %s.\n", $stmt->error);
    
        return false;
    }
    
    // Update Interested
    public function updateInterested() {
         // Check if the event exists
         if (!$this->eventExists($this->EventID)) {
            return false;
        }
    
        $query = 'UPDATE ' . $this->table . '
        SET Interested = :interested
        WHERE EventID = :EventID';
    
        $stmt = $this->conn->prepare($query);
    
        $this->EventID = htmlspecialchars(strip_tags($this->EventID));
        $this->Interested = htmlspecialchars(strip_tags($this->Interested));
    
        $stmt->bindParam(':EventID', $this->EventID);
        $stmt->bindParam(':interested', $this->Interested);
    
        if ($stmt->execute()) {
            return true;
        }
    
        printf("Error: %s.\n", $stmt->error);
    
        return false;
    }
    
    // Update Going
    public function updateGoing() {
         // Check if the event exists
         if (!$this->eventExists($this->EventID)) {
            return false;
        }
    
        $query = 'UPDATE ' . $this->table . '
        SET Going = :going
        WHERE EventID = :EventID';
    
        $stmt = $this->conn->prepare($query);
    
        $this->EventID = htmlspecialchars(strip_tags($this->EventID));
        $this->Going = htmlspecialchars(strip_tags($this->Going));
    
        $stmt->bindParam(':EventID', $this->EventID);
        $stmt->bindParam(':going', $this->Going);
    
        if ($stmt->execute()) {
            return true;
        }
    
        printf("Error: %s.\n", $stmt->error);
    
        return false;
    }
    
    private function eventExists($eventID) {
        $query = 'SELECT EventID FROM ' . $this->table . ' WHERE EventID = :EventID';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':EventID', $eventID);
        $stmt->execute();
    
        return $stmt->rowCount() > 0;
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