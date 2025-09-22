<?php
require_once 'Database.php';
require_once __DIR__ . '/../config/constants.php';

class User {
    private $db;

    public $id;
    public $username;
    public $password_hash;
    public $email;
    public $role;
    public $first_name;
    public $last_name;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $this->db = new Database();
    }

    public function getByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $user = $this->db->fetch($sql, [':username' => $username]);
        
        if ($user) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->password_hash = $user['password_hash'];
            $this->email = $user['email'];
            $this->role = $user['role'];
            $this->first_name = $user['first_name'];
            $this->last_name = $user['last_name'];
            $this->created_at = $user['created_at'];
            $this->updated_at = $user['updated_at'];
            return true;
        }
        return false;
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $user = $this->db->fetch($sql, [':id' => $id]);
        
        if ($user) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->password_hash = $user['password_hash'];
            $this->email = $user['email'];
            $this->role = $user['role'];
            $this->first_name = $user['first_name'];
            $this->last_name = $user['last_name'];
            $this->created_at = $user['created_at'];
            $this->updated_at = $user['updated_at'];
            return true;
        }
        return false;
    }

    public function create($data) {
        $sql = "INSERT INTO users (username, password_hash, email, role, first_name, last_name) 
                VALUES (:username, :password_hash, :email, :role, :first_name, :last_name)";
        
        $params = [
            ':username' => $data['username'],
            ':password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name']
        ];

        $result = $this->db->query($sql, $params);
        if ($result) {
            $this->id = $this->db->lastInsertId();
            return $this->getById($this->id);
        }
        return false;
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password_hash);
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
?>