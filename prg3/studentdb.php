<!DOCTYPE html>
<html>
<head>
    <title>Insert Student Record</title>
</head>
<body>
    <?php
    // Retrieve form data
    $usn = $_GET["usn"];
    $name = $_GET["name"];
    $branch = $_GET["branch"];
    $sem = $_GET["sem"];
    $email = $_GET["email"];

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "studentdb");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
        // Insert data into database
        $sql = "INSERT INTO student (usn, name, branch, sem, email) VALUES ('$usn', '$name', '$branch', $sem, '$email')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>
