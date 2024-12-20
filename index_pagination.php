<?php  
  
 require ('database/connect_db.php');

 $record_per_page = 6;  

 if(isset($_POST["page"]))  
 {  
      $page = intval($_POST["page"]);  
 }  
 else  
 {  
      $page = 1;  
    
 }  

 $start_from = ($page - 1)*$record_per_page;  
 $query = "SELECT * FROM donation_history LIMIT $start_from, $record_per_page";  
 $result = mysqli_query($con, $query);   

 $page_query = "SELECT * FROM donation_history";  
 $page_result = mysqli_query($con, $page_query);  
 $total_records = mysqli_num_rows($page_result);  
 $total_pages = ceil($total_records/$record_per_page);  

 if($total_pages == 0) {
    echo "<table>
    <tr>
        <th class='first-col empty'></th>
        <th style='width: 60px;border-left:1px solid #ACBED8'></th>
    </tr>";
 }
 else {
    echo "  
    <table>
    <tr>
        <th class='first-col'>Donators</th>
        <th>Amount</th>
    </tr>";
 }


if(mysqli_num_rows($result)) {
    while($row = mysqli_fetch_array($result))  
    {  
        echo "
        <tr>
        <td class='first-col'>$row[name] <br>$row[date]</td>
        <td class='second-col'>RM $row[donation_amount]</td>
        </tr>
        ";  
    } 
} 
else {
    echo "
    <tr>
        <td class='second-col' colspan=2> No Donation Records Found <br> Be the first to donate now!</td>
    </tr>
    ";
}
 
if($total_pages == 0) {
    echo "
    <tr>
    <th class='bottom-row empty'></th>
    <th style='width: 60px;border-left:1px solid #ACBED8'></th>
    </tr>
    </table><br>";
}
else {
    echo "
    <tr><th class='bottom-row'></th>
    <th></th>
   </tr>
   </table><br>"; 
}

 



if($total_pages == 0) {
    echo "<span style='font-size:32px'>0</span>";
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




 


 ?>  

 