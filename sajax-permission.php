<?php
require("db_config.php");

// Check if the AJAX request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the roleId and isChecked values from the POST data
    $roleId = isset($_POST['roleId']) ? $_POST['roleId'] : null;
    $isChecked = isset($_POST['isChecked']) ? $_POST['isChecked'] : null;
	$name = isset($_POST['name']) ? $_POST['name'] : null;
	
	

    // Validate and process the data
    if ($roleId !== null && ($isChecked === 'true' || $isChecked === 'false') && $name !== null) {
        // Convert the string 'true'/'false' to boolean
       
		
		if($isChecked === 'true')
		{
			$isChecked = 1;
		}
		else if($isChecked === 'false')
		{
			$isChecked = 0;
		}
		
				

		$sql = "update {$prefix}permissions set $name = $isChecked  where role_id = $roleId";
		mysqli_query($conn, $sql);

        // Send a response (you can customize this response based on your needs)
        echo 'Update successful!';
    } else {
        // Send an error response if the data is invalid
        http_response_code(400);
        echo 'Invalid data received.';
    }
} else {
    // Send an error response if the request method is not POST
    http_response_code(405);
    echo 'Invalid request method.';
}
?>
