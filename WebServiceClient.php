<html>
<head>
<title>ThaiCreate.Com</title>
</head>
<body>

<form name="frmMain" method="post" action="">
	  <h2>Search Customer</h2>
	  Search by Country Code 
	  <input type="text" name="txtCountry" value="<?php echo $_POST["txtCountry"];?>">
	  <input type="submit" name="Submit" value="Submit">
</form>

<?php
			if($_POST["txtCountry"] != "")
			{
					include("lib/nusoap.php");
					$client = new nusoap_client("http://localhost/nusoap/WebServiceServer.php?wsdl",true); 
					$params = array(
							   'strCountry' => $_POST["txtCountry"]
					);
					$data = $client->call('resultCustomer', $params);

					//echo '<pre>';
					//var_dump(json_decode($data));
					//echo '</pre><hr />';

					$mydata = json_decode($data,true); // json decode from web service


					if(count($mydata) == 0)
					{
							echo "Not found data!";
					}
					else
					{
						?>
								<table width="500" border="1">
								  <tr>
									<td>CustomerID</td>
									<td>Name</td>
									<td>Email</td>
									<td>CountryCode</td>
									<td>Budget</td>
									<td>Used</td>
								  </tr>
								<?php
								foreach ($mydata as $result) {
								?>
									  <tr>
										<td><?php echo $result["CustomerID"];?></td>
										<td><?php echo $result["Name"];?></td>
										<td><?php echo $result["Email"];?></td>
										<td><?php echo $result["CountryCode"];?></td>
										<td><?php echo $result["Budget"];?></td>
										<td><?php echo $result["Used"];?></td>
									  </tr>
								<?php
								}
					}

			}
?>
</body>
</html>
