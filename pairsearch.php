<?php
require('private/db.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pair Search - Pony Shipping Catalog</title>
	</head>
	<body>
		<?php
		searchpair();
		function searchpair() {
			global $sql;
			if(!isset($_GET['name'])) {
				echo '<p>Please specify the pair name in the "name" query string parameter.</p>';
				return;
			}
			//create array to hold results
			$results = array();
			//attempt to treat the first i characters as prefix
			for($i=1; $i<strlen($_GET['name'])+1; $i++) {
				//search preferred and alternate prefixes
				$prefpfixquery = $sql->query('SELECT charname, charprefixpref FROM ' . $sql->format_table_name('characters') . ' WHERE charprefixpref LIKE ? ESCAPE \'\'\'\';', array(likeescape(substr($_GET['name'], 0, $i)) . '%'));
				if($sql->error()) {
					echo '<p>Error: ' . $sql->error() . '</p>';
					return;
				}
				$altpfixquery = $sql->query('SELECT charname, charprefixalt FROM ' . $sql->format_table_name('characters') . ' WHERE charprefixalt LIKE ? ESCAPE \'\'\'\';', array(likeescape(substr($_GET['name'], 0, $i)) . '%'));
				if($sql->error()) {
					echo '<p>Error: ' . $sql->error() . '</p>';
					return;
				}
				//search suffixes with preferred prefixes
				while($pfixrow = $sql->fetch_assoc($prefpfixquery)) {
					$sfixquery = $sql->query('SELECT charname, charsuffix FROM ' . $sql->format_table_name('characters') . ' WHERE charsuffix LIKE ? ESCAPE \'\'\'\' AND needsprefixalt = 0 AND charname != ?;', array(likeescape(substr($_GET['name'], $i)) . '%', $pfixrow['charname']));
					if($sql->error()) {
						echo '<p>Error: ' . $sql->error() . '</p>';
						return;
					}
					while($sfixrow = $sql->fetch_assoc($sfixquery)) {
						$results[] = array('shipname' => $pfixrow['charprefixpref'] . $sfixrow['charsuffix'], 'char1' => $pfixrow['charname'], 'char2' => $sfixrow['charname']);
					}
				}
				//search suffixes with alternate prefixes
				while($pfixrow = $sql->fetch_assoc($altpfixquery)) {
					$sfixquery = $sql->query('SELECT charname, charsuffix FROM ' . $sql->format_table_name('characters') . ' WHERE charsuffix LIKE ? ESCAPE \'\'\'\' AND needsprefixalt = 1 AND charname != ?;', array(likeescape(substr($_GET['name'], $i)) . '%', $pfixrow['charname']));
					if($sql->error()) {
						echo '<p>Error: ' . $sql->error() . '</p>';
						return;
					}
					while($sfixrow = $sql->fetch_assoc($sfixquery)) {
						$results[] = array('shipname' => $pfixrow['charprefixalt'] . $sfixrow['charsuffix'], 'char1' => $pfixrow['charname'], 'char2' => $sfixrow['charname']);
					}
				}
			}
			//output results
			echo '<table>';
			echo '<tr><td><b>Pair Name</b></td><td><b>Pairing</b></td></tr>';
			foreach($results as $resultrow) {
				echo '<tr><td>' . $resultrow['shipname'] . '</td><td>' . $resultrow['char1'] . ' x ' . $resultrow['char2'] . '</td></tr>';
			}
			echo '</table>';
		}
		function likeescape($string) {
			return str_replace(array('%', '_'), array('\\%', '\\_'), $string);
		}
		?>
	</body>
</html>
