<?php include 'header.php'; ?>
<?php include 'db.php'; ?>
<style>
.page-hero {
    background: linear-gradient(135deg, rgba(0,128,128,.15), rgba(0,0,0,.05));
    border-bottom: 1px solid rgba(0,0,0,.07);
    padding: 50px 20px 40px;
    text-align: center;
    margin-bottom: 40px;
}
.page-hero h1 {
    font-weight: 800;
    font-size: 2.6rem;
    color: #2c3e50;
    letter-spacing: -1px;
    margin: 0 0 10px;
}
.page-hero p {
    color: #666;
    font-size: 1.05rem;
    max-width: 600px;
    margin: 0 auto;
}

.filter-bar {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
    margin-bottom: 24px;
}
.filter-bar select,
.filter-bar input[type="text"] {
    padding: 8px 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #444;
    background: #fff;
    outline: none;
}
.filter-bar select:focus,
.filter-bar input:focus {
    border-color: #008080;
}
.btn-teal {
    background: #008080;
    color: #fff;
    border: none;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 0.9rem;
    cursor: pointer;
}
.btn-teal:hover {
    background: #006666;
}

.table-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 50px;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th {
    text-align: left;
    padding: 16px 14px;
    background: #fdfdfd;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.05em;
    color: #008080;
    border-bottom: 2px solid #008080;
    white-space: nowrap;
}
td {
    padding: 14px;
    border-bottom: 1px solid #eee;
    color: #444;
    font-size: 0.95rem;
    vertical-align: middle;
}
tr:hover td {
    background-color: #f4fdfd;
}

.event-thumb {
    width: 80px;
    height: 52px;
    object-fit: cover;
    border-radius: 6px;
    display: block;
}
.thumb-placeholder {
    width: 80px;
    height: 52px;
    background: #f0f0f0;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #bbb;
    font-size: 1.2rem;
}

.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    background: rgba(0,128,128,0.1);
    color: #008080;
    white-space: nowrap;
}

.pagination {
    display: flex;
    gap: 6px;
    justify-content: center;
    margin: 20px 0 40px;
}
.pagination a,
.pagination span {
    padding: 6px 13px;
    border: 1px solid #ddd;
    border-radius: 6px;
    text-decoration: none;
    color: #444;
    font-size: 0.9rem;
}
.pagination a:hover {
    border-color: #008080;
    color: #008080;
}
.pagination span.active {
    background: #008080;
    color: #fff;
    border-color: #008080;
}
.pagination span.disabled {
    color: #ccc;
}

.no-results {
    text-align: center;
    padding: 60px 20px;
    color: #999;
    font-size: 1rem;
}

.section-title {
    margin: 35px 0 14px;
    font-size: 1.45rem;
    font-weight: 800;
    color: #2c3e50;
}

.result-count {
    color: #999;
    font-size: 0.92rem;
    margin-bottom: 12px;
}
</style>



<div style="max-width:1100px; margin:0 auto;margin-top: 20px; padding:0 20px 60px;">

<?php
$search   = trim($_GET['search'] ?? '');
$cat_id   = (int)($_GET['cat'] ?? 0);
$year     = (int)($_GET['year'] ?? 0);

$per_page = 10;
$page_num = max(1, (int)($_GET['page'] ?? 1));
$offset   = ($page_num - 1) * $per_page;

$eventWhere  = ['1=1'];
$eventParams = [];

if ($search !== '') {
    $eventWhere[] = '(e.title LIKE :search OR e.location LIKE :search OR e.winner LIKE :search OR e.description LIKE :search)';
    $eventParams[':search'] = '%' . $search . '%';
}
if ($cat_id > 0) {
    $eventWhere[] = 'rp.category_id = :cat';
    $eventParams[':cat'] = $cat_id;
}
if ($year > 0) {
    $eventWhere[] = 'YEAR(e.start_datetime) = :year';
    $eventParams[':year'] = $year;
}
$eventWhereSQL = implode(' AND ', $eventWhere);

$driverWhere  = ['1=1'];
$driverParams = [];

if ($search !== '') {
    $driverWhere[] = '(d.name LIKE :search OR d.country LIKE :search OR d.bio LIKE :search OR d.achievements LIKE :search)';
    $driverParams[':search'] = '%' . $search . '%';
}
if ($cat_id > 0) {
    $driverWhere[] = 'dc.category_id = :cat';
    $driverParams[':cat'] = $cat_id;
}
$driverWhereSQL = implode(' AND ', $driverWhere);

$trackWhere  = ['1=1'];
$trackParams = [];

if ($search !== '') {
    $trackWhere[] = '(t.name LIKE :search OR t.location LIKE :search OR t.country LIKE :search OR t.famous_for LIKE :search)';
    $trackParams[':search'] = '%' . $search . '%';
}
if ($cat_id > 0) {
    $trackWhere[] = 't.category_id = :cat';
    $trackParams[':cat'] = $cat_id;
}
$trackWhereSQL = implode(' AND ', $trackWhere);

$countStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM events e
    LEFT JOIN race_pages rp ON rp.id = e.race_page_id
    WHERE $eventWhereSQL
");
$countStmt->execute($eventParams);
$totalEvents = (int)$countStmt->fetchColumn();
$total_pages = max(1, (int)ceil($totalEvents / $per_page));

$stmt = $pdo->prepare("
    SELECT e.id, e.title, e.location, e.start_datetime,
           e.winner, e.image, e.description,
           c.name AS category,
           rp.slug AS page_slug
    FROM events e
    LEFT JOIN race_pages rp ON rp.id = e.race_page_id
    LEFT JOIN categories c ON c.id = rp.category_id
    WHERE $eventWhereSQL
    ORDER BY e.start_datetime DESC
    LIMIT :lim OFFSET :off
");
foreach ($eventParams as $k => $v) {
    $stmt->bindValue($k, $v);
}
$stmt->bindValue(':lim', $per_page, PDO::PARAM_INT);
$stmt->bindValue(':off', $offset, PDO::PARAM_INT);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$driverStmt = $pdo->prepare("
    SELECT d.id, d.name, d.country, d.achievements, d.years_active, d.image_path,
           GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ' / ') AS category
    FROM drivers d
    LEFT JOIN driver_categories dc ON dc.driver_id = d.id
    LEFT JOIN categories c ON c.id = dc.category_id
    WHERE $driverWhereSQL
    GROUP BY d.id, d.name, d.country, d.achievements, d.years_active, d.image_path
    ORDER BY d.name ASC
");
foreach ($driverParams as $k => $v) {
    $driverStmt->bindValue($k, $v);
}
$driverStmt->execute();
$drivers = $driverStmt->fetchAll(PDO::FETCH_ASSOC);

$trackStmt = $pdo->prepare("
    SELECT t.id, t.name, t.location, t.country, t.length_display, t.turns,
           t.famous_for, t.image, t.slug,
           c.name AS category,
           rp.slug AS page_slug
    FROM tracks t
    LEFT JOIN categories c ON c.id = t.category_id
    LEFT JOIN race_pages rp ON rp.id = t.race_page_id
    WHERE $trackWhereSQL
    ORDER BY t.name ASC
");
foreach ($trackParams as $k => $v) {
    $trackStmt->bindValue($k, $v);
}
$trackStmt->execute();
$tracks = $trackStmt->fetchAll(PDO::FETCH_ASSOC);

$cats = $pdo->query("
    SELECT id, name
    FROM categories
    ORDER BY name
")->fetchAll(PDO::FETCH_ASSOC);

$years = $pdo->query("
    SELECT DISTINCT YEAR(start_datetime) AS y
    FROM events
    WHERE start_datetime IS NOT NULL
    ORDER BY y DESC
")->fetchAll(PDO::FETCH_COLUMN);

$totalDrivers = count($drivers);
$totalTracks  = count($tracks);
$grandTotal   = $totalEvents + $totalDrivers + $totalTracks;
?>

<form method="get" action="event.php">
    <div class="filter-bar">
        <input type="text" name="search" placeholder="Search events, drivers, tracks..."
               value="<?= htmlspecialchars($search) ?>">

        <select name="cat">
            <option value="0">All Categories</option>
            <?php foreach ($cats as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $cat_id == $cat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="year">
            <option value="0">All Years (events only)</option>
            <?php foreach ($years as $y): ?>
                <option value="<?= $y ?>" <?= $year == $y ? 'selected' : '' ?>>
                    <?= $y ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-teal">
            <i class="fas fa-search"></i> Search
        </button>

        <?php if ($search || $cat_id || $year): ?>
            <a href="event.php"
               style="color:#999; font-size:0.88rem; text-decoration:none; align-self:center;">
                ✕ Clear filters
            </a>
        <?php endif; ?>

        <span style="margin-left:auto; color:#999; font-size:0.88rem; align-self:center;">
            <?= $grandTotal ?> result<?= $grandTotal != 1 ? 's' : '' ?> found
        </span>
    </div>
</form>

<?php if ($grandTotal === 0): ?>
    <div class="no-results">
        <i class="fas fa-search" style="font-size:2rem; margin-bottom:12px; display:block;"></i>
        No results match your search.
        <a href="event.php" style="color:#008080;">Clear filters</a>
    </div>
<?php else: ?>

    <div class="section-title">Events</div>
    <div class="result-count"><?= $totalEvents ?> event<?= $totalEvents != 1 ? 's' : '' ?></div>

    <?php if (empty($events)): ?>
        <div class="table-container">
            <div class="no-results" style="padding:30px 20px;">No matching events found.</div>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width:90px;">Image</th>
                        <th>Event</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Winner</th>
                        <th>Page</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $ev):
                    $title    = htmlspecialchars($ev['title']);
                    $location = htmlspecialchars($ev['location'] ?? '—');
                    $date     = !empty($ev['start_datetime']) ? date('d M Y', strtotime($ev['start_datetime'])) : '—';
                    $category = htmlspecialchars($ev['category'] ?? '');
                    $winner   = htmlspecialchars($ev['winner'] ?? '—');
                    $img      = htmlspecialchars($ev['image'] ?? '');
                    $slug     = $ev['page_slug'] ?? '';
                ?>
                    <tr>
                        <td>
                            <?php if ($img): ?>
                                <img src="<?= $img ?>" alt="<?= $title ?>" class="event-thumb">
                            <?php else: ?>
                                <div class="thumb-placeholder">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:600; color:#2c3e50;"><?= $title ?></td>
                        <td><?= $location ?></td>
                        <td style="white-space:nowrap;"><?= $date ?></td>
                        <td>
                            <?php if ($category): ?>
                                <span class="badge"><?= $category ?></span>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:600;"><?= $winner ?></td>
                        <td>
                            <?php if ($slug): ?>
                                <a href="race_page.php?slug=<?= urlencode($slug) ?>"
                                   style="color:#008080; text-decoration:none; font-size:0.88rem;">
                                    View →
                                </a>
                            <?php else: ?>
                                <span style="color:#ccc;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1):
            $base = '?' . http_build_query([
                'search' => $search,
                'cat'    => $cat_id,
                'year'   => $year
            ]);
        ?>
            <div class="pagination">
                <?php if ($page_num > 1): ?>
                    <a href="<?= $base ?>&page=<?= $page_num - 1 ?>">‹ Prev</a>
                <?php else: ?>
                    <span class="disabled">‹ Prev</span>
                <?php endif; ?>

                <?php for ($p = 1; $p <= $total_pages; $p++): ?>
                    <?php if ($p == $page_num): ?>
                        <span class="active"><?= $p ?></span>
                    <?php else: ?>
                        <a href="<?= $base ?>&page=<?= $p ?>"><?= $p ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page_num < $total_pages): ?>
                    <a href="<?= $base ?>&page=<?= $page_num + 1 ?>">Next ›</a>
                <?php else: ?>
                    <span class="disabled">Next ›</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="section-title">Drivers</div>
    <div class="result-count"><?= $totalDrivers ?> driver<?= $totalDrivers != 1 ? 's' : '' ?></div>

    <?php if (empty($drivers)): ?>
        <div class="table-container">
            <div class="no-results" style="padding:30px 20px;">No matching drivers found.</div>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width:90px;">Image</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Category</th>
                        <th>Achievements</th>
                        <th>Years Active</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($drivers as $dr):
                    $name         = htmlspecialchars($dr['name']);
                    $country      = htmlspecialchars($dr['country'] ?? '—');
                    $category     = htmlspecialchars($dr['category'] ?? '');
                    $achievements = htmlspecialchars($dr['achievements'] ?? '—');
                    $years_active = htmlspecialchars($dr['years_active'] ?? '—');
                    $img          = htmlspecialchars($dr['image_path'] ?? '');
                ?>
                    <tr>
                        <td>
                            <?php if ($img): ?>
                                <img src="<?= $img ?>" alt="<?= $name ?>" class="event-thumb">
                            <?php else: ?>
                                <div class="thumb-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:600; color:#2c3e50;"><?= $name ?></td>
                        <td><?= $country ?></td>
                        <td>
                            <?php if ($category): ?>
                                <span class="badge"><?= $category ?></span>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td><?= $achievements ?></td>
                        <td><?= $years_active ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="section-title">Tracks</div>
    <div class="result-count"><?= $totalTracks ?> track<?= $totalTracks != 1 ? 's' : '' ?></div>

    <?php if (empty($tracks)): ?>
        <div class="table-container">
            <div class="no-results" style="padding:30px 20px;">No matching tracks found.</div>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width:90px;">Image</th>
                        <th>Track</th>
                        <th>Location</th>
                        <th>Country</th>
                        <th>Category</th>
                        <th>Length</th>
                        <th>Turns</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($tracks as $tr):
                    $name      = htmlspecialchars($tr['name']);
                    $location  = htmlspecialchars($tr['location'] ?? '—');
                    $country   = htmlspecialchars($tr['country'] ?? '—');
                    $category  = htmlspecialchars($tr['category'] ?? '');
                    $length    = htmlspecialchars($tr['length_display'] ?? '—');
                    $turns     = ($tr['turns'] === null) ? '—' : htmlspecialchars($tr['turns']);
                    $img       = htmlspecialchars($tr['image'] ?? '');
                ?>
                    <tr>
                        <td>
                            <?php if ($img): ?>
                                <img src="<?= $img ?>" alt="<?= $name ?>" class="event-thumb">
                            <?php else: ?>
                                <div class="thumb-placeholder">
                                    <i class="fas fa-road"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight:600; color:#2c3e50;"><?= $name ?></td>
                        <td><?= $location ?></td>
                        <td><?= $country ?></td>
                        <td>
                            <?php if ($category): ?>
                                <span class="badge"><?= $category ?></span>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td><?= $length ?></td>
                        <td><?= $turns ?></td>
                        <td>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

<?php endif; ?>

</div>

<?php include 'footer.php'; ?>