<?php 
session_start();
$role_id = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];

if($role_id == 1){
require('sa-permission.php');
require('sheader.php');
require('sadmin-sidebar.php');
}elseif($role_id == 2){
require('m-permission.php');
require('mheader.php');
require('manager-sidebar.php');	
}elseif($role_id == 3){
require('am-permission.php');
require('aheader.php');
require('accountm-sidebar.php');	
}elseif($role_id == 4){
require('cro-permission.php');
require('croheader.php');
require('cro-sidebar.php');	
}elseif($role_id == 5){
require('mar-permission.php');
require('marheader.php');
require('marketer-sidebar.php');	
}
?>

<?php
$servername = "localhost";
$username = "ebac_pro_2023";
$password = "ebac_pro_2023";
$dbname = "ebac_pro_2023";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch table names with '_customers'
$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = '$dbname' AND table_name LIKE '%_customers'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $unionQuery = "";

    while ($row = $result->fetch_assoc()) {
        $tableName = $row['table_name'];

        // Check if the 'next_ren' column exists in the table
        $columnCheckQuery = "SHOW COLUMNS FROM $tableName LIKE 'next_ren'";
        $columnCheckResult = $conn->query($columnCheckQuery);

        if ($columnCheckResult->num_rows > 0) {
            $unionQuery .= "SELECT id, cust_id, address_1, next_ren, '$tableName' AS table_name FROM $tableName WHERE id = 1 UNION ";
        }
    }

    // Remove the last UNION and add ORDER BY clause
    $unionQuery = rtrim($unionQuery, " UNION ");
    //echo "Constructed UNION query:<br>$unionQuery<br><br>";

    // Get the count of records
    $countQuery = "SELECT COUNT(*) as total FROM ($unionQuery) as combined_query";
    $countResult = $conn->query($countQuery);

    $totalCount = 0;
    if ($countResult !== false) {
        $countRow = $countResult->fetch_assoc();
        $totalCount = $countRow['total'];
    } else {
        echo "Error executing COUNT query: " . $conn->error;
    }

    // Append ORDER BY to the original UNION query
    $unionQuery .= " ORDER BY cust_id";

    if (!empty($unionQuery)) {
        $finalResult = $conn->query($unionQuery);

        if ($finalResult === false) {
            echo "Error executing UNION query: " . $conn->error;
        } elseif ($finalResult->num_rows > 0) {
            echo "<div class='main-panel'>
                    <div class='content-wrapper'>
                      <div class='row'>
                        <div class='col-md-12 grid-margin'>
                          <div class='row for_margin_bottom'>
                            <div class='col-12 col-xl-8 mb-4 mb-xl-0'>               
                            </div>            
                          </div>
                          <div class='row'>
                            <div class='col-lg-12 grid-margin stretch-card'>
                              <div class='card for_box_shadow'>
                                <div class='card-body'>
                                  <h4 class='card-title'>EBAC PRO renewal list of $totalCount records</h4>
                                  <div class='table-responsive'>
                                    <table class='table table-striped'>
                                      <thead>
                                        <tr>
                                          <th>#</th>
                                          <th>Cust ID</th>
                                          <th>Company</th>
                                          <th>Next Renewal</th>
                                        </tr>
                                      </thead>
                                      <tbody>";

            $serialNo = 1;
            while ($row = $finalResult->fetch_assoc()) {
                echo "<tr>
                        <td>{$serialNo}</td>
                        <td>{$row['cust_id']}</td>
                        <td>{$row['address_1']}</td>
                        <td>
                            <input type='text' value='{$row['next_ren']}' onchange='updateNextRen({$row['id']}, \"{$row['table_name']}\", this.value)'>
                        </td>
                      </tr>";
                $serialNo++;
            }
            echo "</tbody>
                                    </table>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>              
                        </div>
                      </div>
                    </div>";
        } else {
            echo "No results found in UNION query.";
        }
    } else {
        echo "No customer tables contain the 'next_ren' column.";
    }
} else {
    echo "No customer tables found.";
}

$conn->close();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateNextRen(id, tableName, newValue) {
    $.ajax({
        url: 'update-next-ren.php',
        type: 'post',
        data: { id: id, table_name: tableName, next_ren: newValue },
        success: function(response) {
            alert('Next Renewal updated successfully!');
        },
        error: function(xhr, status, error) {
            console.error('Status:', status);
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
            alert('Failed to update Next Renewal: ' + xhr.responseText);
        }
    });
}
</script>

<?php require('footer.php'); ?>
