<?php

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockSessionStart();
    }

    public function testLoginWithValidCredentials()
    {
        // Mock the required database connection and statement execution
        $connMock = $this->createMock(PDO::class);
        $stmtMock = $this->createMock(PDOStatement::class);

        $connMock->expects($this->once())
                 ->method('prepare')
                 ->with($this->equalTo("SELECT * FROM accounts WHERE username = ?"))
                 ->willReturn($stmtMock);

        $stmtMock->expects($this->once())
                 ->method('execute')
                 ->with($this->equalTo(["test_username"]))
                 ->willReturn(true);

        $stmtMock->expects($this->once())
                 ->method('rowCount')
                 ->willReturn(1);

        $hashedPassword = password_hash("test_password", PASSWORD_DEFAULT);
        $stmtMock->expects($this->once())
                 ->method('fetch')
                 ->willReturn(["password" => $hashedPassword]);

        // Set up POST data
        $_POST['username'] = "test_username";
        $_POST['password'] = "test_password";

        // Include the script
        require_once "../php/login.php"; // Adjust path as needed

        // Assertions
        $this->assertEquals("test_username", $_SESSION['username']);
    }

    protected function mockSessionStart()
    {
        // Mock session_start
        if (!function_exists('session_start')) {
            function session_start() { return true; }
        }
    }
}
