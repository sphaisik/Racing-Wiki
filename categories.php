<?php include 'header.php'; ?>

<?php
// Your categories array as before
$categories = [
    [
        'title' => 'Open-Wheel Racing',
        'description' => 'Cars with exposed wheels and single-seat cockpits.',
        'subcategories' => [
            'Formula 1 (F1)',
            'IndyCar',
            'Formula 2, Formula 3',
            'GP2, GP3',
            'Formula E (electric open-wheel racing)',
        ],
        'image' => 'images/open_wheel.jpg', // Add your image paths here
    ],
    [
        'title' => 'Touring Car Racing',
        'description' => 'Modified road cars racing on circuits.',
        'subcategories' => [
            'British Touring Car Championship (BTCC)',
            'World Touring Car Cup (WTCR)',
            'Super Touring',
            'TCR Series',
        ],
        'image' => 'images/touring.jpg',
    ],
    [
        'title' => 'Sports Car Racing',
        'description' => 'Racing with sports prototype and grand touring (GT) cars.',
        'subcategories' => [
            'Endurance racing (e.g., 24 Hours of Le Mans)',
            'GT3, GT4 classes',
            'IMSA WeatherTech SportsCar Championship',
            'FIA World Endurance Championship (WEC)',
        ],
        'image' => 'images/sports.jpg',
    ],
    [
        'title' => 'Production Car Racing',
        'description' => 'Racing with minimally modified production vehicles.',
        'subcategories' => [
            'B Spec',
            'Super Production',
            'Group N',
        ],
        'image' => 'images/production.jpg',
    ],
    [
        'title' => 'Stock Car Racing',
        'description' => 'Racing with cars resembling production models but heavily modified.',
        'subcategories' => [
            'NASCAR Cup Series',
            'ARCA Menards Series',
            'Late Model Stock Cars',
        ],
        'image' => 'images/stock.jpg',
    ],
    [
        'title' => 'One-Make Racing',
        'description' => 'All competitors use identical cars from a single manufacturer.',
        'subcategories' => [
            'Porsche Carrera Cup',
            'Ferrari Challenge',
            'Renault Clio Cup',
        ],
        'image' => 'images/one-make.jpg',
    ],
    [
        'title' => 'Drag Racing',
        'description' => 'Straight-line acceleration races over a short distance (usually 1/4 mile).',
        'subcategories' => [
            'Top Fuel Dragsters',
            'Funny Cars',
            'Pro Stock',
            'Motorcycle Drag Racing',
        ],
        'image' => 'images/drag.jpg',
    ],
    [
        'title' => 'Off-Road Racing',
        'description' => 'Racing on unpaved surfaces like dirt, sand, or gravel.',
        'subcategories' => [
            'Rally Raid (e.g., Dakar Rally)',
            'Short Course Off-Road Racing',
            'Baja 1000',
            'Desert Racing',
        ],
        'image' => 'images/off-road.webp',
    ],
    [
        'title' => 'Rallying',
        'description' => 'Timed stage races on closed public or private roads with varied surfaces.',
        'subcategories' => [
            'World Rally Championship (WRC)',
            'Rallycross',
            'Hill Climb',
        ],
        'image' => 'images/rally.jpg',
    ],
    [
        'title' => 'Dirt Track Racing',
        'description' => 'Racing on oval dirt tracks.',
        'subcategories' => [
            'Sprint Cars',
            'Late Models',
            'Modifieds',
        ],
        'image' => 'images/dirt_track.webp',
    ],
];
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