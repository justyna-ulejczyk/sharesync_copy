<?php
use PHPUnit\Framework\TestCase;

// Mock Database class
class Database {
    public function execute($username) {
        // Simulate database query based on username
        if ($username === 'existing_user') {
            return [['password' => password_hash('correct_password', PASSWORD_DEFAULT)]];
        } else {
            return [];
        }
    }
}

// Class to be tested
class LoginService {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function handleLogin($username, $password) {
        $result = $this->db->execute($username);

        if (count($result) == 0) {
            return 'invalid username';
        }

        $storedPassword = $result[0]['password'];

        if (!password_verify($password, $storedPassword)) {
            return 'Incorrect password';
        }

        // Assuming you want to return something on successful login
        return 'Login successful';
    }
}

// Test class
class loginTest extends TestCase {
    public function testHandleLogin_ValidLogin() {
        // Mock the database object
        $dbMock = $this->createMock(Database::class);
        $dbMock->method('execute')->willReturn([['password' => password_hash('correct_password', PASSWORD_DEFAULT)]]);

        // Instantiate LoginService with mocked database
        $loginService = new LoginService($dbMock);

        // Test with valid credentials
        $result = $loginService->handleLogin('existing_user', 'correct_password');

        $this->assertEquals('Login successful', $result);
    }

    public function testHandleLogin_InvalidUsername() {
        // Mock the database object
        $dbMock = $this->createMock(Database::class);
        $dbMock->method('execute')->willReturn([]);

        // Instantiate LoginService with mocked database
        $loginService = new LoginService($dbMock);

        // Test with invalid username
        $result = $loginService->handleLogin('nonexistent_user', 'password');

        $this->assertEquals('invalid username', $result);
    }

    public function testHandleLogin_IncorrectPassword() {
        // Mock the database object
        $dbMock = $this->createMock(Database::class);
        $dbMock->method('execute')->willReturn([['password' => password_hash('correct_password', PASSWORD_DEFAULT)]]);

        // Instantiate LoginService with mocked database
        $loginService = new LoginService($dbMock);

        // Test with incorrect password
        $result = $loginService->handleLogin('existing_user', 'wrong_password');

        $this->assertEquals('Incorrect password', $result);
    }
}