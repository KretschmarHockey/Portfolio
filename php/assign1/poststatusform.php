<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Assignment 1</title>
</head>

<body>
    <h1>Status Posting System - Post Status</h1>

    <?php
    // Creating dates from server
    $month = date('m');
    $day = date('d');
    $year = date('Y');

    $today = $year . '-' . $month . '-' . $day;
    ?>

    <form method="post" action="poststatusprocess.php">
        <p> <label for="status_code">Status Code (required): </label>
            <input type="text" name="status_code" id="status_code" placeholder="S####" class="required" /></p>

        <p> <label for="status">Status (required): </label>
            <input type="text" name="status" id="status" class="required" /></p>

        <p> <label for="share">Share: </label>
            <input type="radio" name="share" value="Public" checked />Public
            <input type="radio" name="share" value="Friends" />Friends
            <input type="radio" name="share" value="Only Me" />Only Me</p>

        <p> <label for="date">Date: </label>
            <input type="date" name="date" id="date" value="<?php echo $today; ?>" /></p>

        <p> <label for="permission_type">Permission Type: </label>
            <input type="checkbox" name="permission_type[]" value="Allow Like" />Allow Like
            <input type="checkbox" name="permission_type[]" value="Allow Comment" />Allow Comment
            <input type="checkbox" name="permission_type[]" value="Allow Share" />Allow Share</p>

        <p> <input type="submit" value="Post" />
            <input type="reset" value="Reset" /></p>

        <p><a href=".">Return to Home Page</a></p>
    </form>
</body>

</html>