<?php
// Check the environment and set configurations accordingly
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Localhost Configuration
    defined("SITE_URL") or define("SITE_URL", "http://localhost");
    defined("HOME_URL") or define("HOME_URL", SITE_URL . "/index.php");

    // Localhost Database Configuration
    defined("DB_HOST") or define("DB_HOST", "localhost");
    defined("DB_USERNAME") or define("DB_USERNAME", "root"); // Default username
    defined("DB_PASSWORD") or define("DB_PASSWORD", "");     // No password for localhost
    defined("DB_NAME") or define("DB_NAME", "mwalimunyerere_admin"); // Your local database name
} else {
    // Production Configuration (mwalimunyerere.org)
    defined("SITE_URL") or define("SITE_URL", "https://mwalimunyerere.org");
    defined("HOME_URL") or define("HOME_URL", SITE_URL . "/index.php");

    // Production Database Configuration
    defined("DB_HOST") or define("DB_HOST", "localhost");
    defined("DB_USERNAME") or define("DB_USERNAME", "mwalimunyerere_admin"); // Production username
    defined("DB_PASSWORD") or define("DB_PASSWORD", "Admin@123??");          // Production password
    defined("DB_NAME") or define("DB_NAME", "mwalimunyerere_admin");         // Production database name
}

// Create database connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Additional configurations (if any) can go here
?>
