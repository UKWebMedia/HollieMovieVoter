<?php
include('db.php');

$url = "http://www.omdbapi.com/?t=";

$sql = "SELECT * FROM `movies`";
$movies = $db->query($sql);

foreach ($movies as $movie) {
	if (!empty($movie['imdb_rating'])) {
		continue;
	}

	echo $movie['name'] . "<br>";

	$data = file_get_contents($url . urlencode($movie['name']));
	$dataClass = json_decode($data);
	if ($dataClass === null || $dataClass === false) {
		echo "Failed to find: " . $movie['name'];
	}

	if (isset($dataClass->Poster) && $dataClass->Poster !== 'N/A') {
		$type = pathinfo($dataClass->Poster, PATHINFO_EXTENSION);
		$data = file_get_contents($dataClass->Poster);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	} else {
		$base64 = null;
	}

	$sql = "UPDATE `movies` SET ";

	if (isset($dataClass->Year) && $dataClass->Year !== 'N/A') {
		$sql .= "year = '" . $dataClass->Year . "', ";
	}

	if (isset($dataClass->Plot) && $dataClass->Plot !== 'N/A') {
		$sql .= "plot = '" . $db->escape_string($dataClass->Plot) . "', ";
	}

	if (isset($dataClass->imdbRating) && $dataClass->imdbRating !== 'N/A') {
		$sql .= "imdb_rating = '" . $db->escape_string($dataClass->imdbRating) . "', ";
	}

	if (isset($dataClass->Metascore) && $dataClass->Metascore !== 'N/A') {
		$sql .= "meta_rating = '" . $dataClass->Metascore . "', ";
	}

	$sql = rtrim($sql, ', ');
	$where = " WHERE id = '" . $movie['id'] . "'";
	$sql .= $where;
	$db->query($sql);
	var_dump($db->error);
}

echo "All done!";
