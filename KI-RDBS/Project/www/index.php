<?
$host = 'postgres';
$dbname = 'app';
$user = 'app-user';
$password = 'app-pwd';

try {
    // Connect to your postgres DB
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn, $user, $password);

    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Execute a query
    $stmt = $conn->query("SELECT version();");

    // Fetch and print the result of the query
    $db_version = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Connected to - " . $db_version['version'];

} catch (PDOException $e) {
    echo "Error connecting to PostgreSQL database: " . $e->getMessage();
}
?>
