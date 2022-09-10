<?php
require('db.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Character Listing - Pony Shipping Catalog</title>
	</head>
	<body>
		<?php
		$query = $sql->query('SELECT * FROM ' . $sql->get_table_prefix(). 'characters;');
		if($sql->error()) {
			echo 'Error: ' . $sql->error();
		} else {
		?>
		<table>
			<tr><td><b>Character Name</b></td><td><b>Prefix (Pref/Alt)</b></td><td><b>Suffix</b></td><td><b>Needs Alt. Prefix?</b></td></tr>
			<?php
			while($row = $sql->fetch_assoc($query)) {
				echo '<tr><td>' . $row['charname'] . '</td><td>' . $row['charprefixpref'] . '- / ' . $row['charprefixalt'] . '-</td><td>-' . $row['charsuffix'] . '</td><td>';
			if($row['needsprefixalt']) {
				echo 'Yes';
			} else {
				echo 'No';
			}
			echo '</td></tr>';
		}
	}
	?>
	</table>
	</body>
</html>
