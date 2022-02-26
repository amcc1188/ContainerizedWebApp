<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<br><br>
<?php


//admin key
if(isset($_GET['key']) && $_GET['key'] == '24681357' ){
	$key = $_GET['key'];
	$str = file_get_contents('http://frontend.40036410.qpc.hal.davecutting.uk/url.json');

		if(isset($_POST['jsn'])){
		$newData = $_POST['jsn'];
		//add entry to json file
		file_put_contents('url.json', $newData);
		//refresh
			echo "<meta http-equiv='refresh' content='0'>";
		  }
	?>
	<form action="?key=<?php echo $key; ?>" method="POST" id="usrform">
	  <label for="myfile">Json File Data</label><br>
		
		<textarea rows="20" cols="90" name="jsn" form="usrform" ><?php
	$str2 = file_get_contents('http://frontend.40036410.qpc.hal.davecutting.uk/url.json');
	 echo $str2; ?></textarea><br><br>
	  <input type="submit" value="Update">
	</form>

<?php
} else {

	echo 'Not Authorized !!';
}

?>
</div>
</body>
</html>
