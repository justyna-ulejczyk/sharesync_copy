<?php

use PHPUnit\Framework\TestCase;

class DatabaseConnectionTest extends TestCase
{
    public function testDatabaseConnection()
    {
        // Replace with the actual details
        $host = "kandula.db.elephantsql.com";
        $port = "5432";
        $dbname = "vfqjpwel";
        $user = "vfqjpwel";
        $password = "cFs0XFyubfNelPRIoab5EJcJX6XGA1Y5";

        // Attempt to connect to the database
        $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        // Assert that the connection is not false, indicating successful connection
        $this->assertNotFalse($conn);
    }
}
