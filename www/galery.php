<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css/menu.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <meta charset="UTF-8" />
</head>
<body>
<div class="container">
  <?php include 'menu.html'; ?>
  <p>
  <div>
      <a class="fancybox" href="cameras/moko_01.jpg" title="Morskie Oko"> <img src="cameras/moko_01.jpg" width="480" height="320" border="2"/> </a>
      <img src="/chart/cameras/moko_02.jpg" width="480" height="320" border="2">
    </div>
		<div>
			<img src="/chart/cameras/gorycz.jpg" width="480" height="320" border="2">
			<img src="/chart/cameras/gasie.jpg" width="480" height="320" border="2">
		</div>
		<div>
			<img src="/chart/cameras/stawy1.jpg" width="480" height="320" border="2">
			<img src="/chart/cameras/stawy2.jpg" width="480" height="320" border="2">
		</div>
		<div>
			<img src="/chart/cameras/chocholow.jpg" width="480" height="320" border="2">
			<img src="/chart/cameras/lomnicak-l.jpg" width="480" height="320" border="2">
		</div>
	</p>
    </div>
    <script src="libs/jquery/jquery.js"></script>
    <script src="libs/jquery.backstretch.js"></script>
	<script>
        $.backstretch([
          "imgs/1.jpg",
          "imgs/2.jpg",
          "imgs/3.jpg",
	  "imgs/4.jpg"
        ], {
            fade: 750,
            duration: 60000
        });
    </script>
</body>
</html>
