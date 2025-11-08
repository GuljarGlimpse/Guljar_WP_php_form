<?php
// Database configuration
$host = 'localhost';
$dbname = 'contacts_db';
$username = 'root';
$password = '';

// Create connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        try {
            switch ($_POST['action']) {
                case 'add':
                    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");
                    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone']]);
                    $message = 'Contact added successfully!';
                    $messageType = 'success';
                    break;
                
                case 'update':
                    $stmt = $pdo->prepare("UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?");
                    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['phone'], $_POST['id']]);
                    $message = 'Contact updated successfully!';
                    $messageType = 'success';
                    break;
                
                case 'delete':
                    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
                    $stmt->execute([$_POST['id']]);
                    $message = 'Contact deleted successfully!';
                    $messageType = 'success';
                    break;
            }
        } catch(PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
            $messageType = 'error';
        }
        
        // Redirect with message
        header('Location: ' . $_SERVER['PHP_SELF'] . '?msg=' . urlencode($message) . '&type=' . $messageType);
        exit;
    }
}

// Get message from URL
if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
    $messageType = $_GET['type'] ?? 'info';
}

// Get contact for editing
$editContact = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editContact = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch all contacts
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY id DESC");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Include the HTML view
include 'view.html';
?>