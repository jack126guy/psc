# Pony Shipping Catalog (Ship Names)

This is an old experiment (from around 2014 or 2015) centered around "[shipping](https://en.wikipedia.org/wiki/Shipping_(fandom))" characters from My Little Pony: Friendship is Magic. Specifically, the code here generates and queries nicknames for ships based on the names of the characters. This project was originally envisioned as a database of fan works with different ships, with this nickname component as part of the search function.

**Note**: This project is unmaintained, and the code will be updated only to address significant security issues. In particular, I am not interested in updating the code to reflect PHP development best practices. Please fork the project if you are interested in making substantial improvements.

## Requirements

This project requires a Web server and PHP 5.1 or later with PDO. The default database setup uses the SQLite driver (which is enabled by default for PDO), but if you wish to use a different database then an additional driver may be needed.

## Installation

1. Set up the database.
	* To use the default database: Navigate to the `private` directory, copy `db_init.php.example` to `db_init.php`, then run `make_sqlite.php` to generate the SQLite database (`psc.sqlite`).
	* To use a different database: Copy `private/db_init.php.example` to `private/db_init.php`, then edit the latter file to connect to a different database. Refer to `private/db.php` for information on how to use the `SQL` class. Refer to `private/make_sqlite.php` for the database schema.
2. Configure the Web server to block access to files in the `private` directory (highly recommended).

## Usage

Load `namequery.htm` in a Web browser. This is the landing page for the nickname-related functionality:

* **Character List**: View the list of defined characters, along with their associated prefixes and suffixes for ship nicknames.
* **Get Name from Characters**: Generate a ship nickname based on a pair of characters.
* **Search Pair Names**: Derive pairs of characters based on a ship nickname.

## License

This project is dedicated to the public domain under [Creative Commons CC0 1.0 Universal](https://creativecommons.org/publicdomain/zero/1.0/). (A copy is available in `LICENSE.txt`.)