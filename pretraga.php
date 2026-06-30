<?php
// Čitanje XML-a
$xml = simplexml_load_file('studenti.xml');

if ($xml === false) {
    echo '<div class="error-box"><h2>❌ Greška</h2><p>Ne mogu učitati podatke o studentima.</p></div>';
    return;
}

$ime = isset($_GET['ime']) ? trim($_GET['ime']) : '';
$prezime = isset($_GET['prezime']) ? trim($_GET['prezime']) : '';

$pronadjen = false;
$studentPodaci = null;

if ($ime && $prezime) {
    foreach ($xml->Student as $student) {
        if (strtolower((string)$student->Ime) == strtolower($ime) && 
            strtolower((string)$student->Prezime) == strtolower($prezime)) {
            $pronadjen = true;
            $studentPodaci = $student;
            break;
        }
    }
}

if ($pronadjen && $studentPodaci) {
    $ukupno = 0;
    $broj = 0;
    $kolokviji_data = [];
    foreach ($studentPodaci->Kolokviji->Kolokvij as $kolokvij) {
        $bodovi = (int)$kolokvij;
        $max = (int)$kolokvij['Maksimum'];
        $postotak = round(($bodovi / $max) * 100);
        $kolokviji_data[] = [
            'naziv' => (string)$kolokvij['Naziv'],
            'bodovi' => $bodovi,
            'max' => $max,
            'postotak' => $postotak
        ];
        $ukupno += $bodovi;
        $broj++;
    }
    $prosjek = $ukupno / $broj;
    
    if ($prosjek >= 27) $ocjena = "Odličan (5)";
    elseif ($prosjek >= 22) $ocjena = "Vrlo dobar (4)";
    elseif ($prosjek >= 17) $ocjena = "Dobar (3)";
    elseif ($prosjek >= 12) $ocjena = "Dovoljan (2)";
    else $ocjena = "Nedovoljan (1)";
    ?>
    <div id="rezultati-student" class="rezultati-box">
        <div class="student-header">
            <h2>📊 Rezultati za: <?php echo $studentPodaci->Ime . " " . $studentPodaci->Prezime; ?></h2>
            <button onclick="window.print()" class="print-btn">🖨️ Ispiši</button>
        </div>
        <div class="student-info">
            <span><strong>Grupa:</strong> <?php echo $studentPodaci->Grupa; ?></span>
            <span><strong>Godina:</strong> <?php echo $studentPodaci->Godina; ?></span>
            <span><strong>JMBG:</strong> <?php echo $studentPodaci->JMBG; ?></span>
        </div>
        <h3>📝 Rezultati kolokvija:</h3>
        <div class="table-responsive">
            <table class="rezultati-tablica">
                <thead>
                    <tr>
                        <th>Naziv</th>
                        <th>Bodovi</th>
                        <th>Maksimum</th>
                        <th>Postotak</th>
                        <th>Graf</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kolokviji_data as $kolokvij): ?>
                        <?php 
                        $boja = $kolokvij['postotak'] >= 80 ? '#4CAF50' : ($kolokvij['postotak'] >= 60 ? '#FF9800' : '#f44336');
                        ?>
                        <tr>
                            <td><strong><?php echo $kolokvij['naziv']; ?></strong></td>
                            <td><strong><?php echo $kolokvij['bodovi']; ?></strong></td>
                            <td><?php echo $kolokvij['max']; ?></td>
                            <td style="color: <?php echo $boja; ?>; font-weight: bold;">
                                <?php echo $kolokvij['postotak']; ?>%
                            </td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $kolokvij['postotak']; ?>%; background: <?php echo $boja; ?>;"></div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="prosjek-red">
                        <td colspan="3" style="text-align: right;"><strong>Prosjek:</strong></td>
                        <td><strong><?php echo number_format($prosjek, 2); ?></strong></td>
                        <td></td>
                    </tr>
                    <tr class="ocjena-red">
                        <td colspan="3" style="text-align: right;"><strong>Zaključna ocjena:</strong></td>
                        <td colspan="2" style="color: #1565C0; font-size: 1.3em; font-weight: bold;">
                            <?php echo $ocjena; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
} elseif ($ime && $prezime) {
    ?>
    <div class="error-box">
        <h2 style="color: #c62828;">❌ Student nije pronađen</h2>
        <p>Provjerite da li ste ispravno unijeli ime i prezime.</p>
    </div>
    <?php
}
?>