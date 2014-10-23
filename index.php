<?php
include('lib/db.php');

$sql = "SELECT * FROM `movies` ORDER BY upvotes DESC, `name` ASC";
$movies = $db->query($sql);
?>

<!DOCTYPE html>
	<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
	<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
	<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
	<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Movie Voter</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="vendor/components/normalize.css/normalize.css">
		<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="css/main.css">

		<script src="vendor/components/modernizr/modernizr.js"></script>
	</head>
	<body>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="well">
						<h1>The Hollie Movie Voter!</h1>
						<p class="lead">Upvote your favourite films! <b>Only 20 votes per person</b>, choose wisely, votes are non-refundable!.</p>
						<p>Refresh the page to see how your scores have affected the table.</p>
					</div>
				</div>

				<div class="col-md-12">
					<h2>Movie list</h2>

					<?php foreach ($movies as $movie):?>
						<div class="movie">
							<div class="votes">
								<span class='vote up' data-vote="up" data-id="<?php echo $movie['id'];?>"><span class='glyphicon glyphicon-arrow-up'></span></span>
								<span class="votes"><?php echo $movie['upvotes'] - $movie['downvotes'];?></span>
								<!-- <span class='vote down' data-vote="down" data-id="<?php echo $movie['id'];?>"><span class='glyphicon glyphicon-arrow-down'></span></span> -->
							</div>
							<div class="cover"><?php
								if (!empty($movie['cover'])) {
									echo "<img src='{$movie['cover']}'>";
								}
							?></div>
							<div class="film">
								<h3><?php echo $movie['name'];?> (<?php echo $movie['year'];?>)</h3>
								<p><?php echo $movie['plot'];?></p>
							</div>
							<div class="meta">
								<p>imdb: <?php echo $movie['imdb_rating'];?>/10</p>
								<p> metascore: <?php echo $movie['meta_rating'];?>/100</p>	
							</div>
							<div class="clearfix"><!-- empty --></div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>

		<div id="loading" style="display: none;">
			<img src="img/ajax-loader.gif" alt="Loading..">
		</div>

		<div id="too-many-votes" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="TooManyVotes" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Sorry!</h4>
					</div>
					<div class="modal-body">
						<p>You've used up all your votes, or you are trying to vote on the same movie twice.</p>
					</div>
				</div>
			</div>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="vendor/components/jquery/jquery-1.10.2.min.js"><\/script>')</script>
		<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="js/main.js"></script>
	</body>
</html>
