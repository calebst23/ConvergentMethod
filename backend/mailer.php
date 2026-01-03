<?php
// backend/mailer.php

// 1. CONFIGURATION
$recipient = "cstemmans@gmail.com"; // <--- PUT YOUR EMAIL HERE
$subject_prefix = "[Website Inquiry] ";

// 2. CHECK IF FORM WAS SUBMITTED
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. COLLECT AND CLEAN DATA (Security)
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // 4. VALIDATION
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If data is bad, send them back with an error code
        header("Location: ../contact.html?status=error");
        exit;
    }

    // 5. PREPARE EMAIL CONTENT
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    $email_headers = "From: $name <$email>";

    // 6. SEND EMAIL
    if (mail($recipient, $subject_prefix . $subject, $email_content, $email_headers)) {
        // Success! Redirect back to contact page with success code
        header("Location: ../contact.html?status=success");
    } else {
        // Server failed to send
        header("Location: ../contact.html?status=server_error");
    }

} else {
    // If someone tries to open this file directly without submitting the form
    header("Location: ../contact.html");
}
?>
