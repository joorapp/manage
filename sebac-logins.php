<?php 
session_start();
$role_id = $_SESSION['role_id'];
$user_id = $_SESSION['user_id'];

if($role_id == 1){
    require('sa-permission.php');
    require('sheader.php');
    require('sadmin-sidebar.php');
} elseif($role_id == 2){
    require('m-permission.php');
    require('mheader.php');
    require('manager-sidebar.php');    
} elseif($role_id == 3){
    require('am-permission.php');
    require('aheader.php');
    require('accountm-sidebar.php');    
} elseif($role_id == 4){
    require('cro-permission.php');
    require('croheader.php');
    require('cro-sidebar.php');    
} elseif($role_id == 5){
    require('mar-permission.php');
    require('marheader.php');
    require('marketer-sidebar.php');    
}

$servername = "localhost";
$username = "ebac_pro_2023";
$password = "ebac_pro_2023";
$dbname = "ebac_pro_2023";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 1: Get all login tables
$tablesQuery = "SELECT table_name 
                FROM information_schema.tables 
                WHERE table_schema = '$dbname' 
                AND table_name LIKE '%_logins'";

$tablesResult = $conn->query($tablesQuery);

$lastRecords = [];

while ($row = $tablesResult->fetch_assoc()) {
    $table = $row['table_name'];
    
    // Extract the prefix before '_logins'
    $prefix = str_replace('_logins', '', $table);
    
    // Step 2: Get the last record from each login table, ordered by date DESC
    $query = "SELECT id, email, `date`, ip FROM $table ORDER BY id DESC LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $record = $result->fetch_assoc()) {
        $lastRecords[] = array_merge($record, ['table_name' => $table, 'prefix' => $prefix]);
    }
}

// Sort the records by date in descending order
usort($lastRecords, function($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});


// Calculate days ago, ignoring exact time
function calculateDaysAgo($date) {
    $dateTime = new DateTime($date);
    $now = new DateTime();
    
    // Only compare the date part by resetting time to midnight
    $dateTime->setTime(0, 0);
    $now->setTime(0, 0);

    $interval = $now->diff($dateTime);

    // Return "Today" if difference is 0, otherwise add "day" or "days"
    if ($interval->days == 0) {
        return ["Today", "green"];
    } elseif ($interval->days == 1) {
        return ["Yesterday", "#ffc100"];
    } else {
        return ["{$interval->days} days ago", "red"];
    }
}




// Count total records
$totalCount = count($lastRecords);

// HTML structure to display the records
echo "<div class='main-panel'>
        <div class='content-wrapper'>
          <div class='row'>
            <div class='col-md-12 grid-margin'>
              <div class='row for_margin_bottom'>
                <div class='col-12 col-xl-8 mb-4 mb-xl-0'></div>            
              </div>
              <div class='row'>
                <div class='col-lg-12 grid-margin stretch-card'>
                  <div class='card for_box_shadow'>
                    <div class='card-body'>
                      <h4 class='card-title'>EBAC PRO last login list of $totalCount records</h4>
                      <div class='table-responsive'>
                        <table class='table table-striped'>
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Company</th>
                              <th>Email</th>
                              <th>Date</th>
                              <th>Last Used</th>
                              <th>IP</th>
                            </tr>
                          </thead>
                          <tbody>";

$serialNo = 1;
// Display the last records, sorted by date
foreach ($lastRecords as $record) {
     list($daysAgo, $color) = calculateDaysAgo($record['date']);
    echo "<tr>
            <td>{$serialNo}</td>
            <td>" .ucwords($record['prefix']) ."</td>
            <td>{$record['email']}</td>
            <td>" . date('d-m-Y h:i a', strtotime($record['date'])) . "</td>
            <td style='color: $color;'>{$daysAgo}</td>
            <td>{$record['ip']}</td>
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

$conn->close();
?>


<?php require('footer.php'); ?>