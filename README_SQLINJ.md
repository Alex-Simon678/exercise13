# SQL Injection Prevented by prepared statement

**Example:**
When an input like `' OR '1'='1` is passed to `vulnerable_search.php`, the result query becomes:
`SELECT id, username, email FROM users WHERE username = '' OR '1'='1'`
Because `'1'='1'` is always true, the database ignores the username requirement and returns every user record in the table.

**Why Prepared Statements Work:**
Prepared statements separate the query structure from the data. When we use `$pdo->prepare()`, the database pre-compiles the SQL logic. When `$stmt->execute()` passes the variables, the database treats `' OR '1'='1` strictly as a literal string value to search for, rather than executable SQL commands. It will look for a user whose literal username is exactly `\' OR \'1\'=\'1`, completely neutralizing the attack.