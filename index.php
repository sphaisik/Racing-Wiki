<?php include 'header.php'; ?>
<style>
/* Table*/
.table-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    margin-bottom: 50px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th { /*table col titles style*/
    text-align: left;
    padding: 16px 12px;
    background: #fdfdfd;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
}

td {/*table data style*/
    padding: 15px 12px;
    border-bottom: 1px solid #eee;
    color: #444;
    position: relative; 
}

/*driver hover in table*/
.driver {/*Driver name style*/
    position: relative;
    cursor: pointer;
    color: #008080; 
    font-weight: bold;
    display: inline-block;
}

.driver img {/*driver image style*/
    position: absolute;
    top: 40px; 
    right: 0;
    width: 220px; 
    border-radius: 12px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.4);
    opacity: 0; /*invisible until hover*/
    transform: translateY(15px) scale(0.95);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
    pointer-events: none;
    border: 3px solid #fff;
}

.driver:hover img {/*image appear at hover*/
    opacity: 1;
    transform: translateY(0) scale(1);
}

tr:hover {
    background-color: #f4fdfd;
    position: relative;
    z-index: 10;
}





/*Image hover, image-container blurs on hover, image-container-1 does not*/
.image-container-1, .image-container{
    position: relative;
    width: 400px;
    height: 250px;
    overflow: hidden; 
    border-radius: 8px; /*round edges*/
}


.image-container-1 img, .image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    filter: blur(0px);
    transition: filter 0.5s ease-in-out; /*for blur fade-out*/
}

.image-container:hover img { /*image blur*/
    filter: blur(5px);/*higher value,: more blur*/
}

.overlay-text {
    position: absolute;
    top: 20px;
    left: 20px;
    color: white;
    padding: 10px 15px;
    z-index: 10;
}

.title {
    opacity: 1;
}

.hover-description { /*description hidden*/
    opacity: 0;
}

.image-container-1:hover .hover-description, .image-container:hover .hover-description { /*Show description when hover*/
    opacity: 1;
    background: rgba(0,0,0,0.5);
}

.image-pair { /*put images sub-classes in a row*/
    display: flex;  
    gap: 20px; /*space between*/
}
    </style>

    
    <div style="display: flex; justify-content: center; align-items: center; min-height: 50vh; padding: 20px; ">
    
    <section class="w3-panel w3-padding-32 w3-round-large w3-card"
         style="margin: 40px auto; 
                max-width: 900px; 
                background: linear-gradient(135deg, rgba(0,128,128,.18), rgba(0,0,0,.06));
                border: 1px solid rgba(0,0,0,.08);
                text-align: center;"> <div class="w3-container">
        <h1 style="margin: 0 0 10px; font-weight: 800; letter-spacing: -0.02em;">
            The Racing Wiki
        </h1>
        
        <p style="margin: 0 auto 16px; font-size: 1.05rem; line-height: 1.55; max-width: 650px;">
            Explore race series, legendary drivers, iconic tracks, and event history. Search for pages,
            browse by category, and save favorites with bookmarks.
        </p>

        <form action="search.php" method="get" class="w3-margin-top" style="max-width: 600px; margin-left: auto; margin-right: auto;">
            <div class="input-group input-group-lg">
                <span class="input-group-text"><i class="fas fa-magnifying-glass"></i></span>
                <input type="text" class="form-control" name="q" placeholder="Search race pages (e.g., Le Mans, F1, NASCAR)...">
                <button class="btn btn-teal" type="submit" style="background:#008080; color:#fff;">
                    Search
                </button>
            </div>
        </form>

        <div class="w3-margin-top" style="display:flex; gap:10px; flex-wrap:wrap; justify-content: center;">
            <a href="#latest" class="w3-button w3-teal w3-round-large">
                <i class="fas fa-clock"></i> Latest Pages
            </a>
            <a href="#categories" class="w3-button w3-white w3-border w3-round-large">
                <i class="fas fa-layer-group"></i> Browse Categories
            </a>
        </div>
    </div>
</section>

</div>

<div style="max-width: 1000px; margin: 50px auto; padding: 20px;">

    <h2 style="text-align: center; font-weight: 800; font-size: 2.5rem; color: #2c3e50; margin-bottom: 30px; letter-spacing: -1px;">
        Legendary Drivers
    </h2>

    <div class="table-container">
        <table class="w3-table">
            <thead>
                <tr style="border-bottom: 2px solid #008080;">
                    <th style="color: #008080; padding: 15px;">Name</th>
                    <th style="color: #008080; padding: 15px;">Nationality</th>
                    <th style="color: #008080; padding: 15px;">Category</th>
                    <th style="color: #008080; padding: 15px;">Achievements</th>
                    <th style="color: #008080; padding: 15px;">Years Active</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="driver">
                            Michael Schumacher
                            <img src="driver-img/Michael-Schumacher.jpg" alt="Michael Schumacher">
                        </div>
                    </td>
                    <td>Germany</td>
                    <td>F1</td>
                    <td>7× World Champion</td>
                    <td>1991–2012</td>
                </tr>

                <tr>
                    <td>
                        <div class="driver">
                            Lewis Hamilton
                            <img src="driver-img/Lewis-Hamilton.jpg" alt="Lewis Hamilton">
                        </div>
                    </td>
                    <td>UK</td>
                    <td>F1</td>
                    <td>7× World Champion</td>
                    <td>2007–Present</td>
                </tr>

                <tr>
                    <td>
                        <div class="driver">
                            Sébastien Loeb
                            <img src="driver-img/Sébastien-Loeb.jpg" alt="Sébastien Loeb">
                        </div>
                    </td>
                    <td>France</td>
                    <td>Rally (WRC)</td>
                    <td>9× World Champion</td>
                    <td>1999–Present</td>
                </tr>

                <tr>
                    <td>
                        <div class="driver">
                            Sébastien Ogier
                            <img src="driver-img/Sébastien-Ogier.jpg" alt="Sébastien Ogier">
                        </div>
                    </td>
                    <td>France</td>
                    <td>Rally (WRC)</td>
                    <td>8× World Champion</td>
                    <td>2007–Present</td>
                </tr>

                <tr>
                    <td>
                        <div class="driver">
                            John Force
                            <img src="driver-img/John-Force.jpg" alt="John Force">
                        </div>
                    </td>
                    <td>USA</td>
                    <td>Drag Racing</td>
                    <td>16× NHRA Champion</td>
                    <td>1978–Present</td>
                </tr>

                <tr>
                    <td>
                        <div class="driver">
                            Dale Earnhardt Sr.
                            <img src="driver-img/Dale-Earnhardt.jpg" alt="Dale Earnhardt">
                        </div>
                    </td>
                    <td>USA</td>
                    <td>NASCAR</td>
                    <td>7× Cup Series Champion</td>
                    <td>1975–2001</td>
                </tr>

                <tr>
                    <td>
                        <div class="driver">
                            Jimmie Johnson
                            <img src="driver-img/Jimmie-Johnson.jpg" alt="Jimmie Johnson">
                        </div>
                    </td>
                    <td>USA</td>
                    <td>NASCAR</td>
                    <td>7× Cup Series Champion</td>
                    <td>2001–Present</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="height: 100px;"></div>
    
        <h2 style="text-align: center; font-weight: 800; font-size: 2.5rem; color: #2c3e50; margin-bottom: 30px; letter-spacing: -1px;">
                Recent major events
    </h2>
    
      <div class="image-pair">
        <div class="image-container">
            <img src="event/2025-Indianapolis-500.webp" >
            
            <div class="overlay-text title">
                <strong>2025 Indianapolis 500</strong>
            </div>

            <div class="overlay-text hover-description">
                <strong>2025 Indianapolis 500</strong><br>
                <strong>Location:</strong> Indianapolis<br> 
                <strong>USA Date:</strong> May 2025<br> 
                <strong>Category:</strong> IndyCar<br> 
                <strong>Winner:</strong> Josef Newgarden</div>
        </div>
          
          <div class="image-container">
            <img src="event/24h-Le-Mans-2024.jpg">

            <div class="overlay-text title">
                <strong>24 Hours of Le Mans (2024)</strong>
            </div>

            <div class="overlay-text hover-description">
                <strong>24 Hours of Le Mans (2024)</strong><br>
                <strong>Location:</strong> Le Mans, France<br> 
                <strong>Date:</strong> June 2024<br> 
                <strong>Category:</strong> Endurance Racing (WEC)<br> 
                <strong>Winner:</strong> Ferrari
            </div>
        </div>
          
          <div class="image-container">
            <img src="event/F1-Season-Finale-2025.jpg">

            <div class="overlay-text title">
                <strong>F1 Season Finale (2025)</strong>
            </div>

            <div class="overlay-text hover-description">
                <strong>F1 Season Finale (2025)</strong><br>
                <strong>Location:</strong> Abu Dhabi, UAE<br> 
                <strong>Date:</strong> December 2025<br> 
                <strong>Category:</strong> Formula One<br> 
                <strong>Winner:</strong> Max Verstappen
            </div>
        </div>
      </div>
          
    <div style="height: 100px;"></div>

    
    <h2 style="text-align: center; font-weight: 800; font-size: 2.5rem; color: #2c3e50; margin-bottom: 30px; letter-spacing: -1px;">
    Iconic Tracks
</h2>

<div class="table-container">
    <table class="w3-table">
        <thead>
            <tr style="border-bottom: 2px solid #008080;">
                <th style="color: #008080; padding: 15px;">Track</th>
                <th style="color: #008080; padding: 15px;">Location</th>
                <th style="color: #008080; padding: 15px;">Category</th>
                <th style="color: #008080; padding: 15px;">Length</th>
                <th style="color: #008080; padding: 15px;">Turns</th>
                <th style="color: #008080; padding: 15px;">Famous For</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>
                    <div class="driver">
                        Monte Carlo Rally
                        <img src="track-img/Monte-Carlo-Rally.jpg" alt="Monte Carlo Rally">
                    </div>
                </td>
                <td>Monaco</td>
                <td>Rally (WRC)</td>
                <td>~300 km stages</td>
                <td>Varies</td>
                <td>Snow & tarmac mix</td>
            </tr>

            <tr>
                <td>
                    <div class="driver">
                        Gainesville Raceway
                        <img src="track-img/Gainesville-Raceway-Drag.jpg" alt="Gainesville Raceway">
                    </div>
                </td>
                <td>USA</td>
                <td>Drag Racing</td>
                <td>402 m</td>
                <td>0</td>
                <td>NHRA events</td>
            </tr>

            <tr>
                <td>
                    <div class="driver">
                        Pocono Raceway
                        <img src="track-img/Pocono-Raceway-NASCAR.jpg" alt="Pocono Raceway">
                    </div>
                </td>
                <td>USA</td>
                <td>NASCAR</td>
                <td>2.5 mi</td>
                <td>3</td>
                <td>Tricky Triangle</td>
            </tr>

            <tr>
                <td>
                    <div class="driver">
                        Indianapolis Motor Speedway
                        <img src="track-img/Indianapolis-Motor-Speedway-NASCAR.jpg" alt="Indianapolis Motor Speedway">
                    </div>
                </td>
                <td>USA</td>
                <td>NASCAR / IndyCar</td>
                <td>2.5 mi</td>
                <td>4</td>
                <td>>The Brickyard</td>
            </tr>

            <tr>
                <td>
                    <div class="driver">
                        Circuit de Monaco
                        <img src="track-img/Monte-Carlo-F1.jpg" alt="Monaco F1">
                    </div>
                </td>
                <td>Monaco</td>
                <td>F1</td>
                <td>3.34 km</td>
                <td>19</td>
                <td>>Tight street circuit</td>
            </tr>

            <tr>
                <td>
                    <div class="driver">
                        Suzuka Circuit
                        <img src="track-img/Suzuka-Circuit-F1.jpg" alt="Suzuka Circuit">
                    </div>
                </td>
                <td>Japan</td>
                <td>F1</td>
                <td>5.81 km</td>
                <td>18</td>
                <td>Figure-8 layout</td>
            </tr>

        </tbody>
    </table>
</div>
    
</div>



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
