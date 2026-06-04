<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = trim($_POST["name"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if ($name === "" || $email === "" || $message === "") {
        echo "Please fill in all fields.";
        exit;
    }

    $to      = "pranayakomatireddy457@gmail.com";
    $subject = "New message from portfolio contact form";
    $body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email\r\nReply-To: $email\r\n";

    @mail($to, $subject, $body, $headers);

    $logLine = date("Y-m-d H:i:s") . " | $name | $email | " . str_replace("\n", " ", $message) . PHP_EOL;
    $result = file_put_contents("messages.txt", $logLine, FILE_APPEND | LOCK_EX);

    if ($result === false) {
        echo "Your message was received but could not be saved to messages.txt.";
        exit;
    }

    // Redirect back to your portfolio with a success flag
    header("Location: pro.html?status=success");
    exit;

} else {
    echo "Invalid request (not POST).";
}