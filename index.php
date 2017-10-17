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
			$url = "https://icer.ink/media1.clubpenguin.com/play/en/web_service/game_configs/paper_items.json";
			$jsonItems = file_get_contents($url); // Updated, just like SWF
			if( $url == "https://icer.ink/media1.clubpenguin.com/play/en/web_service/game_configs/paper_items.json"){
				// Do something
			} else {
				die();
			}
			$objDecode = json_decode($jsonItems, true);
			$objPage = isset($_GET['p']) ? intval($_GET['p']) : 0;
			$itemsPerPage = 10;
			if( $itemsPerPage > 10){ // Added
				die();
			}
			$elements = array_slice($objDecode, $objPage * $itemsPerPage, $itemsPerPage);
			$totalPages = intval(count($objDecode)/$itemsPerPage);
			if(!isset($_GET['p']) || empty($_GET['p'])){
				$_GET['p'] = '0';
			}
			$currentPage = $_GET['p'];
			if($currentPage > $totalPages){
				$kekxd = '0'; // Added
				echo("<tr><td>Sorry this page does not exist. Please return to <a href='?p=$kekxd'>page 1</a>.</td></tr>"); // Modified
				if( $kekxd !== '0'){ // Added
					die();
				}
				exit;
			}
			if(ctype_digit($currentPage)){ // Added
				echo "<center><h1>Club Penguin Item Database</h1></center>";
			} else {
				die();
				echo "<center><h1>MISS ME WITH THAT GAY SHIT NIGGA!</h1></center>"; // If user uses some gay HTTP editor
			}
			$objLink1 = $currentPage - 1;
			$objLink2 = $currentPage + 1;
			if($_GET['p'] == 0){
				$objBackButton = "";
			} else {
				$objBackButton = "<a href=?p=" . htmlentities($objLink1) . ">Previous Page</a>"; // Modified
			}
			if($_GET['p'] == $totalPages){
				$objNextButton = "";
			} else {
				$objNextButton = "<a href=?p=" . htmlentities($objLink2) . ">Next Page</a>"; // Modified
			}
			if($_GET['p'] == $totalPages or $_GET['p'] == 0){
				$objMiddle = "";
			} else {
				$objMiddle = " | ";
			}
			$objPageNav = $objBackButton . $objMiddle . $objNextButton;
			echo('<tr><td colspan="7" align="center">' . $objPageNav . '</td></tr>');
			foreach($elements as $item) {
				$label = $item["label"];
				$cost = $item['cost'];
				$id = $item['paper_item_id'];
				$member = $item['is_member'];
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
