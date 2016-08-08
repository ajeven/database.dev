<?php
require __DIR__ . '/../src/Input.php';
function pageController()
{
$dbc = new PDO('mysql:host=localhost;dbname=the_league_db', 'vagrant', 'vagrant', [
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
]);
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$teamId = Input::get('team_id', '3');

$sql = 
"SELECT
(
SELECT Count(*) 
    FROM games WHERE (local_team_runs > visitor_team_runs AND local_team_id = t.id)
    OR (visitor_team_runs > local_team_runs AND visitor_team_id = t.id)
) AS 'Games Won', (

SELECT Count(*) 
    FROM games WHERE (local_team_runs < visitor_team_runs AND local_team_id = t.id)
    OR (visitor_team_runs < local_team_runs AND visitor_team_id = t.id)
) AS 'Games Lost', (

SELECT Count(*) 
    FROM games WHERE local_team_runs > visitor_team_runs AND local_team_id = t.id
) AS 'Local Wins', (

SELECT Count(*) 
    FROM games WHERE local_team_runs < visitor_team_runs AND visitor_team_id = t.id) AS 'Away Wins', t.name FROM teams t WHERE id = $teamId;";

    $statistics = $dbc->query($sql)->fetch(PDO::FETCH_NUM);
    $name = array_pop($statistics);

    return [
        'title' => $name,
        'statistics' => $statistics,
    ];
}
extract(pageController());
?>
<!DOCTYPE html>
<html>
<head>
    <?php include '../partials/head.phtml' ?>
</head>
<body>
<div class="container">
    <div class="row">
        <header class="page-header">
            <h1>Statistics</h1>
        </header>
    </div>
    <div class="row">
        <canvas id="stats-chart"></canvas>
    </div>
</div>
<?php include '../partials/scripts.phtml' ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.0/Chart.bundle.min.js">
</script>
<script>
    var ctx = $('#stats-chart').get(0).getContext("2d");
    ctx.canvas.height = 300;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Won", "Lost", "Won as local", "Won as visitor"],
            datasets: [{
                label: 'Games',
                // `data` should be a JS array with the 4 numbers from the result set.
                data: <?= json_encode($statistics) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            maintainAspectRatio: false
        }
    });
</script>
</body>
</html>