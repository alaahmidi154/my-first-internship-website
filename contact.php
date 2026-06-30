<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $company_name = trim($_POST["company_name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    if (empty($company_name) || empty($email) || empty($message)) {
        die("Please fill in all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    $stmt = $conn->prepare("INSERT INTO contact_messages (company_name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $company_name, $email, $message);

    if ($stmt->execute()) {
        echo "Thank you, your message has been sent!";
    } else {
        echo "Something went wrong. Please try again.";
    }

    $stmt->close();
    $conn->close();
}