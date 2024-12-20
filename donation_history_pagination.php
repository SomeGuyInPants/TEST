<?php  
  
 require ('database/connect_db.php');
 session_start();

 $admin = false;

 if(isset($_SESSION['username'])) {

     $username = $_SESSION['username'];
     $query = "SELECT * FROM `users` WHERE username = '$username' ";
     $result = mysqli_query($con, $query);
     $row= mysqli_fetch_array($result);

     $user_id = $row['user_id'];

     $adminResult = mysqli_query($con, "SELECT * FROM users WHERE is_admin = 1 AND user_id = $user_id");
     if(mysqli_num_rows($adminResult)) {
         $admin = true;
     }
 }
 else {
     session_unset();
 }

 $record_per_page = 8;  

 if(isset($_POST["page"]))  
 {  
      $page = intval($_POST["page"]);  
 }  
 else  
 {  
      $page = 1;  
    
 }  

 $start_from = ($page - 1)*$record_per_page;  
 $query = "SELECT * FROM donation_history WHERE user_id = '$user_id' LIMIT $start_from, $record_per_page";  
 $result = mysqli_query($con, $query);   

 $page_query = "SELECT * FROM donation_history WHERE user_id = '$user_id'";  
 $page_result = mysqli_query($con, $page_query);  
 $total_records = mysqli_num_rows($page_result);  
 $total_pages = ceil($total_records/$record_per_page);  

 echo "<table>
 <tr style='background: #ACBED8'>
     <th>Number</th>
     <th>Date </th>
     <th>Donation Amount</th>
     <th>Points Earned</th>
 </tr>";

 $counter = 1;
 
if(mysqli_num_rows($result)) {
    while($row = mysqli_fetch_array($result))  
    {  
        echo "<tr style='background: #E8EBF7'>
                <td>$counter</td>
                <td>$row[date]</td>
                <td>$row[donation_amount]</td>
                <td>$row[point_earned]</td>
            </tr>";

        $counter += 1;
    } 

    for($x = 0; $x < ($record_per_page - mysqli_num_rows($result)); $x++ ) {
        $counter = mysqli_num_rows($result) + 1 + $x;
        echo "
            <tr class='empty-record' style='background: #E8EBF7'>
                <td>$counter</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        ";
    }

} else {
for($x = 0; $x < ($record_per_page); $x++ ) {
        echo "
            <tr class='empty-record' style='background: #E8EBF7'>
                <td>$counter</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        ";

        $counter += 1;
    }
}

echo "
<tr class='empty-record' style='background: #ACBED8'>
<th></th>
<th></th>
<th></th>
<th></th>
</tr>
<span class='return button'>
<a href='profile.php'>Return to profile</a></span>
</table>

<br>

<div class='pagination'>";


if($total_pages == 0) {
    echo "<span class='pagination-link'>0</span>";
}
else {
// for first page
if ($page == 1) {
    
    echo "<span class='pagination-link inactive'><</span>";

    for($i = 1; $i <= $total_pages; $i++) {
        if($i == 1) {
          echo "<b><span class='pagination-link active' id='$i'>$i</span></b>";
        }
        else {
          echo "<span class='pagination-link' id='$i'>$i</span>";
        } 
    }

    if($total_pages > $page) {
        echo "<span class='pagination-link' id='2'>></span>";
    }

   
}

// for last page
elseif($page == $total_pages) {
    echo "<span class='pagination-link' id='".($page - 1)."'><</span>";
    
    for($i = 1; $i <= $total_pages; $i++) {
        if($i == $total_pages) {
          echo "<b><span class='pagination-link active' id='$i'>$i</span></b>";
        }
        else {
          echo "<span class='pagination-link' id='$i'>$i</span>";
        } 
    }
    
    echo "<span class='pagination-link inactive'>></span>";
}

// for middle pages
else {
    echo "<span class='pagination-link' id='".($page - 1)."'><</span>";

    for($i = 1; $i <= $total_pages; $i++) {
        if($i == $page) {
          echo "<b><span class='pagination-link active' id='$i'>$i</span></b>";
        }
        else {
          echo "<span class='pagination-link' id='$i'>$i</span>";
        } 
    }

    echo "<span class='pagination-link' id='".($page + 1)."'>></span>";
}
}

echo "</div>";






 ?>  

 