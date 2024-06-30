<!DOCTYPE html PUBLIC >
<html >
<head>
    <title>Search for Contact</title>
    <style>
        body {
            background-color: #CCFFFF;
            color: #660099;
        }
        table {
            margin: 20px;
            border-collapse: collapse;
            color: #404040;
        }
        th, td {
            border: 1px solid #404040;
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>Search for Contacts</h1>
    <p>Go to <a href="home.html">Menu</a></p>

    <?php
    // PHP script to handle form submission and database interaction

    // $self contains the sanitized URL of the current script
    $self = htmlspecialchars($_SERVER['PHP_SELF']);

    // Check if the form has been submitted
    if (isset($_GET['search'])) {
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "contactDB";

        // Create connection to the MySQL database using mysqli
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Sanitize user input to prevent SQL injection
        $nme = $conn->real_escape_string($_GET["name"]);
        echo "<p>Searching for $nme...</p>";

        // Prepare an SQL statement to search for the name in the database
        $query = $conn->prepare("SELECT * FROM contact WHERE name LIKE ?");
        $searchTerm = '%' . $nme . '%';
        $query->bind_param("s", $searchTerm);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Name</th><th>Address Line 1</th><th>Address Line 2</th><th>Email</th></tr>';

            // Fetch and display the results
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['name']}</td><td>{$row['address1']}</td><td>{$row['address2']}</td><td>{$row['email']}</td></tr>";
            }
            echo '</table>';
        } else {
            echo "<p><b>No matches found...</b></p>";
        }

        // Close the statement and the connection
        $query->close();
        $conn->close();
    }
    ?>

    <!-- HTML form for user input -->
    <form action="<?= $self ?>" method="GET">
        Enter Name: <input type="text" name="name" />
        <input type="hidden" name="search" value="yes" />
        <input type="submit" value="Search" />
    </form>
</body>
</html>
