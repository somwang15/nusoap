<?php
		require_once("lib/nusoap.php");
		 
		//Create a new soap server
		$server = new soap_server();
		 
		//Define our namespace
		$namespace = "http://localhost/nusoap/index.php";
		$server->wsdl->schemaTargetNamespace = $namespace;
		 
		//Configure our WSDL
		$server->configureWSDL("getCustomer");
		 
		// Register our method and argument parameters
        $varname = array(
                   'strCountry' => "xsd:string"
        );
		$server->register('resultCustomer',$varname, array('return' => 'xsd:string'));
		 
		function resultCustomer($strCountry)
		{
				$objConnect = mysql_connect("localhost","root","admin1234") or die(mysql_error());
				$objDB = mysql_select_db("json");
				$strSQL = "SELECT * FROM customer WHERE 1 AND CountryCode like '%".$strCountry."%' ";
				$objQuery = mysql_query($strSQL) or die (mysql_error());
				$intNumField = mysql_num_fields($objQuery);
				$resultArray = array();
				while($obResult = mysql_fetch_array($objQuery))
				{
					$arrCol = array();
					for($i=0; $i< $intNumField; $i++)
					{
						$arrCol[mysql_field_name($objQuery,$i)] = $obResult[$i];
					}
					array_push($resultArray,$arrCol);
				}
				return json_encode($resultArray);
		}
		 
		// Get our posted data if the service is being consumed
		// otherwise leave this data blank.
		$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
		 
		// pass our posted data (or nothing) to the soap service
		$server->service($POST_DATA);
		exit(); 
?>
