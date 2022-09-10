<?php
require('db.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pair Name - Pony Shipping Catalog</title>
	</head>
	<body>
		<p>
			<?php
			makepairname();
			function makepairname() {
				global $sql;
				if(!isset($_GET['char1']) || !isset($_GET['char2'])) {
					echo 'Please specify the characters in the "char1" and "char2" query string parameters.';
					return;
				}
				//obtain affixes from database
				$char1query = $sql->query('SELECT * FROM ' . $sql->format_table_name('characters') . ' WHERE charname = "' . $sql->real_escape_string($_GET['char1']) . '";');
				$char2query = $sql->query('SELECT * FROM ' . $sql->format_table_name('characters') . ' WHERE charname = "' . $sql->real_escape_string($_GET['char2']) . '";');
				if($sql->error()) {
					echo 'Error: ' . $sql->error();
					return;
				}
				if($sql->num_rows($char1query) == 0 || $sql->num_rows($char2query) == 0) {
					echo 'Character(s) not found.';
					return;
				}
				$char1row = $sql->fetch_assoc($char1query);
				$char2row = $sql->fetch_assoc($char2query);
				//create pair name
				if($char2row['needsprefixalt']) {
					$pairname = $char1row['charprefixalt'];
				} else {
					$pairname = $char1row['charprefixpref'];
				}
				$pairname .= $char2row['charsuffix'];
				//create reversed pair name
				if($char1row['needsprefixalt']) {
					$revpairname = $char2row['charprefixalt'];
				} else {
					$revpairname = $char2row['charprefixpref'];
				}
				$revpairname .= $char1row['charsuffix'];
				echo 'Pair Name: ' . $pairname . '<br/>';
				echo 'Reversed: ' . $revpairname;
			}
			?>
		</p>
	</body>
</html>
