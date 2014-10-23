<?php
include('db.php');

$url = "http://www.omdbapi.com/?t=";

$sql = "SELECT * FROM `movies`";
$movies = $db->query($sql);

foreach ($movies as $movie) {
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

	if (!isset($dataClass->Year) || $dataClass->Year === 'N/A') {
		$dataClass->Year = null;
	}

	if (!isset($dataClass->Plot) || $dataClass->Plot === 'N/A') {
		$dataClass->Plot = null;
	}

	if (!isset($dataClass->imdbRating) || $dataClass->imdbRating === 'N/A') {
		$dataClass->imdbRating = null;
	}

	if (!isset($dataClass->Metascore) || $dataClass->Metascore === 'N/A') {
		$dataClass->Metascore = null;
	}

	$sql = "UPDATE `movies` SET cover = '" . $base64 . "', year = '" . $dataClass->Year . "', plot = '" . $db->escape_string($dataClass->Plot) . "', imdb_rating = '" . $dataClass->imdbRating . "', meta_rating = '" . $dataClass->Metascore . "' WHERE id = '" . $movie['id'] . "'";
	$db->query($sql);

}

echo "All done!";
