<?php
include 'header.php';

$mysqli = new mysqli('localhost', 'root', '', 'racing_wiki');
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

// Get slug from URL
$slug = $_GET['slug'] ?? '';
if (!$slug) {
    echo "<p>No subcategory specified.</p>";
    include 'footer.php';
    exit;
}

$stmt = $mysqli->prepare("
    SELECT 
        s.name AS subcategory_name, 
        s.slug, 
        s.description AS subcategory_description,
        c.name AS category_name, 
        c.description AS category_description
    FROM subcategories s
    JOIN categories c ON s.category_id = c.id
    WHERE s.slug = ?
");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($subcat = $result->fetch_assoc()) {
    echo "<h1>" . htmlspecialchars($subcat['subcategory_name']) . "</h1>";
    echo "<h3>Category: " . htmlspecialchars($subcat['category_name']) . "</h3>";

    // Display subcategory-specific description (detailed info)
    if (!empty($subcat['subcategory_description'])) {
        echo "<p>" . nl2br(htmlspecialchars($subcat['subcategory_description'])) . "</p>";
    } else {
        echo "<p>No detailed information available for this subcategory.</p>";
    }

    echo "<hr>";

    
} else {
    echo "<p>Subcategory not found.</p>";
}

$stmt->close();
$mysqli->close();

include 'footer.php';
?>
