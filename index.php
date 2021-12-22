<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>

    <form action="index.php" method="POST">
        <select name="months" id="months">
            <option value="">--Choix du mois--</option>
            <?php
            $arrayMonths = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'];
            foreach ($arrayMonths as $num => $months) { ?>
                <option value="<?= $num ?>"><?= $months ?></option>
            <?php }
            ?>
        </select>

        <select name="years" id="years">
            <option value="">--Choix de l'année--</option>
            <?php
            for ($i = 1980; $i <= 2023; $i++) { ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php }
            ?>
        </select>
        <input class="button" type="submit" name="display" value="Afficher">
    </form>

    <?php
    if (isset($_POST['display'])) {
        if (!empty($_POST['months']) && !empty($_POST['years'])) {
            
            //Affichage du mois et de l'année en en-tête de page
            $month = $arrayMonths[$_POST['months']];
            echo '<h1 class="monthYear">' . $month . " " . $_POST['years'] . '</h1>';
            $numDays = cal_days_in_month(CAL_GREGORIAN, $_POST['months'], $_POST['years']);

            //Affichage de l'en-tête du calendrier 
            echo '<div class="gridCalendar">';
            $arrayDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            foreach ($arrayDays as $day) {
                echo "<p class='calendarDay'>$day</p>";
            }
            for ($d = 1; $d <= $numDays; $d++) {
                //Format de la date pour affichage
                $dateTempo = $_POST['years'] . "-" . $_POST['months'] . "-" . $d;
                $date = date_create($dateTempo);

                //Jours fériés mobiles
                $holiday = $_POST['months'] . "-" . $d;
                $dateEaster = strtotime(date("Y-m-d", easter_date($_POST['years'])) . "+ 1 days");
                $easter = date("n-j", $dateEaster);
                $dateEasterMon = strtotime(date("Y-m-d", easter_date($_POST['years'])) . "+ 2 days");
                $easterMon = date("n-j", $dateEasterMon);
                $dateThuAscen = strtotime(date("Y-m-d", easter_date($_POST['years'])) . "+ 40 days");
                $thuAscen = date("n-j", $dateThuAscen);
                $dateMonPent = strtotime(date("Y-m-d", easter_date($_POST['years'])) . "+ 51 days");
                $monPent = date("n-j", $dateMonPent);

                //Table des jours fériés fixes et mobiles
                $arrayHoliday = ['1-1', '5-1', '5-8', '7-14', '8-15', '11-1', '11-11', '12-25', $easter, $easterMon, $thuAscen, $monPent];

                //Affichage du calendrier avec jours fériés
                if (in_array($holiday, $arrayHoliday)) {
                    echo '<p class="' . date_format($date, 'D') . ' days holiday">' . $d . '</p>';
                } else {
                    echo '<p class="' . date_format($date, 'D') . ' days">' . $d . '</p>';
                }
            }
            echo '</div>';

            
        }
    }
    ?>
</body>

</html>