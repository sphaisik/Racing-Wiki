<?php include 'header.php'; ?>

<?php
// Database connection settings - adjust as needed
$host = 'localhost';
$dbname = 'racing_wiki';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $dbname);
if ($mysqli->connect_error) {
    die('Database connection error: ' . $mysqli->connect_error);
}

// Fetch categories with images and descriptions
$categories = [];
$cat_sql = "SELECT id, name, description, image FROM categories ORDER BY id ASC";
if ($cat_result = $mysqli->query($cat_sql)) {
    while ($cat = $cat_result->fetch_assoc()) {
        $cat_id = (int)$cat['id'];

        // Fetch subcategories for this category
        $subcategories = [];
        $sub_sql = "SELECT name FROM subcategories WHERE category_id = $cat_id ORDER BY id ASC";
        if ($sub_result = $mysqli->query($sub_sql)) {
            while ($sub = $sub_result->fetch_assoc()) {
                $subcategories[] = $sub['name'];
            }
            $sub_result->free();
        }

        $categories[] = [
            'title' => $cat['name'],
            'description' => $cat['description'],
            'subcategories' => $subcategories,
            'image' => $cat['image'],
        ];
    }
    $cat_result->free();
} else {
    echo "<p>Error loading categories.</p>";
}
?>

<h2>Racing Categories</h2>
<p>Click on a category image to see its subcategories.</p>

<style>
.category-box {
    position: relative;
    cursor: pointer;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transition: transform 0.3s ease;
}
.category-box:hover {
    transform: scale(1.05);
}
.category-box img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    border-radius: 12px;
}
.category-title {
    position: absolute;
    bottom: 0;
    background: rgba(0, 128, 128, 0.75);
    color: white;
    width: 100%;
    padding: 10px;
    font-weight: bold;
    font-size: 1.2rem;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}
.subcategory-panel {
    display: none;
    margin-top: 10px;
    padding: 15px;
    background: #f0f8f8;
    border-radius: 10px;
    box-shadow: inset 0 0 8px rgba(0,128,128,0.2);
}
.subcategory-panel.active {
    display: block;
}
.subcategory-panel ul {
    margin: 0;
    padding-left: 20px;
}
.subcategory-panel ul li {
    margin-bottom: 6px;
}
</style>

<div class="w3-row-padding">
    <?php foreach ($categories as $index => $cat): ?>
        <div class="w3-col l4 m6 s12 w3-margin-bottom">
            <div class="category-box" data-index="<?= $index ?>">
                <img src="<?= htmlspecialchars($cat['image']) ?>" alt="<?= htmlspecialchars($cat['title']) ?>">
                <div class="category-title"><?= htmlspecialchars($cat['title']) ?></div>
            </div>
            <div class="subcategory-panel" id="subcat-<?= $index ?>">
                <h4><?= htmlspecialchars($cat['title']) ?> Subcategories</h4>
                <p><?= htmlspecialchars($cat['description']) ?></p>
                <ul>
                    <?php foreach ($cat['subcategories'] as $sub): ?>
                        <li><?= htmlspecialchars($sub) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
document.querySelectorAll('.category-box').forEach(box => {
    box.addEventListener('click', () => {
        const index = box.getAttribute('data-index');
        // Hide all panels
        document.querySelectorAll('.subcategory-panel').forEach(panel => {
            panel.classList.remove('active');
        });
        // Show clicked panel
        const panel = document.getElementById('subcat-' + index);
        if (panel) {
            panel.classList.add('active');
            // Scroll to panel smoothly
            panel.scrollIntoView({behavior: 'smooth', block: 'start'});
        }
    });
});
</script>

<?php include 'footer.php'; ?>
