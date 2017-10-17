<html>
<head>
	<title>Club Penguin Item Database</title>
	<link rel="stylesheet" href="style.css" type="text/css"/> <!-- Added, was missing -->
</head>
<body>
	<center>
		<div class="center"></div>
		<table cellspacing="10">
			<?php
			require_once( "Database.php" );
			$objPage = isset($_GET['p']) ? intval($_GET['p']) : 0;
			$itemsPerPage = 10;
			$tpapers = getData("SELECT * FROM paper WHERE table_id > " . (($objPage * $itemsPerPage) -1 ) . " LIMIT 10");
			if( $itemsPerPage > 10){ // Added
				die();
			}
			$elements = $tpapers;
			if(!isset($_GET['p']) || empty($_GET['p'])){
				$_GET['p'] = '0';
			}
			$currentPage = $_GET['p'];
			if(ctype_digit($currentPage)){ // Added
				echo "<center><h1>Item Database by <b>Daleth & Zaseth</b> <i>(haha that rhymes)</i></h1></center>";
			} else {				
				echo "<center><h1>don't do that kthx</h1></center>"; // If user uses some gay HTTP editor
				die();
			}
			$objLink1 = $currentPage - 1;
			$objLink2 = $currentPage + 1;
			$objMiddle = "";

			if (count($elements) < 2) {
				echo("<tr><td>Sorry this page does not exist. Please return to <a href='?p=0'>page 1</a>.</td></tr>"); // Modified
				exit;
			}
			
			if (count($elements) > 9) {
				$objMiddle = " | ";
				$objNextButton = "<a href=?p=" . htmlentities($objLink2) . ">Next Page</a>"; // Modified
			} else {
				$objNextButton = "";
			}
			if($_GET['p'] < 1){
				$objBackButton = "";
				$objMiddle = "";
			} else {
				$objBackButton = "<a href=?p=" . htmlentities($objLink1) . ">Previous Page</a>"; // Modified
			}
			$objPageNav = $objBackButton . $objMiddle . $objNextButton;
			echo('<tr><td colspan="7" align="center">' . $objPageNav . '</td></tr>');
			foreach($elements as $item) {
				$label = $item["label"];
				$cost = $item['cost'];
				$id = $item['id'];
				$member = $item['members'] == 1 ? true : false;
				$type = $item['type'];
				$member = $member ? 'True' : 'False';
				if( $member !== 'True' && $member !== 'False' ) { // Added
					die();
				}
				switch ($type) {
					case 1:
						$type = 'Color';
						break;
					case 2:
						$type = 'Head';
						break;
					case 3:
						$type = 'Face';
						break;
					case 4:
						$type = 'Neck';
						break;
					case 5:
						$type = 'Body';
						break;
					case 6:
						$type = 'Hand';
						break;
					case 7:
						$type = 'Foot';
						break;
					case 8:
						$type = 'Pin/Flags';
						break;
					case 9:
						$type = 'Background';
						break;
					case 10:
						$type = 'Others';
						break;
				}
				$strTable = "<tr><td><embed src=\"items.swf?id=" . htmlentities($id) . "\"height='50' width='50' wmode='transparent'></td><td style='text-align: center !important;'><b>Name:</b> $label</td><td><b>Item ID:</b> $id</td><td><b>Member:</b> $member</td><td><b>Cost:</b> $cost coins</td><td><b>Type:</b> $type</td></tr>"; // Modified
				echo substr($strTable, 0, -5);
			}
			?>
		</table>
	</center>
</body>
</html>
