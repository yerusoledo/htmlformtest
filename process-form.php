<?php

$name = $_POST["name"];
$message = $_POST["message"];
$priority = filter_input(INPUT_POST, "priority", FILTER_VALIDATE_INT);
$type = filter_input(INPUT_POST, "type", FILTER_VALIDATE_INT);
$terms = filter_input(INPUT_POST, "terms", FILTER_VALIDATE_BOOLEAN);

if (!$terms) {
    die("Terms must be accepted");
}

$host = "localhost";
$dbname = "message_db";
$username = "root";
$password = "092003Kimberly";  // Set a secure password in production

// Enable MySQLi to throw exceptions for errors
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $username, $password, $dbname);

    $sql = "INSERT INTO your_table_name (name, body, priority, type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param("ssii", $name, $message, $priority, $type);

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    echo "Record saved.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($conn)) {
        $conn->close();
    }
}
