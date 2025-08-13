<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $name     = htmlspecialchars(trim($_POST['name']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $phone    = htmlspecialchars(trim($_POST['phone']));
    $address  = htmlspecialchars(trim($_POST['address']));
    $message  = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($message)) {
        echo "❌ Please fill in all required fields.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Invalid email format.";
        exit;
    }

    $folderPath = __DIR__ . '/secure_data';
    $filePath   = $folderPath . '/contact_submissions.json';

    if (!is_dir($folderPath)) {
        mkdir($folderPath, 0755, true);
    }

    $existingData = [];
    if (file_exists($filePath)) {
        $existingData = json_decode(file_get_contents($filePath), true) ?? [];
    }

    $existingData[] = [
        'date'    => date("Y-m-d H:i:s"),
        'name'    => $name,
        'email'   => $email,
        'phone'   => $phone,
        'address' => $address,
        'message' => $message
    ];

    if (file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT), LOCK_EX)) {
        echo "✅ Your message has been received. Thank you!";
    } else {
        echo "❌ Could not save your message. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
