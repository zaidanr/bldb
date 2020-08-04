<?php 
include("config.php");

$query = "SELECT email, username, name, hash  FROM bukalapak WHERE email = ?";

if (isset($_GET['email'])) {
    $param_email = htmlspecialchars(trim($_GET['email']));

    // Validate email
    if (filter_var($param_email, FILTER_VALIDATE_EMAIL)) {

        // Attempt to prepare query
        if ($stmt = $db->prepare($query)) {

            // Bind param
            $stmt->bind_param('s', $param_email);

            // Attempt to execute query
            if ($stmt->execute()) {
                
                // Store result
                $stmt->store_result();
                
                // Check if email exist
                if ($stmt->num_rows >= 1) {

                    // Bind result
                    $stmt->bind_result($email, $user, $name, $hash);
                    while ($stmt->fetch()){
                        echo "
                        <div class=\"table-responsive\">
                        <table class=\"table table-bordered\">
                        <tr>
                            <th>email</th>
                            <th>username</th>
                            <th>name</th>
                            <th>hash</th>
                        </tr>
                        <tr>
                            <td>$email</td>
                            <td>$user</td>
                            <td>$name</td>
                            <td>$hash</td>
                        </table>
                        </div>
                        ";
                    }
                } else {
                    // Email address not exist
                    echo "Record not found :)";
                }
            } else {
                // Execute fail
                echo $stmt->error;
            }
        } else {
            // prepare failed
            echo "Prep fail";
        }
    } else {
        // Email invalid
        echo "Invalid mail";
    }
} else {
    // No query string
    header("Location: index.html");
}

?>