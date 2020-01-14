<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <?php
    // Name: Josh Kretschmar
    // Student ID: 16939790

    require_once('conf/settings.php');

    // Connecting to database
    $conn = @mysqli_connect(
        $sql_host,
        $sql_user,
        $sql_pass,
        $sql_db
    );

    if (!$conn) { // Database fails to connect
        die("Connection failed: " . mysqli_error($conn));
    } // Database succesfully connects

    // Receiving information from get request
    $name = $_GET["name"];
    $phone = $_GET["phone"];
    $unit = $_GET["unit"];
    $street_number = $_GET["street_number"];
    $street_name = $_GET["street_name"];
    $pick_suburb = $_GET["pick_suburb"];
    $dest_suburb = $_GET["dest_suburb"];
    $pick_date_time = $_GET["date_time"];

    $query = "CREATE TABLE IF NOT EXISTS $sql_tble ("   // Creating table if doesn't exist
        . " id INT(11) NOT NULL AUTO_INCREMENT,"        // Unique Reference Number
        . " name VARCHAR(32) NOT NULL,"                 // Customer's name
        . " phone VARCHAR(16) NOT NULL,"                // Customer's phone number
        . " unit VARCHAR(32),"                          // Address Unit (Can be left blank in form)
        . " street_number VARCHAR(8) NOT NULL,"         // Address Street Number
        . " street_name VARCHAR(64) NOT NULL,"          // Address Street Name
        . " pick_suburb VARCHAR(32) NOT NULL,"          // Pick up Suburb
        . " dest_suburb INT(32) NOT NULL,"              // Destination Suburb
        . " pick_date_time TIMESTAMP NOT NULL,"         // Pick up date and time
        . " reference INT(8) NOT NULL,"                 // Randomly Generated Reference number
        . " book_date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"   // Auto Generated to the date and time of the booking
        . " status VARCHAR(16) NOT NULL DEFAULT 'unassigned',"  // Booking Status (Auto Generated to unassigned)
        . " PRIMARY KEY (id))";

    $result = mysqli_query($conn, $query); // Running query

    $reference = generateReferenceNumber($conn); // Generating reference number
    $book_date_time = date('Y-m-d H:i:s');  // Getting current server time

    // Inserts the data from the form into the database
    $query = "INSERT INTO $sql_tble"
        . "(name, phone, unit, street_number, street_name, pick_suburb, dest_suburb, pick_date_time, reference, book_date_time)"
        . "values"
        . "('$name', '$phone', '$unit', '$street_number', '$street_name', '$pick_suburb', '$dest_suburb', '$pick_date_time', $reference, '$book_date_time')";

    $result = mysqli_query($conn, $query);

    echo "<p>Thank you! Your booking reference number is $reference.</p>";
    echo "<p>You will be picked up in front of your provided address at " . date_format(new DateTime($pick_date_time), 'g:ia \o\n l jS F Y') . ".";

    // Disconnect from database
    mysqli_close($conn);


    function generateReferenceNumber($conn)
    {
        $result = 1;
        while ($result > 0) { // Looping until $reference creates a unique number
            $reference = rand(1000000, 99999999);
            $result = mysqli_query($conn, "SELECT * FROM reference WHERE reference=$reference");
        }
        return $reference;
    }
    ?>
</body>

</html>