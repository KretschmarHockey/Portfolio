<!DOCTYPE html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Assignment 1</title>
</head>

<body>
    <?php
    require_once("conf/settings.php");

    // Connect to database
    $conn = @mysqli_connect(
        $sql_host,
        $sql_user,
        $sql_pass,
        $sql_db
    );

    if (!$conn) { // Database fails to connect
        echo "<p>Database connection failure</p>";
    } else { // Database succesfully connects
        // Retrieve data from get form
        $search_query = $_GET["status"];

        // Creating table if doesn't exist
        $query = "CREATE TABLE IF NOT EXISTS $sql_tble ("
            . " status_code VARCHAR(5) NOT NULL,"
            . " status VARCHAR(40) NOT NULL,"
            . " share VARCHAR(7),"
            . " date DATE,"
            . " permission INT,"
            . " PRIMARY KEY(status_code));";

        $result = mysqli_query($conn, $query);

        // Tests if search text field is empty
        if (empty($search_query)) {
            echo "<p>Search cannot be left blank</p>";
            echo "<p><a href=\".\">Return to Home Page</a></p>";
            echo "<p><a href=\"searchstatusform.html\">Return to Search Status Page</a></p>";
        } else { // No error found
            // Selects all data from table that matches the search query
            $query = "SELECT * FROM $sql_tble WHERE status LIKE '%$search_query%';";
            $result = mysqli_query($conn, $query);
            echo "<h1>Status Information</h1>";
            echo "<hr>";
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { // Iterates through each row
                    echo "<p>Status: ", $row["status"], "<br>";
                    echo "Status Code: ", $row["status_code"], "</p>";
                    echo "<p>Share: ", $row["share"], "<br>";
                    echo "Date Posted: ", date("F j, Y", strtotime($row["date"])), "<br>";
                    echo "Permission: ";
                    if (!$row["permission"]) {
                        echo "No permissions";
                    } else {
                        echo "Allow ";
                        if ($row["permission"] & 4) {
                            echo "Like ";
                        }
                        if ($row["permission"] & 2) {
                            echo "Comment ";
                        }
                        if ($row["permission"] & 1) {
                            echo "Share";
                        }
                    }
                    echo "</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p>No Results</p>";
            }

            echo "<p><a href=\"searchstatusform.html\" class=\"alignleft\">Search for another status</a>";
            echo "<a href=\".\" class=\"alignright\">Return to Home Page</a></p>";

            mysqli_close($conn);
        }
    }
    ?>
</body>

</html>