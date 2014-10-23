<?php
if (isset($_POST) && !empty($_POST)) {
	$type = pathinfo($_POST['image'], PATHINFO_EXTENSION);
	$data = file_get_contents($_POST['image']);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

	echo $base64;
}
?>
<form action="/lib/make_cover.php" method="post">
	<input name="image" id="image" type="text">
	<input type="submit" value="Create">
</form>
