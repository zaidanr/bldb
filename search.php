<?php 
include("config.php");



$query = "SELECT `email`, `username`, `name`, `hash`  FROM bukalapak WHERE `email` = ?";

if(isset($_GET['q'])){
    $email = htmlspecialchars(trim($_GET['q']));

    // Check if email valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if($stmt = $db->prepare($query)){
                // Execute query
                $stmt->bind_param("s", $email);
                if(!$stmt->execute()){
                    echo $stmt->error;
                    return;
                }
                $stmt->store_result();  
                // Bind param
                $stmt = $stmt->bind_result($email, $user, $name, $hash);
                if($stmt->num_rows < 1) {
                    echo "No record found :)";
                } else {
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
                    };
                    
                }

            }
        } else { echo "Email invalid"}
} else {
    header("Location: index.html");
}

?>