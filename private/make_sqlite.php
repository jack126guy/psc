<?php
$dbpath = 'psc.sqlite';
if(file_exists($dbpath)) {
	echo "Database exists, exiting\n";
	return;
}

$db = new PDO('sqlite:' . dirname(__FILE__) . '/' . $dbpath);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$characters = json_decode(file_get_contents('characters.json'), TRUE);

$db->exec(<<<'EOT'
CREATE TABLE characters (
	charname TEXT COLLATE NOCASE NOT NULL PRIMARY KEY,
	charprefixpref TEXT COLLATE NOCASE NOT NULL,
	charprefixalt TEXT COLLATE NOCASE NOT NULL,
	charsuffix TEXT COLLATE NOCASE NOT NULL,
	needsprefixalt INT NOT NULL
);
CREATE INDEX ix_characters_charname ON characters (charname);
CREATE INDEX ix_characters_charprefixpref ON characters (charprefixpref);
CREATE INDEX ix_characters_charprefixalt ON characters (charprefixalt);
CREATE INDEX ix_characters_charsuffix ON characters (charsuffix);
EOT
);

$insert = $db->prepare('INSERT INTO characters (charname, charprefixpref, charprefixalt, charsuffix, needsprefixalt) VALUES (:charname, :charprefixpref, :charprefixalt, :charsuffix, :needsprefixalt);');

foreach($characters as $character) {
	$insert->bindValue('charname', $character['charname']);
	$insert->bindValue('charprefixpref', $character['charprefixpref']);
	$insert->bindValue('charprefixalt', $character['charprefixalt']);
	$insert->bindValue('charsuffix', $character['charsuffix']);
	$insert->bindValue('needsprefixalt', (int) $character['needsprefixalt'], PDO::PARAM_INT);
	$insert->execute();
}
?>