<?php
include('../lib/db.php');

if (isset($_POST) && !empty($_POST)) {

	// User wants to recycle a vote
	if ($_POST['vote'] === 'recycle') {
		$sql = "DELETE FROM `votes` WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND movie_id = '" . (int)$_POST['id'] . "'";
		$db->query($sql);

		$sql = "UPDATE `movies` SET upvotes = upvotes - 1 WHERE id = '" . (int)$_POST['id'] . "'";
		$db->query($sql);

		echo json_encode(['message' => 'Your vote has been recycled.', 'type' => $_POST['vote']]);
		exit;
	}

	// Check how many votes the user has left
	$sql = "SELECT * FROM `votes` WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "'";
	$db->query($sql);
	if ($db->affected_rows >= 20) {
		echo json_encode(['message' => 'You\'ve used up all your votes. Recycle some votes.', 'type' => $_POST['vote']]);
		exit;
	}

	// Check the user hasn't already voted for this movie
	$sql = "SELECT * FROM `votes` WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND movie_id = " . (int)$_POST['id'];
	$db->query($sql);
	if ($db->affected_rows > 0) {
		echo json_encode(['message' => 'You have already voted for this movie.', 'type' => $_POST['vote']]);
		exit;
	}

	if ($_POST['vote'] === 'up' && is_string($_POST['vote'])) {
		$sql = "UPDATE `movies` SET upvotes = upvotes + 1 WHERE id = " . (int)$_POST['id'];
	} else {
		$sql = "UPDATE `movies` SET downvotes = downvotes + 1 WHERE id = " . (int)$_POST['id'];
	}

	if ($db->query($sql)) {
		// Log the users vote
		$sql = "INSERT INTO `votes` (ip, movie_id, voted, created) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "', '" . (int)$_POST['id'] . "', '" . $_POST['vote'] . "', NOW())";
		$db->query($sql);

		// Get the new number of votes
		$sql = "SELECT * FROM `movies` WHERE id = " . (int)$_POST['id'];
		$result = $db->query($sql);
	}

	echo json_encode($result->fetch_assoc());
}
