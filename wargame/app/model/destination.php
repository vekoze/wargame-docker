<?php

require_once APP . "database.php";

class Destination
{

    private $id;
    private $title;
    private $description;
    private $images = [];
    private $reviews = [];
    private $rating = 0;
    private $imagepath;

    public function __construct($id)
    {
        $database = Database::get_connection();

        $query = "SELECT * FROM Destinations WHERE id=:id LIMIT 1";
        $sql3_stmt = $database->prepare($query);
        $sql3_stmt->bindValue("id", $id);
        
        $result = $sql3_stmt->execute();
        $data = $result->fetchArray(SQLITE3_ASSOC);

        if ($data)
        {
            $this->id = $id;
            $this->title = $data["title"];
            $this->description = $data["description"];
            $this->images = $this->fetch_images($database);

            $this->update_reviews();
        }
        else
        {
            throw new Exception("Destination with ID {$id} not found.");
        }
    }

    public function get_id() { return $this->id; }
    public function get_title() { return $this->title; }
    public function get_description() { return $this->description; }
    public function get_reviews() { return $this->reviews; }
    public function get_rating() { return $this->rating; }
    public function get_images() { return $this->images;}

    public function update_reviews()
    {
        $database = Database::get_connection();

        $this->reviews = $this->fetch_reviews($database);

        $this->rating = 0;
        foreach ($this->reviews as $review)
        {
            $this->rating += $review["rating"];
        }

        if (count($this->reviews) == 0)
        {
            $this->rating = 5;
        }
        else
        {
            $this->rating /= count($this->reviews);
            $this->rating = round($this->rating);
        }
        
    }

    public function add_review($user_id, $comment, $rating)
    {
        $database = Database::get_connection();

        $query = "INSERT INTO Reviews (comment, rating, id_User, id_Destination) VALUES (:comment, :rating, :id_User, :id_Destination)";
        $sql3_stmt = $database->prepare($query);
        $sql3_stmt->bindValue("comment", $comment);
        $sql3_stmt->bindValue("rating", $rating);
        $sql3_stmt->bindValue("id_User", $user_id);
        $sql3_stmt->bindValue("id_Destination", $this->id);

        $sql3_stmt->execute();
    }

    // Private methods
    private function fetch_reviews($database)
    {
        $query = "SELECT * FROM Reviews WHERE id_Destination=:id_Destination";
        $sql3_stmt = $database->prepare($query);
        $sql3_stmt->bindValue("id_Destination", $this->id);

        $result = $sql3_stmt->execute();

        $reviews = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            $reviews[] = $row;
        }
        return $reviews;
    }

    private function fetch_images($database)
    {
        $query = "SELECT * FROM Images WHERE id_Destination=:id_Destination";
        $sql3_stmt = $database->prepare($query);
        $sql3_stmt->bindValue("id_Destination", $this->id);

        $result = $sql3_stmt->execute();

        $images = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            $images[] = $row;
        }
        return $images;
    }

    // Static methods
    public static function get_destinations()
    {
        $database = Database::get_connection();

        $query = "SELECT * FROM Destinations";
        $sql3_stmt = $database->prepare($query);
        $result = $sql3_stmt->execute();

        $destinations = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
        {
            $destinations[] = new Destination($row["id"]);
        }
        return $destinations;
    }


    public static function get_rating_stars($rating)
    {
        $max_stars = 5;
        $full_count = floor($rating);

        $full_str = str_repeat("<span class='text-warning'>★</span>", $full_count);
        $empty_str = str_repeat("<span class='text-secondary'>★</span>", $max_stars - $full_count);

        return  "<div>{$full_str}{$empty_str}</div>";
    }

};

?>