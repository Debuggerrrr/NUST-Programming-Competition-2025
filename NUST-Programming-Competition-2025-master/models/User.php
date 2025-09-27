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
    public $title;
    public $profile_picture;
    public $created_at;
    public $updated_at;

    public function __construct() {
        $this->db = new Database();
    }

    public function getByUsername($username) {
        $sql = "SELECT user_id, username, password_hash, email, role, created_at, updated_at FROM users WHERE username = :username";
        $user = $this->db->fetch($sql, [':username' => $username]);
        
        if ($user) {
            $this->id = $user['user_id'] ?? null;
            $this->username = $user['username'] ?? null;
            $this->password_hash = $user['password_hash'] ?? null;
            $this->email = $user['email'] ?? null;
            $this->role = $user['role'] ?? null;
            $this->created_at = $user['created_at'] ?? null;
            $this->updated_at = $user['updated_at'] ?? null;
            
            // Get role-specific profile data
            $this->loadRoleSpecificData();
            
            return true;
        }
        return false;
    }

    public function getById($id) {
        $sql = "SELECT user_id, username, password_hash, email, role, created_at, updated_at FROM users WHERE user_id = :id";
        $user = $this->db->fetch($sql, [':id' => $id]);
        
        if ($user) {
            $this->id = $user['user_id'];
            $this->username = $user['username'];
            $this->password_hash = $user['password_hash'];
            $this->email = $user['email'];
            $this->role = $user['role'];
            $this->created_at = $user['created_at'];
            $this->updated_at = $user['updated_at'];
            
            // Get role-specific profile data
            $this->loadRoleSpecificData();
            
            return true;
        }
        return false;
    }

    public function create($data) {
        $sql = "INSERT INTO users (username, password_hash, email, role) 
                VALUES (:username, :password_hash, :email, :role)";
        
        $params = [
            ':username' => $data['username'],
            ':password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':email' => $data['email'],
            ':role' => $data['role']
        ];

        $result = $this->db->query($sql, $params);
        if ($result) {
            $this->id = $this->db->lastInsertId();
            return $this->getById($this->id);
        }
        return false;
    }
    
    private function loadRoleSpecificData() {
        if (!$this->id || !$this->role) {
            $this->first_name = null;
            $this->last_name = null;
            $this->title = null;
            $this->profile_picture = null;
            return;
        }
        
        $tableName = $this->role . 's';
        $sql = "SELECT first_name, last_name, title, profile_picture FROM {$tableName} WHERE user_id = :user_id";
        $profile = $this->db->fetch($sql, [':user_id' => $this->id]);
        
        if ($profile) {
            $this->first_name = $profile['first_name'] ?? null;
            $this->last_name = $profile['last_name'] ?? null;
            $this->title = $profile['title'] ?? null;
            $this->profile_picture = $profile['profile_picture'] ?? null;
        } else {
            $this->first_name = null;
            $this->last_name = null;
            $this->title = null;
            $this->profile_picture = null;
        }
    }

    public function toArray() {
        return [
            'id' => $this->id ?? null,
            'username' => $this->username ?? null,
            'email' => $this->email ?? null,
            'role' => $this->role ?? null,
            'first_name' => $this->first_name ?? null,
            'last_name' => $this->last_name ?? null,
            'created_at' => $this->created_at ?? null,
            'updated_at' => $this->updated_at ?? null
        ];
    }
    
    /**
     * Verify if the provided password matches the stored hash
     * 
     * @param string $password The password to verify
     * @return bool True if password matches, false otherwise
     */
    public function verifyPassword($password) {
        if (!$this->password_hash) {
            return false;
        }
        
        return password_verify($password, $this->password_hash);
    }
}
?>s