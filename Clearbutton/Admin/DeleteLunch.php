<?php
session_start();
if (!isset($_SESSION['A_email'])) {
    header("Location: AdminLogin.php");
    exit();
}

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "mypasifikarecipes";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['selected_files'])) {
        // Prepare placeholders for SQL query safely
        $placeholders = implode(',', array_fill(0, count($_POST['selected_files']), '?'));

        // Fetch paths for files to delete
        $sql = "SELECT file_path FROM lunch_upload WHERE file_name IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($_POST['selected_files']);
        $filesToDelete = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Delete files from filesystem
        foreach ($filesToDelete as $file) {
            if (file_exists($file['file_path'])) {
                unlink($file['file_path']); // Delete file from filesystem
            }
        }

        // Delete file entries from database
        $sql = "DELETE FROM lunch_upload WHERE file_name IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($_POST['selected_files'])) {
            echo json_encode(['status' => 'success', 'message' => 'Files deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete records from the database.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No files selected for deletion.']);
    }
}
