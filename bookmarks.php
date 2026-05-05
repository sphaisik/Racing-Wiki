<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <?php
    include "header.php";

    // Database connection parameters
    $host = 'localhost';
    $db   = 'racing_wiki';
    $user = 'root';
    $pass = '';

    // Create connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_SESSION['user_id'])):
        echo "<h2>You are not logged in.<h2>";

    else:
        $user_id = $_SESSION['user_id'];

        $stmt = $conn->prepare("
            SELECT b.id AS bookmark_id, r.id AS page_id, r.title, r.slug, r.summary, r.category_id, b.created_at
            FROM bookmarks b
            INNER JOIN race_pages r ON r.id = b.race_page_id
            WHERE b.user_id = ?
            ORDER BY b.created_at DESC
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $bookmarks = $result->fetch_all(MYSQLI_ASSOC);
        ?>

        <!DOCTYPE html>
        <html>
        <head>

        </head>
        <body>
            <section class="w3-panel w3-padding-16 w3-round-large w3-card"
                     style="margin-top: 18px;
                     background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                     border: 1px solid rgba(0,0,0,.08);">
                <h1 style="margin: 0 0 10px; font-weight: 800; letter-spacing: -0.02em;">
                    My Bookmarks
                </h1>

                <?php if (empty($bookmarks)): ?>
                    <section class="w3-panel w3-padding-16 w3-round-large w3-card"
                             style="margin-top: 18px;
                             background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                             border: 1px solid rgba(0,0,0,.08);">
                        <div style="padding:20px; text-align:center;">
                            <p><strong>You haven’t bookmarked any pages yet.</strong></p>
                            <p>Explore the wiki and save pages to see them here.</p>
                            <a href="search.php">Explore Pages</a>
                        </div>
                    </section>
                <?php else: ?>

                    <?php foreach ($bookmarks as $entry): ?>
                        <section class="w3-panel w3-padding-16 w3-round-large w3-card"
                                 style="margin-top: 18px;
                                 background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                                 border: 1px solid rgba(0,0,0,.08);">

                            <h3>
                                <a href="/page.php?slug=<?= htmlspecialchars($entry['slug']) ?>">
                                    <?= htmlspecialchars($entry['title']) ?>
                                </a>
                            </h3>

                            <p><?= htmlspecialchars($entry['summary']) ?></p>

                            <small>Bookmarked on: <?= htmlspecialchars($entry['created_at']) ?></small>

                            <form method="POST" action="bookmarkRemove.php" style="margin-top:10px;">
                                <input type="hidden" name="bookmark_id" value="<?= $entry['bookmark_id'] ?>">
                                <button class="w3-button w3-block w3-section w3-teal w3-ripple w3-padding" type="submit">Remove this Bookmark</button>
                            </form>

                        </section>
                    <?php endforeach; ?>

                <?php endif;
            endif;
            ?>
            </section>
        </body>
        </html>
<?php include 'footer.php'; ?>
