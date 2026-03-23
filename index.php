<?php include 'header.php'; ?>


<section class="w3-panel w3-padding-32 w3-round-large w3-card"
         style="margin-top: 18px;
                background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                border: 1px solid rgba(0,0,0,.08);">
    <div class="w3-row-padding" style="display: grid; grid-template-columns: 1.2fr .8fr; gap: 18px;">
        <div>
            <h1 style="margin: 0 0 10px; font-weight: 800; letter-spacing: -0.02em;">
                The Racing Wiki
            </h1>
            <p style="margin: 0 0 16px; font-size: 1.05rem; line-height: 1.55;">
                Explore race series, legendary drivers, iconic tracks, and event history. Search for pages,
                browse by category, and save favorites with bookmarks.
            </p>

            <form action="search.php" method="get" class="w3-margin-top">
                <div class="input-group input-group-lg">
                    <span class="input-group-text"><i class="fas fa-magnifying-glass"></i></span>
                    <input type="text" class="form-control" name="q" placeholder="Search race pages (e.g., Le Mans, F1, NASCAR)...">
                    <button class="btn btn-teal" type="submit" style="background:#008080; color:#fff;">
                        Search
                    </button>
                </div>
            </form>

            <div class="w3-margin-top" style="display:flex; gap:10px; flex-wrap:wrap;">
                <a href="#latest" class="w3-button w3-teal w3-round-large">
                    <i class="fas fa-clock"></i> Latest Pages
                </a>
                <a href="#categories" class="w3-button w3-white w3-border w3-round-large">
                    <i class="fas fa-layer-group"></i> Browse Categories
                </a>
            </div>
        </div>
    </div>
</section>

<!-- MAIN GRID -->
<section class="w3-row-padding" style="margin-top: 10px;">
    <div class="w3-col l8 m12">
        <!-- Latest pages -->
        <div class="w3-padding-16" id="latest">
            <h3 style="margin: 0 0 10px;"><i class="fas fa-clock"></i> Latest Published Pages</h3>
        </div>
    </div>
        <!-- Latest comments -->
        <div class="w3-padding-16">
            <h3 style="margin: 0 0 10px;"><i class="fas fa-comments"></i> Latest Comments</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
