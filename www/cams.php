<!doctype html>
<html lang="en">
<head>
</head>
<body>
    <div class="container">
        <h1><a href="http://192.168.101.1/chart/">TOPR</a> / <a href="cams.php">KAMERY</a></h1>
        <p><center>
		<div>
			<img src="/chart/cameras/moko_01.jpg" width="480" height="320" border="2">
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
	</p></center>
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
