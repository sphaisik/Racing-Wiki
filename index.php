<?php include 'header.php'; ?>
<?php include 'db.php'; // must provide $pdo (PDO instance) ?>
<style>
/* ── Tables ─────────────────────────────────────────────────── */
.table-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    margin-bottom: 50px;
}
table { width: 100%; border-collapse: collapse; }
th {
    text-align: left;
    padding: 16px 12px;
    background: #fdfdfd;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
}
td {
    padding: 15px 12px;
    border-bottom: 1px solid #eee;
    color: #444;
    position: relative;
}

/* ── Driver hover card ──────────────────────────────────────── */
.driver {
    position: relative;
    cursor: pointer;
    color: #008080;
    font-weight: bold;
    display: inline-block;
}
.driver img {
    position: absolute;
    top: 40px;
    right: 0;
    width: 220px;
    border-radius: 12px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.4);
    opacity: 0;
    transform: translateY(15px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    pointer-events: none;
    border: 3px solid #fff;
    z-index: 100;
}
.driver:hover img { opacity: 1; transform: translateY(0) scale(1); }
tr:hover { background-color: #f4fdfd; position: relative; z-index: 10; }

/* ── Event image cards ──────────────────────────────────────── */
.image-container-1, .image-container {
    position: relative;
    width: 400px;
    height: 250px;
    overflow: hidden;
    border-radius: 8px;
}
.image-container-1 img, .image-container img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
    filter: blur(0px);
    transition: filter 0.5s ease-in-out;
}
.image-container:hover img { filter: blur(5px); }
.overlay-text {
    position: absolute;
    top: 20px; left: 20px;
    color: white;
    padding: 10px 15px;
    z-index: 10;
}
.title         { opacity: 1; }
.hover-description { opacity: 0; transition: opacity 0.3s ease; }
.image-container-1:hover .hover-description,
.image-container:hover   .hover-description {
    opacity: 1;
    background: rgba(0,0,0,0.5);
}
.image-pair { display: flex; gap: 20px; flex-wrap: wrap; }
</style>

<!-- ── HERO ───────────────────────────────────────────────────────── -->
<div style="display:flex; justify-content:center; align-items:center; min-height:50vh; padding:20px;">
    <section class="w3-panel w3-padding-32 w3-round-large w3-card"
             style="margin:40px auto; max-width:900px;
                    background:linear-gradient(135deg,rgba(0,128,128,.18),rgba(0,0,0,.06));
                    border:1px solid rgba(0,0,0,.08); text-align:center;">
        <div class="w3-container">
            <h1 style="margin:0 0 10px; font-weight:800; letter-spacing:-0.02em;">
                The Racing Wiki
            </h1>
            <p style="margin:0 auto 16px; font-size:1.05rem; line-height:1.55; max-width:650px;">
                Explore race series, legendary drivers, iconic tracks, and event history.
                Search for pages, browse by category, and save favourites with bookmarks.
            </p>
            <form action="search.php" method="get" class="w3-margin-top"
                  style="max-width:600px; margin-left:auto; margin-right:auto;">
                <div class="input-group input-group-lg">
                    <span class="input-group-text"><i class="fas fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control" name="q"
                           placeholder="Search race pages (e.g., Le Mans, F1, NASCAR)...">
                    <button class="btn" type="submit"
                            style="background:#008080; color:#fff;">Search</button>
                </div>
            </form>
            <div class="w3-margin-top"
                 style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center;">
                <a href="#latest"     class="w3-button w3-teal w3-round-large">
                    <i class="fas fa-clock"></i> Latest Pages
                </a>
                <a href="#categories" class="w3-button w3-white w3-border w3-round-large">
                    <i class="fas fa-layer-group"></i> Browse Categories
                </a>
            </div>
        </div>
    </section>
</div>

<div style="max-width:1000px; margin:50px auto; padding:20px;">

<!-- ── LEGENDARY DRIVERS ──────────────────────────────────────────── -->
<h2 style="text-align:center; font-weight:800; font-size:2.5rem; color:#2c3e50;
           margin-bottom:30px; letter-spacing:-1px;">
    Legendary Drivers
</h2>

<div class="table-container">
    <table class="w3-table">
        <thead>
            <tr style="border-bottom:2px solid #008080;">
                <th style="color:#008080; padding:15px;">Name</th>
                <th style="color:#008080; padding:15px;">Nationality</th>
                <th style="color:#008080; padding:15px;">Category</th>
                <th style="color:#008080; padding:15px;">Achievements</th>
                <th style="color:#008080; padding:15px;">Years Active</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Join drivers -> driver_categories -> categories for the category name.
        // GROUP_CONCAT handles drivers linked to multiple categories.
        $stmt = $pdo->query("
            SELECT d.id, d.name, d.country, d.achievements, d.years_active, d.image_path,
                   GROUP_CONCAT(c.name ORDER BY c.name SEPARATOR ' / ') AS category
            FROM   drivers d
            LEFT JOIN driver_categories dc ON dc.driver_id   = d.id
            LEFT JOIN categories         c  ON c.id           = dc.category_id
            GROUP BY d.id
            ORDER  BY d.id ASC
        ");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
            $name = htmlspecialchars($row['name']);
            $img  = htmlspecialchars($row['image_path'] ?? '');
        ?>
            <tr>
                <td>
                    <div class="driver">
                        <?= $name ?>
                        <?php if ($img): ?>
                            <img src="<?= $img ?>" alt="<?= $name ?>">
                        <?php endif; ?>
                    </div>
                </td>
                <td><?= htmlspecialchars($row['country']      ?? '') ?></td>
                <td><?= htmlspecialchars($row['category']     ?? '') ?></td>
                <td><?= htmlspecialchars($row['achievements'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['years_active'] ?? '') ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div style="height:100px;"></div>

<!-- ── RECENT MAJOR EVENTS ────────────────────────────────────────── -->
<h2 style="text-align:center; font-weight:800; font-size:2.5rem; color:#2c3e50;
           margin-bottom:30px; letter-spacing:-1px;">
    Recent Major Events
</h2>

<div class="image-pair">
<?php
// Pull 3 most recent events; join race_pages -> categories for category name.
$stmt = $pdo->query("
    SELECT e.title, e.location, e.start_datetime, e.winner, e.image,
           c.name AS category
    FROM   events e
    LEFT JOIN race_pages rp ON rp.id = e.race_page_id
    LEFT JOIN categories  c  ON c.id  = rp.category_id
    ORDER  BY e.start_datetime DESC
    LIMIT  3
");
while ($ev = $stmt->fetch(PDO::FETCH_ASSOC)):
    $title    = htmlspecialchars($ev['title']);
    $location = htmlspecialchars($ev['location']  ?? '');
    $date     = $ev['start_datetime']
                ? date('F Y', strtotime($ev['start_datetime'])) : '';
    $category = htmlspecialchars($ev['category']  ?? '');
    $winner   = htmlspecialchars($ev['winner']    ?? '');
    $img      = htmlspecialchars($ev['image']     ?? '');
?>
    <div class="image-container">
        <?php if ($img): ?>
            <img src="<?= $img ?>" alt="<?= $title ?>">
        <?php endif; ?>
        <div class="overlay-text title">
            <strong><?= $title ?></strong>
        </div>
        <div class="overlay-text hover-description">
            <strong><?= $title ?></strong><br>
            <?php if ($location): ?><strong>Location:</strong> <?= $location ?><br><?php endif; ?>
            <?php if ($date):     ?><strong>Date:</strong> <?= $date ?><br><?php endif; ?>
            <?php if ($category): ?><strong>Category:</strong> <?= $category ?><br><?php endif; ?>
            <?php if ($winner):   ?><strong>Winner:</strong> <?= $winner ?><?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>
</div>

<div style="height:100px;"></div>

<!-- ── ICONIC TRACKS ──────────────────────────────────────────────── -->
<h2 style="text-align:center; font-weight:800; font-size:2.5rem; color:#2c3e50;
           margin-bottom:30px; letter-spacing:-1px;">
    Iconic Tracks
</h2>

<div class="table-container">
    <table class="w3-table">
        <thead>
            <tr style="border-bottom:2px solid #008080;">
                <th style="color:#008080; padding:15px;">Track</th>
                <th style="color:#008080; padding:15px;">Location</th>
                <th style="color:#008080; padding:15px;">Category</th>
                <th style="color:#008080; padding:15px;">Length</th>
                <th style="color:#008080; padding:15px;">Turns</th>
                <th style="color:#008080; padding:15px;">Famous For</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $stmt = $pdo->query("
            SELECT t.name, t.location, t.length_display, t.turns,
                   t.famous_for, t.image,
                   c.name AS category
            FROM   tracks t
            LEFT JOIN categories c ON c.id = t.category_id
            ORDER  BY t.id ASC
        ");
        while ($tr = $stmt->fetch(PDO::FETCH_ASSOC)):
            $tname = htmlspecialchars($tr['name']);
            $timg  = htmlspecialchars($tr['image'] ?? '');
            $turns = ($tr['turns'] === null) ? 'Varies'
                                             : htmlspecialchars($tr['turns']);
        ?>
            <tr>
                <td>
                    <div class="driver">
                        <?= $tname ?>
                        <?php if ($timg): ?>
                            <img src="<?= $timg ?>" alt="<?= $tname ?>">
                        <?php endif; ?>
                    </div>
                </td>
                <td><?= htmlspecialchars($tr['location']       ?? '') ?></td>
                <td><?= htmlspecialchars($tr['category']       ?? '') ?></td>
                <td><?= htmlspecialchars($tr['length_display'] ?? '') ?></td>
                <td><?= $turns ?></td>
                <td><?= htmlspecialchars($tr['famous_for']     ?? '') ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</div><!-- /max-width wrapper -->

<!-- ── LATEST PAGES + COMMENTS ───────────────────────────────────── -->
<section class="w3-row-padding"
         style="max-width:1000px; margin:10px auto 60px; padding:0 20px;">

    <div class="w3-col l8 m12">
        <div class="w3-padding-16" id="latest">
            <h3 style="margin:0 0 10px;">
                <i class="fas fa-clock"></i> Latest Published Pages
            </h3>
            <div class="table-container" style="padding:10px;">
            <?php
            $stmt = $pdo->query("
                SELECT rp.title, rp.slug, rp.summary, rp.created_at,
                       c.name AS category
                FROM   race_pages rp
                LEFT JOIN categories c ON c.id = rp.category_id
                WHERE  rp.is_published = 1
                ORDER  BY rp.created_at DESC
                LIMIT  5
            ");
            while ($page = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
                <div style="padding:12px 10px; border-bottom:1px solid #eee;">
                    <a href="race_page.php?slug=<?= urlencode($page['slug']) ?>"
                       style="color:#008080; font-weight:600; text-decoration:none;">
                        <?= htmlspecialchars($page['title']) ?>
                    </a>
                    <span style="font-size:0.8rem; color:#999; margin-left:8px;">
                        <?= htmlspecialchars($page['category'] ?? '') ?>
                    </span>
                    <p style="margin:4px 0 0; font-size:0.88rem; color:#666;">
                        <?= htmlspecialchars(mb_strimwidth($page['summary'] ?? '', 0, 120, '…')) ?>
                    </p>
                </div>
            <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="w3-col l4 m12">
        <div class="w3-padding-16">
            <h3 style="margin:0 0 10px;">
                <i class="fas fa-comments"></i> Latest Comments
            </h3>
            <div class="table-container" style="padding:10px;">
            <?php
            $stmt = $pdo->query("
                SELECT cm.content, cm.created_at,
                       u.username,
                       rp.title AS page_title, rp.slug
                FROM   comments cm
                JOIN   users      u  ON u.id  = cm.user_id
                JOIN   race_pages rp ON rp.id = cm.race_page_id
                WHERE  cm.is_moderated = 0
                ORDER  BY cm.created_at DESC
                LIMIT  5
            ");
            while ($cm = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
                <div style="padding:12px 10px; border-bottom:1px solid #eee;">
                    <span style="font-weight:600; color:#008080;">
                        <?= htmlspecialchars($cm['username']) ?>
                    </span>
                    <span style="font-size:0.8rem; color:#999;"> on
                        <a href="race_page.php?slug=<?= urlencode($cm['slug']) ?>"
                           style="color:#555; text-decoration:none;">
                            <?= htmlspecialchars($cm['page_title']) ?>
                        </a>
                    </span>
                    <p style="margin:4px 0 0; font-size:0.88rem; color:#666;">
                        <?= htmlspecialchars(mb_strimwidth($cm['content'], 0, 100, '…')) ?>
                    </p>
                </div>
            <?php endwhile; ?>
            </div>
        </div>
    </div>

</section>

<?php include 'footer.php'; ?>