<?php
// Database configuration
$host = 'localhost';
$dbname = 'contacts_db';
$username = 'root';
$password = '';

// Create connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
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
                    $stmt->execute([
                        trim($_POST['name']), 
                        trim($_POST['email']), 
                        trim($_POST['phone'])
                    ]);
                    $message = 'Contact added successfully!';
                    $messageType = 'success';
                    break;
                
                case 'update':
                    $stmt = $pdo->prepare("UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?");
                    $stmt->execute([
                        trim($_POST['name']), 
                        trim($_POST['email']), 
                        trim($_POST['phone']), 
                        $_POST['id']
                    ]);
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
        
        // Redirect to prevent form resubmission
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
    $editContact = $stmt->fetch();
}

// Fetch all contacts
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY id DESC");
$contacts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Manager Pro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">📇</div>
            <h1>Contact Manager Pro</h1>
            <p>Organize and manage your contacts efficiently</p>
        </div>

        <div class="main-content">
            <div class="card form-card">
                <div class="card-header">
                    <h2><?= $editContact ? '✏️ Edit Contact' : '➕ New Contact' ?></h2>
                </div>
                
                <form method="POST" id="contactForm">
                    <input type="hidden" name="action" value="<?= $editContact ? 'update' : 'add' ?>">
                    <?php if ($editContact): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($editContact['id']) ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="name">
                            <span class="label-icon">👤</span>
                            Full Name
                        </label>
                        <input type="text" id="name" name="name" placeholder="Enter full name" required value="<?= htmlspecialchars($editContact['name'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <span class="label-icon">📧</span>
                            Email Address
                        </label>
                        <input type="email" id="email" name="email" placeholder="Enter email address" required value="<?= htmlspecialchars($editContact['email'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">
                            <span class="label-icon">📱</span>
                            Phone Number
                        </label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required value="<?= htmlspecialchars($editContact['phone'] ?? '') ?>">
                    </div>
                    
                    <div class="button-group">
                        <button type="submit" class="<?= $editContact ? 'btn-update' : 'btn-add' ?>">
                            <?= $editContact ? '💾 Update Contact' : '➕ Add Contact' ?>
                        </button>
                        
                        <?php if ($editContact): ?>
                            <a href="index.php" class="btn-cancel">❌ Cancel</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card table-card">
                <div class="card-header">
                    <h2>📋 All Contacts</h2>
                    <span class="contact-count"><?= count($contacts) ?> Total</span>
                </div>
                
                <?php if (count($contacts) > 0): ?>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td><span class="id-badge"><?= htmlspecialchars($contact['id']) ?></span></td>
                                    <td>
                                        <div class="contact-name">
                                            <span class="avatar"><?= strtoupper(substr($contact['name'], 0, 1)) ?></span>
                                            <?= htmlspecialchars($contact['name']) ?>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($contact['email']) ?></td>
                                    <td><?= htmlspecialchars($contact['phone']) ?></td>
                                    <td class="actions">
                                        <a href="?edit=<?= $contact['id'] ?>" class="btn-icon btn-edit" title="Edit">
                                            ✏️
                                        </a>
                                        <form method="POST" style="display: inline;" class="delete-form">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($contact['id']) ?>">
                                            <button type="submit" class="btn-icon btn-delete" title="Delete">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <h3>No contacts yet</h3>
                        <p>Start by adding your first contact!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <div class="toast-icon"></div>
        <div class="toast-content">
            <div class="toast-title"></div>
            <div class="toast-message"></div>
        </div>
        <button class="toast-close" onclick="closeToast()">✕</button>
    </div>

    <script src="script.js"></script>
    
    <?php if (!empty($message)): ?>
    <script>
        showToast('<?= addslashes($message) ?>', '<?= $messageType ?>');
    </script>
    <?php endif; ?>
</body>
</html>
