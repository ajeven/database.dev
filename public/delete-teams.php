<?php
require __DIR__ . '/../src/Input.php';
function pageController()
{
	$teams = Input::get('teams', []);  // You'll get an array with team IDs
	// You can var_dump the values if you're curious
	// var_dump($teams);
		// Generate the DELETE statement for each team_id
		$teamsString = implode(", ", $teams);
		$delete = "DELETE FROM teams WHERE id IN ($teamsString)";
		// Copy and paste the statements in SQL PRO and verify they're correct.
		var_dump($delete);
	// In a real scenario you would normally redirect to the list of teams.
	// header('Location: teams.php');
}
pageController();