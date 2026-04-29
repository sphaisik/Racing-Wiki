<style>
.search-hero {
    background: linear-gradient(135deg, rgba(0,128,128,0.12), rgba(0,0,0,0.04));
    border-radius: 16px;
    padding: 40px 30px 30px;
    margin: 30px 0 40px;
    border: 1px solid rgba(0,150,136,0.15);
}
.search-hero h1 {
    font-weight: 800;
    font-size: 2rem;
    margin: 0 0 20px;
    color: #1a2e2e;
}
.search-bar {
    display: flex;
    gap: 0;
    max-width: 700px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,128,128,0.2);
}
.search-bar input {
    flex: 1;
    padding: 14px 20px;
    font-size: 1rem;
    border: 2px solid #009688;
    border-right: none;
    border-radius: 12px 0 0 12px;
    outline: none;
}
.search-bar input:focus { border-color: #00796b; }
.search-bar button {
    padding: 14px 28px;
    background: #009688;
    color: white;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 0 12px 12px 0;
    cursor: pointer;
    transition: background 0.2s;
}
.search-bar button:hover { background: #00796b; }

/* Filter tabs */
.filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin: 20px 0 0;
}
.filter-tabs a {
    padding: 7px 16px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 600;
    border: 2px solid #009688;
    color: #009688;
    transition: all 0.2s;
}
.filter-tabs a.active,
.filter-tabs a:hover {
    background: #009688;
    color: white;
}

/* Results */
.results-meta {
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 28px;
}
.results-meta strong { color: #009688; }

.section-heading {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a2e2e;
    margin: 36px 0 14px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e0f2f1;
}
.section-heading i { color: #009688; }
.section-badge {
    margin-left: auto;
    background: #e0f2f1;
    color: #00695c;
    font-size: 0.78rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 12px;
}

/* Cards */
.result-card {
    background: white;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    border-left: 4px solid #009688;
    transition: box-shadow 0.2s, transform 0.2s;
    display: flex;
    gap: 16px;
    align-items: flex-start;
}
.result-card:hover {
    box-shadow: 0 6px 20px rgba(0,150,136,0.18);
    transform: translateY(-2px);
}
.result-thumb {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}
.result-body { flex: 1; min-width: 0; }
.result-title {
    font-weight: 700;
    font-size: 1rem;
    color: #008080;
    text-decoration: none;
    display: block;
    margin-bottom: 4px;
}
.result-title:hover { text-decoration: underline; }
.result-meta {
    font-size: 0.8rem;
    color: #888;
    margin-bottom: 6px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.result-meta span { display: flex; align-items: center; gap: 4px; }
.result-summary {
    font-size: 0.88rem;
    color: #555;
    line-height: 1.5;
    /* clamp to 2 lines */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* highlight */
mark {
    background: #b2dfdb;
    color: #004d40;
    border-radius: 3px;
    padding: 0 2px;
}

/* No results */
.no-results {
    text-align: center;
    padding: 60px 20px;
    color: #888;
}
.no-results i { font-size: 3rem; color: #ccc; margin-bottom: 16px; display: block; }
.no-results h3 { font-size: 1.4rem; margin-bottom: 8px; color: #555; }

.section-empty {
    color: #aaa;
    font-size: 0.9rem;
    padding: 10px 0;
    font-style: italic;
}
</style>
    <?php include 'header.php'; ?>
<?php include 'db.php'; ?>

<?php
$q = trim($_GET['q'] ?? '');
$type = $_GET['type'] ?? 'all';

$results = [
    'pages'    => [],
    'drivers'  => [],
    'tracks'   => [],
    'events'   => [],
    'categories' => [],
];

if ($q !== '') {
    $like = '%' . $q . '%';

    if ($type === 'all' || $type === 'pages') {
        $stmt = $pdo->prepare("
            SELECT rp.title, rp.slug, rp.summary, rp.created_at,
                   c.name AS category
            FROM   race_pages rp
            LEFT JOIN categories c ON c.id = rp.category_id
            WHERE  rp.is_published = 1
              AND  (rp.title LIKE ? OR rp.summary LIKE ? OR rp.content LIKE ?)
            ORDER  BY rp.created_at DESC
            LIMIT  20
        ");
        $stmt->execute([$like, $like, $like]);
        $results['pages'] = $stmt->fetchAll();
    }

    if ($type === 'all' || $type === 'drivers') {
        $stmt = $pdo->prepare("
            SELECT d.name, d.country, d.bio, d.image_path,
                   d.achievements, d.years_active,
                   GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ' / ') AS category
            FROM   drivers d
            LEFT JOIN driver_categories dc ON dc.driver_id = d.id
            LEFT JOIN categories c ON c.id = dc.category_id
            WHERE  d.name LIKE ? OR d.country LIKE ? OR d.bio LIKE ? OR d.achievements LIKE ?
            GROUP BY d.id
            LIMIT  20
        ");
        $stmt->execute([$like, $like, $like, $like]);
        $results['drivers'] = $stmt->fetchAll();
    }

    if ($type === 'all' || $type === 'tracks') {
        $stmt = $pdo->prepare("
            SELECT t.name, t.location, t.length_display, t.turns,
                   t.famous_for, t.image,
                   c.name AS category
            FROM   tracks t
            LEFT JOIN categories c ON c.id = t.category_id
            WHERE  t.name LIKE ? OR t.location LIKE ? OR t.famous_for LIKE ?
            LIMIT  20
        ");
        $stmt->execute([$like, $like, $like]);
        $results['tracks'] = $stmt->fetchAll();
    }

    if ($type === 'all' || $type === 'events') {
        $stmt = $pdo->prepare("
            SELECT e.title, e.location, e.start_datetime, e.description,
                   e.winner, e.image,
                   c.name AS category
            FROM   events e
            LEFT JOIN race_pages rp ON rp.id = e.race_page_id
            LEFT JOIN categories  c  ON c.id  = rp.category_id
            WHERE  e.title LIKE ? OR e.location LIKE ? OR e.description LIKE ? OR e.winner LIKE ?
            ORDER  BY e.start_datetime DESC
            LIMIT  20
        ");
        $stmt->execute([$like, $like, $like, $like]);
        $results['events'] = $stmt->fetchAll();
    }

    if ($type === 'all' || $type === 'categories') {
        $stmt = $pdo->prepare("
            SELECT 'category' AS kind, c.name, c.slug, c.description, NULL AS parent
            FROM   categories c
            WHERE  c.name LIKE ? OR c.description LIKE ?
            UNION ALL
            SELECT 'subcategory' AS kind, s.name, s.slug, s.description, c.name AS parent
            FROM   subcategories s
            JOIN   categories c ON c.id = s.category_id
            WHERE  s.name LIKE ? OR s.description LIKE ?
            LIMIT  20
        ");
        $stmt->execute([$like, $like, $like, $like]);
        $results['categories'] = $stmt->fetchAll();
    }
}

$total = array_sum(array_map('count', $results));
?>



<div style="max-width:1000px; margin:0 auto; padding:20px;">

    <!-- Search Hero -->
    <div class="search-hero">
        <h1><i class="fas fa-magnifying-glass"></i> Search Racing Wiki</h1>
        <form action="search.php" method="get">
            <div class="search-bar">
                <input type="text" name="q"
                       value="<?= htmlspecialchars($q) ?>"
                       placeholder="Search drivers, tracks, events, pages…"
                       autofocus>
                <button type="submit"><i class="fas fa-search"></i> Search</button>
            </div>
            <?php if ($q !== ''): ?>
            <div class="filter-tabs">
                <?php
                $tabs = [
                    'all'        => ['icon' => 'fas fa-globe',         'label' => 'All'],
                    'pages'      => ['icon' => 'fas fa-file-alt',      'label' => 'Pages'],
                    'drivers'    => ['icon' => 'fas fa-user',          'label' => 'Drivers'],
                    'tracks'     => ['icon' => 'fas fa-road',          'label' => 'Tracks'],
                    'events'     => ['icon' => 'fas fa-calendar',      'label' => 'Events'],
                    'categories' => ['icon' => 'fas fa-layer-group',   'label' => 'Categories'],
                ];
                foreach ($tabs as $key => $tab):
                    $active = ($type === $key) ? 'active' : '';
                ?>
                    <a href="search.php?q=<?= urlencode($q) ?>&type=<?= $key ?>" class="<?= $active ?>">
                        <i class="<?= $tab['icon'] ?>"></i> <?= $tab['label'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </form>
    </div>

    <?php if ($q === ''): ?>
        <div class="no-results">
            <i class="fas fa-flag-checkered"></i>
            <h3>What are you looking for?</h3>
            <p>Search across race pages, legendary drivers, iconic tracks, events, and categories.</p>
        </div>

    <?php elseif ($total === 0): ?>
        <div class="no-results">
            <i class="fas fa-search"></i>
            <h3>No results for "<?= htmlspecialchars($q) ?>"</h3>
            <p>Try different keywords, or browse <a href="categories.php" style="color:#009688;">Categories</a>.</p>
        </div>

    <?php else: ?>
        <p class="results-meta">
            Found <strong><?= $total ?></strong> result<?= $total !== 1 ? 's' : '' ?>
            for <strong>"<?= htmlspecialchars($q) ?>"</strong>
        </p>

        <?php
        function hl(string $text, string $q): string {
            if ($q === '') return htmlspecialchars($text);
            $safe_q = preg_quote(htmlspecialchars($q), '/');
            return preg_replace('/(' . $safe_q . ')/i', '<mark>$1</mark>', htmlspecialchars($text));
        }
        ?>

        <?php if (($type === 'all' || $type === 'pages') && !empty($results['pages'])): ?>
        <div class="section-heading">
            <i class="fas fa-file-alt"></i> Race Pages
            <span class="section-badge"><?= count($results['pages']) ?></span>
        </div>
        <?php foreach ($results['pages'] as $p): ?>
            <div class="result-card">
                <div class="result-body">
                    <a href="race_page.php?slug=<?= urlencode($p['slug']) ?>" class="result-title">
                        <?= hl($p['title'], $q) ?>
                    </a>
                    <div class="result-meta">
                        <?php if ($p['category']): ?>
                        <span><i class="fas fa-layer-group"></i> <?= htmlspecialchars($p['category']) ?></span>
                        <?php endif; ?>
                        <?php if ($p['created_at']): ?>
                        <span><i class="fas fa-clock"></i> <?= date('M j, Y', strtotime($p['created_at'])) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($p['summary']): ?>
                    <div class="result-summary"><?= hl($p['summary'], $q) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if (($type === 'all' || $type === 'drivers') && !empty($results['drivers'])): ?>
        <div class="section-heading">
            <i class="fas fa-user"></i> Drivers
            <span class="section-badge"><?= count($results['drivers']) ?></span>
        </div>
        <?php foreach ($results['drivers'] as $d): ?>
            <div class="result-card">
                <?php if (!empty($d['image_path'])): ?>
                <img src="<?= htmlspecialchars($d['image_path']) ?>"
                     alt="<?= htmlspecialchars($d['name']) ?>"
                     class="result-thumb">
                <?php endif; ?>
                <div class="result-body">
                    <span class="result-title" style="cursor:default;">
                        <?= hl($d['name'], $q) ?>
                    </span>
                    <div class="result-meta">
                        <?php if ($d['country']): ?>
                        <span><i class="fas fa-flag"></i> <?= htmlspecialchars($d['country']) ?></span>
                        <?php endif; ?>
                        <?php if ($d['category']): ?>
                        <span><i class="fas fa-layer-group"></i> <?= htmlspecialchars($d['category']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($d['years_active'])): ?>
                        <span><i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($d['years_active']) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($d['achievements'])): ?>
                    <div class="result-summary"><?= hl($d['achievements'], $q) ?></div>
                    <?php elseif (!empty($d['bio'])): ?>
                    <div class="result-summary"><?= hl($d['bio'], $q) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if (($type === 'all' || $type === 'tracks') && !empty($results['tracks'])): ?>
        <div class="section-heading">
            <i class="fas fa-road"></i> Tracks
            <span class="section-badge"><?= count($results['tracks']) ?></span>
        </div>
        <?php foreach ($results['tracks'] as $t): ?>
            <div class="result-card">
                <?php if (!empty($t['image'])): ?>
                <img src="<?= htmlspecialchars($t['image']) ?>"
                     alt="<?= htmlspecialchars($t['name']) ?>"
                     class="result-thumb">
                <?php endif; ?>
                <div class="result-body">
                    <span class="result-title" style="cursor:default;">
                        <?= hl($t['name'], $q) ?>
                    </span>
                    <div class="result-meta">
                        <?php if ($t['location']): ?>
                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($t['location']) ?></span>
                        <?php endif; ?>
                        <?php if ($t['category']): ?>
                        <span><i class="fas fa-layer-group"></i> <?= htmlspecialchars($t['category']) ?></span>
                        <?php endif; ?>
                        <?php if ($t['length_display']): ?>
                        <span><i class="fas fa-ruler"></i> <?= htmlspecialchars($t['length_display']) ?></span>
                        <?php endif; ?>
                        <?php if ($t['turns'] !== null): ?>
                        <span><i class="fas fa-sync-alt"></i> <?= htmlspecialchars($t['turns']) ?> turns</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($t['famous_for']): ?>
                    <div class="result-summary"><?= hl($t['famous_for'], $q) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if (($type === 'all' || $type === 'events') && !empty($results['events'])): ?>
        <div class="section-heading">
            <i class="fas fa-calendar"></i> Events
            <span class="section-badge"><?= count($results['events']) ?></span>
        </div>
        <?php foreach ($results['events'] as $ev): ?>
            <div class="result-card">
                <?php if (!empty($ev['image'])): ?>
                <img src="<?= htmlspecialchars($ev['image']) ?>"
                     alt="<?= htmlspecialchars($ev['title']) ?>"
                     class="result-thumb">
                <?php endif; ?>
                <div class="result-body">
                    <span class="result-title" style="cursor:default;">
                        <?= hl($ev['title'], $q) ?>
                    </span>
                    <div class="result-meta">
                        <?php if ($ev['location']): ?>
                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($ev['location']) ?></span>
                        <?php endif; ?>
                        <?php if ($ev['start_datetime']): ?>
                        <span><i class="fas fa-clock"></i> <?= date('M j, Y', strtotime($ev['start_datetime'])) ?></span>
                        <?php endif; ?>
                        <?php if ($ev['category']): ?>
                        <span><i class="fas fa-layer-group"></i> <?= htmlspecialchars($ev['category']) ?></span>
                        <?php endif; ?>
                        <?php if ($ev['winner']): ?>
                        <span><i class="fas fa-trophy"></i> <?= htmlspecialchars($ev['winner']) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ($ev['description']): ?>
                    <div class="result-summary"><?= hl($ev['description'], $q) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if (($type === 'all' || $type === 'categories') && !empty($results['categories'])): ?>
        <div class="section-heading">
            <i class="fas fa-layer-group"></i> Categories &amp; Subcategories
            <span class="section-badge"><?= count($results['categories']) ?></span>
        </div>
        <?php foreach ($results['categories'] as $cat): ?>
            <div class="result-card">
                <div class="result-body">
                    <?php if ($cat['kind'] === 'subcategory'): ?>
                        <a href="subcategory.php?slug=<?= urlencode($cat['slug']) ?>" class="result-title">
                            <?= hl($cat['name'], $q) ?>
                        </a>
                        <div class="result-meta">
                            <span><i class="fas fa-sitemap"></i> Subcategory of <?= htmlspecialchars($cat['parent'] ?? '') ?></span>
                        </div>
                    <?php else: ?>
                        <a href="categories.php" class="result-title">
                            <?= hl($cat['name'], $q) ?>
                        </a>
                        <div class="result-meta">
                            <span><i class="fas fa-layer-group"></i> Category</span>
                        </div>
                    <?php endif; ?>
                    <?php if ($cat['description']): ?>
                    <div class="result-summary"><?= hl($cat['description'], $q) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

    <?php endif; ?>

</div>

<?php include 'footer.php'; ?>