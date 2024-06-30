<!DOCTYPE >
<html >
<head>
    <title>Contact Details</title>
    <style>
        body {
            background-color: #CCFFFF;
            color: #660099;
        }
        table {
            margin-top: 20px;
        }
        table td {
            padding: 5px;
        }
        p.required-fields {
            font-style: italic;
            color: blue;
        }
    </style>
</head>
<body>
    <?php
    $self = $_SERVER['PHP_SELF'];
    $dbh = new mysqli("localhost", "root", "", "contactDB");

    if ($dbh->connect_error) {
        die("Connection failed: " . $dbh->connect_error);
    }

    if (isset($_POST['submit'])) {
        $nme = $_POST['name'];
        $ad1 = $_POST['add1'];
        $ad2 = $_POST['add2'];
        $eml = $_POST['email'];

        if (!empty($nme) && !empty($ad1)) {
            $stmt = $dbh->prepare("INSERT INTO contact (name, add1, add2, email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nme, $ad1, $ad2, $eml);
            if ($stmt->execute()) {
                header("Location: home.html");
                exit();
            } else {
                echo "<p>Error: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p>One of the required fields is empty!</p>";
        }
    }

    $dbh->close();
    ?>
    <form action="<?= htmlspecialchars($self) ?>" method="POST">
        <h1>Enter the Contact Details</h1>
        <p>Go to <a href="/home.html">Menu</a></p>
        <table>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" />*</td>
            </tr>
            <tr>
                <td>Address Line 1</td>
                <td><input type="text" name="add1" />*</td>
            </tr>
            <tr>
                <td>Address Line 2</td>
                <td><input type="text" name="add2" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="email" /></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="SUBMIT" />
                    <input type="hidden" name="submit" value="yes" />
                </td>
            </tr>
        </table>
        <p class="required-fields">*Required Fields</p>
    </form>
</body>
</html>
