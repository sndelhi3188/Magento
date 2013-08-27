<?php 
require_once "function.php";
?>
<html>
	<head>
		<title>Import Users</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css"/>
	</head>
	<body style="background-color:#E9E4E4">
		<div style="border-radius:10px; background-color:#1E90FF; height:250px; width:40%; margin-left:30%; margin-top:10%; padding:10px 25px; box-shadow: 4px 4px 4px 4px #837878">
			<h3 style="margin-left:35px; color:#FFFFFF">Customer (dealer) import form</h3>
			<div style="border-radius:10px; background-color:#FFFFFF; padding: 28px 28px 10px 25px; border:1px; box-shadow: 1px 1px 1px 1px #837878 inset; margin:25px;">
				<form action="" method="post" enctype="multipart/form-data">
					<table align="center" border="0" cellpadding="0" cellspacing="5">
						<tr align="right"><td colspan="2"><b style="color:#A52A2A">Upload Customer : Only use csv file.</b></td></tr>
						<tr align="right"><td>&nbsp;</td></tr>
						<tr align="right"><td><input type="file" name="csv" value="Upload Customer" /></td><td><button type="submit" class="btn btn-primary" name="submit" >Submit</button></td></tr>
					</table>
				</form>
			</div>
		</div>
<?php
global $error;
// check there are no errors
if(isset($_REQUEST['submit'])){
	if($_FILES['csv']['error'] == 0){
	$name = $_FILES['csv']['name'];
	$ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
	//$type = $_FILES['csv']['type'];
	$tmpName = $_FILES['csv']['tmp_name'];
	// check the file is a csv
		if($ext === 'csv'){
			if(($handle = fopen($tmpName, 'r')) !== FALSE) {
				// necessary if a large csv file
				set_time_limit(0);
				$row = 0;
				while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
					if($data[0]){
						$cust[$row][0] = $data[0];
						$cust[$row][1] = $data[1];
						$cust[$row][2] = $data[2];
						$cust[$row][3] = $data[3];
						$cust[$row][4] = $data[4];
					}
					$row++;
				}
				fclose($handle);
				print_r(createCustomer($cust));
			}
		}else{ $error = "Wrong file format, you can upload only csv files."; }
	}else{
		$error = "Some error in file.";
	}
}
?>
</br><center><p style="color:#FF0000; font-size:16px;"><?php if($error)echo $error; else echo "";?></p></center>
</body>
</html>

