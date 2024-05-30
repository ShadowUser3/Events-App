<?php
class User {
    private $conn;
    private $table = 'User';

    public $UserID;
    public $Password;
    public $Name;
    public $Email;
    public $Role;
    public $ProfilePic;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * 
        FROM
            ' . $this->table . '
        WHERE 
            UserID = ?
        LIMIT 0,1';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->UserID);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $this->UserID = $row['UserID'];
            $this->Password = $row['Password'];
            $this->Name = $row['Name'];
            $this->Email = $row['Email'];
            $this->Role = $row['Role'];
            $this->ProfilePic = $row['ProfilePic'];
        } else {
            // Set appropriate error message or response
            die(json_encode(array('message' => 'User not found.')));
        }
    }

    public function getInterestedEvents() {
        $query = 'SELECT e.* 
        FROM
            Event e
        INNER JOIN
            interestedevent i ON e.EventID = i.EventID
        WHERE
            i.UserID = ?';
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->UserID);
        $stmt->execute();
    
        $events = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = array(
                'EventID' => $row['EventID'],
                'Title' => $row['Title'],
                'Location' => $row['Location'],
                'Description' => $row['Description'],
                'AverageRating' => $row['AverageRating'],
                'Category' => $row['Category'],
                'CoverPicture' => $row['CoverPicture'],
                'DateTime' => $row['DateTime'],
                'Duration' => $row['Duration'],
                'Interested' => $row['Interested'],
                'Going' => $row['Going'],
                'Organizer' => $row['Organizer'],
                'LocationLink' => $row['LocationLink']
            );
    
            $events[] = $event;
        }
    
        return $events;
    }
    
    public function getGoingEvents() {
        $query = 'SELECT e.* 
        FROM
            Event e
        INNER JOIN
            goingevent g ON e.EventID = g.EventID
        WHERE
            g.UserID = ?';
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->UserID);
        $stmt->execute();
    
        $events = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = array(
                'EventID' => $row['EventID'],
                'Title' => $row['Title'],
                'Location' => $row['Location'],
                'Description' => $row['Description'],
                'AverageRating' => $row['AverageRating'],
                'Category' => $row['Category'],
                'CoverPicture' => $row['CoverPicture'],
                'DateTime' => $row['DateTime'],
                'Duration' => $row['Duration'],
                'Interested' => $row['Interested'],
                'Going' => $row['Going'],
                'Organizer' => $row['Organizer'],
                'LocationLink' => $row['LocationLink']
            );
    
            $events[] = $event;
        }
    
        return $events;
    }

    public function login() {
        // Select user by UserID
        $query = "SELECT * FROM User WHERE UserID = :userID";
    
        // Prepare the query
        $stmt = $this->conn->prepare($query);
    
        // Bind the parameter
        $stmt->bindParam(':userID', $this->UserID);
    
        // Execute the query
        $stmt->execute();
    
        // Check if the user exists
        if ($stmt->rowCount() > 0) {
            // Retrieve the user details
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retrieve the stored password
            $storedPassword = $row['Password'];

            // Compare the entered password with the stored password directly
            if ($this->Password === $storedPassword) {
                return true;
            }
    
            // Verify the password
            /*if (password_verify($this->Password, $row['Password'])) {
                // Password is correct, set the user ID
                $this->UserID = $row['UserID'];
    
                return true;
            }*/
        }
    
        return false;
    }

    public function logout() {
        session_start();
        session_destroy();
        return true;
    }

   public function getUserRatings() {
        // Get user's rated events
        $query = "SELECT f.Rating, e.Title AS EventTitle FROM Feedback f
              INNER JOIN Event e ON f.EventID = e.EventID
              WHERE f.UserID = :userID";
    
        // Prepare the query
        $stmt = $this->conn->prepare($query);
    
        // Bind the parameter
        $stmt->bindParam(':userID', $this->UserID);
    
        // Execute the query
        $stmt->execute();
    
        // Fetch the results
        $ratings = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rating_item = array(
                "Rating" => $row['Rating'],
                "EventTitle" => $row['EventTitle']
            );
            $ratings[] = $rating_item;
        }
    
        return $ratings;
    }
}