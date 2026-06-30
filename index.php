<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Rezultati kolokvija</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,700,800" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <div id="menu-wrapper">
            <div id="menu" class="container">
                <ul>
                    <li class="current_page_item"><a href="index.php">🏠 Početna</a></li>
                    <li><a href="studenti.xml">📋 Svi studenti</a></li>
                    <li><a href="kontakt.html">📞 Kontakt</a></li>
                </ul>
            </div>
        </div>
        
        <div id="page" class="container">
            <div class="title">
                <h2>📊 Pregled rezultata kolokvija</h2>
                <span class="byline">Unesite svoje ime i prezime za pregled rezultata</span>
            </div>
            
            <div class="pretraga-box">
                <h3>🔍 Pretraži svoje rezultate</h3>
                <form method="GET" action="index.php">
                    <div class="input-group">
                        <input type="text" name="ime" placeholder="Ime" required value="<?php echo isset($_GET['ime']) ? htmlspecialchars($_GET['ime']) : ''; ?>">
                        <input type="text" name="prezime" placeholder="Prezime" required value="<?php echo isset($_GET['prezime']) ? htmlspecialchars($_GET['prezime']) : ''; ?>">
                        <button type="submit">🔍 Traži</button>
                    </div>
                </form>
            </div>
            
            <?php include 'pretraga.php'; ?>
            
            <?php
            if (file_exists('rezultati.json')) {
                $json = file_get_contents('rezultati.json');
                $stats = json_decode($json, true);
                if ($stats) {
            ?>
            <div class="statistika">
                <div class="stat-kartica">
                    <div class="broj"><?php echo $stats['statistika']['ukupno_studenata']; ?></div>
                    <div class="label">Ukupno studenata</div>
                </div>
            <?php
                $prosjekBodovi = $stats['statistika']['prosjek_svih'];
                if ($prosjekBodovi >= 27) $prosjekOcjena = 5;
                elseif ($prosjekBodovi >= 22) $prosjekOcjena = 4;
                elseif ($prosjekBodovi >= 17) $prosjekOcjena = 3;
                elseif ($prosjekBodovi >= 12) $prosjekOcjena = 2;
                else $prosjekOcjena = 1;
            ?>
<div class="stat-kartica">
    <div class="broj"><?php echo $prosjekOcjena; ?></div>
    <div class="label">Prosjek svih ocjena</div>
</div>
                <div class="stat-kartica">
                    <div class="broj"><?php echo $stats['statistika']['prolaznost']; ?>%</div>
                    <div class="label">Prolaznost</div>
                </div>
                <div class="stat-kartica">
                    <div class="broj"> <?php echo $stats['statistika']['najbolji_student']; ?></div>
                    <div class="label">🏆Najbolji student</div>
                </div>
            </div>
            <?php 
                }
            }
            ?>
            
            <h2 style="text-align: center; margin: 40px 0 20px;">Vizualni prikaz podataka</h2>
            <div class="chart-container">
                <div class="chart-box">
                    <h3>Prosjeci po kolokviju</h3>
                    <canvas id="chart-kolokviji"></canvas>
                </div>
                <div class="chart-box">
                    <h3>Prolaznost po godinama</h3>
                    <canvas id="chart-godine"></canvas>
                </div>
                <div class="chart-box">
                    <h3>Top 5 studenata</h3>
                    <canvas id="chart-rang"></canvas>
                </div>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="studenti.xml" class="button">📋 Pogledaj sve studente</a>
            </div>
        </div>
    </div>
    
    <div id="copyright" class="container">
        <p>© 2026 - Sustav za pregled rezultata kolokvija</p>
    </div>
    
    <script src="script.js"></script>
</body>
</html>