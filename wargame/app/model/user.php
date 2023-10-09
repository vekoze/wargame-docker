<?php

require_once APP . "database.php";

class User
{

    private $id;
    private $username;
    private $email;
    private $password;
    private $role;

    public function __construct($id)
    {
        $database = Database::get_connection();

        $query = "SELECT * FROM Users WHERE id=:id LIMIT 1";
        $sql3_stmt = $database->prepare($query);
        $sql3_stmt->bindValue("id", $id);
        $result = $sql3_stmt->execute();
        $data = $result->fetchArray(SQLITE3_ASSOC);

        if ($data)
        {
            $this->id = $id;
            $this->username = $data["username"];
            $this->email = $data["email"];
            $this->password = $data["password"];
            $this->role = $this->fetch_role($database, $data["id_Role"]);
        }
        else
        {
            throw new Exception("User with ID {$id} not found.");
        }
    }

    public function get_id() { return $this->id; }
    public function get_username() { return $this->username; }
    public function get_email() { return $this->email; }
    public function get_password() { return $this->password; }
    
    public function get_role() { return $this->role; }
    public function is_admin() { return $this->get_role() == "Admin"; }
    public function is_superadmin() { return $this->get_role() == "SuperAdmin"; }

    // Private methods
    private function fetch_role($database, $role_id)
    {
        $query = "SELECT name FROM Roles WHERE id=:id LIMIT 1";
        $sql3_stmt = $database->prepare($query);
        $sql3_stmt->bindValue("id", $role_id);

        $result = $sql3_stmt->execute();
        $data = $result->fetchArray(SQLITE3_ASSOC);
        return $data["name"];
    }

    // Static methods
    public static function create($username, $email, $password)
    {
        $database = Database::get_connection();
        
        $query = "INSERT INTO Users (username, email, password) VALUES (:username, :email, :password)";
        $sql3_stmt = $database->prepare($query);
        $sql3_stmt->bindValue("username", $username);
        $sql3_stmt->bindValue("email", $email);
        $sql3_stmt->bindValue("password", $password);
        $sql3_stmt->execute();

        // Return the new user
        return new User($database->lastInsertRowID());
    }

    public static function get_from_username($username)
    {
        $database = Database::get_connection();

        $query = "SELECT id FROM Users WHERE username=:username LIMIT 1";
        $sql3_stmt = $database->prepare($query);
        $sql3_stmt->bindValue("username", $username);

        $result = $sql3_stmt->execute();
        $data = $result->fetchArray(SQLITE3_ASSOC);

        // Return the user if found, null otherwise
        return $data ? new User($data["id"]) : null;
    }

};

?>