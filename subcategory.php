<style>html, body {
    height: 100%;
    margin: 0;
}

body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: #f4f7f6;
    font-family: Arial, sans-serif;
}

.page-content {
    flex: 1;
}

.subcategory-page {
    max-width: 1000px;
    margin: 50px auto;
    padding: 20px;
}

.subcategory-card {
    background: white;
    border-left: 8px solid #009688;
    border-radius: 14px;
    padding: 35px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.category-label {
    color: #009688;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 8px;
}

.subcategory-card h1 {
    margin: 10px 0 20px;
    font-size: 42px;
    color: #222;
}

.subcategory-card h3 {
    margin: 0;
    color: #555;
}

.subcategory-description {
    margin-top: 25px;
    font-size: 18px;
    line-height: 1.7;
    color: #333;
}

.message-box {
    background: white;
    max-width: 700px;
    margin: 60px auto;
    padding: 30px;
    border-left: 8px solid #009688;
    border-radius: 12px;
    font-size: 20px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
}
    </style>
    <?php
include 'header.php';

$mysqli = new mysqli('localhost', 'root', '', 'racing_wiki');
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

$slug = $_GET['slug'] ?? '';
?>

<div class="page-content">
    <div class="subcategory-page">

<?php
if (!$slug) {
    echo "<div class='message-box'>No subcategory specified.</div>";
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
    echo "<div class='subcategory-card'>";

    echo "<p class='category-label'>Category</p>";
    echo "<h3>" . htmlspecialchars($subcat['category_name']) . "</h3>";

    echo "<h1>" . htmlspecialchars($subcat['subcategory_name']) . "</h1>";

    if (!empty($subcat['subcategory_description'])) {
        echo "<p class='subcategory-description'>" . nl2br(htmlspecialchars($subcat['subcategory_description'])) . "</p>";
    } else {
        echo "<p class='subcategory-description'>No detailed information available for this subcategory.</p>";
    }

    echo "</div>";
} else {
    echo "<div class='message-box'>Subcategory not found.</div>";
}

$stmt->close();
$mysqli->close();
?>

    </div>
</div>

<?php include 'footer.php'; ?>