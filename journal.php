<?php
session_start(); // Start a session

// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "journal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_entry'])) {
        $content = $_POST['content'];
        $user_id = $_SESSION['user_id'];
        $entry_date = date('Y-m-d');

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO journal_entries (user_id, entry_date, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $entry_date, $content);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_entry'])) {
        $entry_id = $_POST['entry_id'];

        // Prepare and bind
        $stmt = $conn->prepare("DELETE FROM journal_entries WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $entry_id, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch journal entries
$stmt = $conn->prepare("SELECT id, entry_date, content FROM journal_entries WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$entries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Journal</title>
    <?php include "navbar.php" ?>
         <style>
        .content{
            font-family: Arial, sans-serif;
            margin: 10px;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
        }

        form {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 200%; /* Full width */
            max-width: 500px; /* Limit max width */
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
        }

        input[type="submit"] {
            background-color: #5cb85c;
            color: black;
            border: none;
            padding: 8px 12px; /* Adjust padding for smaller button */
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px; /* Smaller font size */
        }

        input[type="submit"]:hover {
            background-color: #4cae4c;
        }

        h3 {
            margin-top: 30px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            width: 100%; /* Full width */
            max-width: 500px; /* Limit max width */
        }

        li {
            background-color: #fff;
            margin: 20px 0;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between; /* Space between content and delete button */
            align-items: center; /* Center items vertically */
        }

        strong {
            display: block;
            margin-bottom: 5px;
        }

        form.inline {
            display: inline;
        }

        /* Center the delete button */
        form.inline input[type="submit"] {
            padding: 5px 10px; /* Smaller padding for delete button */
            font-size: 12px; /* Smaller font size */
        }
    </style>

</head>
<body>
    <?php include "navbar.php"?>
    <div class="content">
    <form action="" method="post">
        <textarea name="content" required></textarea>
        <br>
        <input type="submit" name="add_entry" value="Add Entry">
    </form>
    <h3>Your Entries</h3>
    <ul>
        <?php foreach ($entries as $entry): ?>
            <li>
                <strong><?php echo htmlspecialchars($entry['entry_date']); ?>:</strong>
                <?php echo htmlspecialchars($entry['content']); ?>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="entry_id" value="<?php echo $entry['id']; ?>">
                    <input type="submit" name="delete_entry" value="Delete">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    </div>
</body>
</html>