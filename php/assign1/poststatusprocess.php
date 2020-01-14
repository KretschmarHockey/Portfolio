<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Assignment 1</title>
</head>

<body>
    <?php
    require_once('conf/settings.php');

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
        // Retrieve data from post form
        $status_code = $_POST["status_code"];
        $status = $_POST["status"];
        $share = $_POST["share"];
        $date = $_POST["date"];
        $permission_type = $_POST["permission_type"];
        $permission_bitwise_flag = 0;

        $status_code_pattern = "/^[S][0-9]{4}$/"; // Pattern for status code. Starting with S and 4 numbers
        $status_pattern = "/^[a-zA-Z0-9 ,.!?]*$/"; // Pattern for status. Only certain characters.

        // Creating table if doesn't exist
        $query = "CREATE TABLE IF NOT EXISTS $sql_tble ("
            . " status_code VARCHAR(5) NOT NULL,"
            . " status VARCHAR(40) NOT NULL,"
            . " share VARCHAR(7),"
            . " date DATE,"
            . " permission INT,"
            . " PRIMARY KEY(status_code));";

        $result = mysqli_query($conn, $query); // Running query

        // Do not need to check for correctly formatted date as DATE in database formats it correctly

        $query = "SELECT status_code FROM $sql_tble WHERE status_code = '$status_code'"; // Retrieving status code from database that matches one given in form
        $result = mysqli_query($conn, $query);

        if (empty($status_code) or empty($status) or mysqli_num_rows($result) > 0 or !preg_match($status_code_pattern, $status_code) or !preg_match($status_pattern, $status)) {
            /**
             * Tests all errors:
             * If status code text field is empty.
             * If status text field is empty.
             * If status code isn't unique.
             * If status code does not match pattern.
             * If status contains invalid characters.
             */
            echo "<p>Sorry you have not filled out all fields correctly. Please try again.</p>";

            // Determines error in status code
            if (empty($status_code)) { // If status code text field is empty.
                echo "<p>Status Code is required.</p>";
            } else if (!preg_match($status_code_pattern, $status_code)) { // If status code does not match pattern.
                echo "<p>Status Code is not formmated correctly. It must start with \"S\" followed by 4 numbers.";
            } else if (mysqli_num_rows($result) > 0) { // If status code isn't unique.
                echo "<p>Status Code '$status_code' is already being used. Please use a different code.";
            }

            // Determines error in status
            if (empty($status)) { // If status text field is empty.
                echo "<p>Status is required.</p>";
            } else if (!preg_match($status_pattern, $status)) { // If status contains invalid characters.
                echo "<p>Status can only include letters, numbers, spaces, commas, periods, exclamation points and question marks. Other symbols and characters are not allowed.";
            }

            echo "<p><a href=\".\">Return to Home Page</a></p>";
            echo "<p><a href=\"poststatusform.php\">Return to Post Status Page</a></p>";
        } else { // No errors found
            foreach ($permission_type as $i) { // Creates bitwise flag based on radio buttons
                switch ($i) {
                    case "allow_like":
                        $permission_bitwise_flag += 4;
                        break;
                    case "allow_comment":
                        $permission_bitwise_flag += 2;
                        break;
                    case "allow_share":
                        $permission_bitwise_flag += 1;
                        break;
                    default:
                        break;
                }
            }

            // Inserts the data from the form into the table
            $query = "INSERT INTO $sql_tble"
                . "(status_code, status, share, date, permission)"
                . "values"
                . "('$status_code', '$status', '$share', '$date', $permission_bitwise_flag)";

            $result = mysqli_query($conn, $query);

            if (!$result) { // SQL command contains error
                echo "<p>Something is wrong with ", $query, "</p>";
            } else { // Succesful add to database
                echo "<p>The status was successfully added to the database.</p>";
                echo "<p><a href=\".\">Return to Home Page</a></p>";
            }

            // Disconnect from database
            mysqli_close($conn);
        }
    }

    ?>
</body>

</html>