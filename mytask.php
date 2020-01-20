<?php include "inc/session.php"; ?>
<?php include "inc/db.php";?>
<!DOCTYPE html>
<html>
<title>My Task</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/theme.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/scrollbar.css">
<link rel="stylesheet" href="css/blue-grey.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Open Sans", sans-serif;}
h6{color:#fafafa;}

</style>

	<style> .w3-white a{
         text-decoration:none;
	  }
	  
@media (max-width: 867px) { 
	.m3 {display:none;}
    .m10    {
        width:99.99999%;
    }

.w3-col.m9 {
    width: 99.99999%!important; 
}

}
#error_message{
    background: #F3A6A6;
}
#success_message{
    background: #CCF5CC;
}
.ajax_response {
    padding: 10px 20px;
    border: 0;
    display: inline-block;
    margin-top: 20px;
    cursor: pointer;
	display:none;
	color:#555;
}


@media (max-width: 867px) { 
	.m2 {display:none;}
    .m9    {
        width:99.99999%;
    }

.w3-col.m10 {
    width: 99.99999%!important; 
}

}
		
    /*for small input box*/
	   @media only screen and (min-width: 800px){
      .w3-input{ width:70%;}
      }
	  </style>

<body class="w3-theme-l5">
	
<!-- Navbar -->
<?php include "inc/navbar.php"; ?>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
    
    <!-- Notification alert -->
<?php include "inc/alert.php"; ?>

  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m2">
      <!-- Profile -->
     <div class="w3-card-2 w3-round w3-white">
        <div class="w3-container">
         
         <p class="w3-center"><img src="images/employee/<?php echo $_SESSION['profile_picture']; ?>" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></p>
         <hr>
         <p><i class="fa fa-user fa-fw w3-margin-right w3-text-theme"></i><?php echo $_SESSION['fname']." ".$_SESSION['lname']; ?> </p>
         <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION['department']; ?></p>
         <p><i class="fa fa-id-badge fa-fw w3-margin-right w3-text-theme"></i> <?php echo $_SESSION['designation']; ?></p>
        </div>
      </div>
      <br>
	   <style> .w3-white a{
         text-decoration:none;
	  }
	  .w3-input {padding:2%;}
	  </style>
      
     <!-- Accordion -->
     <?php include "inc/accordian.php"; ?>
      <br>
      
     
    <!-- End Left Column -->
    </div>
    
    <!-- Middle Column -->
    <?php 
    
    // Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$emp_email = $_SESSION["email"];
$id= $_SESSION["id"];
$fnam = $_SESSION["fname"];
$lnam = $_SESSION["lname"];

$headers .= "From: ".$fnam." ".$lnam." ". strip_tags($emp_email) . "\r\n";
$headers .= "Reply-To: ". strip_tags($emp_email) . "\r\n";
?>

    <div class="w3-col m10">
       
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card-2 w3-round w3-white">
  
  <div class="w3-bar" style="background:#4d636f;color:#fff;">
    <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'mytask')">My Task</button> 
    <!-- <button class="w3-bar-item w3-button tablink" onclick="openCity(event,'completedtask')">View Task</button> -->
  </div>

    
<script>
$(document).ready(function() {
 $('.w3-cbtn').click(function() {
    var inval =  $(this).prev('input').val();
    var id =  $(this).prev('input').attr('id');
  
  
if(id == "" || inval == "" ) {
		$("#error_message").show().html("Fill the task progress");
	} 
	
if(inval>100){
		$("#error_message").show().html("Should be less than 100%");
	} else {
		$("#error_message").html("").hide();
		$.ajax({
			type: "POST",
			url: "process.php",
			data: "id="+id+"&inval="+inval,
			success: function(data){
				$('#success_message').fadeIn().html(data);
				setTimeout(function() {
					$('#success_message').fadeOut("slow");
				}, 5000 );
				location.reload(true);
			}
			
		});
	}
  
});

});
</script>


 <?php
      $sql = "SELECT * from tms_task_tracker WHERE user_id=$id order by assigned_on desc";
      echo ($sql);
      $sql_res = mysqli_query($dbc, $sql) or die(mysqli_error($dbc));
      ?>

   <div id="error_message" class="ajax_response w3-center"></div>
	<div id="success_message" class="ajax_response w3-center"></div>
	
	<div class="w3-white w3-container" style="margin-top:3%; margin-bottom:3%;">
	    <button class="w3-btn w3-right w3-teal w3-margin-right w3-round" onclick="tableToExcel('id02', 'W3C Example Table')"><i class="fa fa-file-excel-o"></i></button>
          <input oninput="w3.filterHTML('#id02', '.item', this.value)" placeholder="Search by any field.." class='w3-margin-right w3-right'>
          <span class="w3-right w3-margin-right"><?php echo date('d M Y'); ?></span>
    </div>
<div id="mytask" class="w3-container city">
   <div class="w3-row-padding w3-responsive w3-margin-bottom">
         	<table id="id02" border="1" class="w3-table-all" style='font-size:12px;'>
                <tr class='w3-blue w3-small'>
                  <th>Project</th>
                  <th>Start Date</th>
                  <th>End date</th>
                  <th>Description</th>
              	  <th>Assigned to</th>
              	  <th><font color="red">Delay</font>/<font color="green">Remaining</font></th>
              	  <th>Progress</th>
              	  <th>Complete(%)</th>
                </tr>
<?php
  while ($sql_rs = mysqli_fetch_assoc($sql_res)) : ?>

   <tr class="item">
       <?php $id = $sql_rs['id']; ?>
       
    <td><?php echo $sql_rs['project_name']; ?></td>
    <td><?php echo $sql_rs['start_date']; ?></td>
    <td><?php echo $sql_rs['end_date'];  ?></td>
    
    <td><?php echo $sql_rs['task_description'];  ?></td>
    
    <td><?php echo str_replace(',', '<br>',$sql_rs['assigned_to']); ?></td>
    
    <?php $current_date = date('Y-m-d');
     $interval = (strtotime($sql_rs['end_date']) - strtotime($current_date));
     $intervals =  ($interval / 86400); 
    if($intervals < 0) {echo "<td style='color:red;font-weight:bold;'>".$intervals.' Days'."</td>"; }
    if($intervals == 0) { echo  "<td style='color:orange;font-weight:bold;'>".$intervals.' Days'."</td>"; }
    if($intervals >= 1) { echo "<td style='color:green;font-weight:bold;'>".$intervals.' Days'."</td>"; }
?>
    
    <td><div class="w3-red w3-round"><div class="w3-round w3-blue" style="width:<?php echo $sql_rs["complete"].'%'; ?>" ><?php echo $sql_rs["complete"].'%'; ?>
    </div></div></td>
    
    <td><?php echo "<input type='number' id='$id' name='complete' placeholder='(Ex : 10%)' style='width:50%;'> &nbsp; 
    <button class='w3-button w3-blue w3-padding-small w3-hover-green w3-cbtn'>Update</button>"; ?></td>
    
  </tr>
<?php endwhile; ?>  
  
</table>
      
      </div> 
      


 </div>



<!--<div id="completedtask" class="w3-container w3-border city w3-animate-right" style="display:none">

</div>-->



          </div>
       </div>
    </div>
      
      
    <!-- End Middle Column -->
    </div>
    
   
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<!-- Footer -->
<footer class="w3-container w3-theme-d3 w3-padding-16">
  <h5>Footer</h5>
</footer>

<footer class="w3-container w3-theme-d5">
  
</footer>
 
<script>
// Accordion
function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
    } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
    }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

<script>
function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("city");
  for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " w3-red";
}

var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
</script>
<script src="https://www.w3schools.com/lib/w3.js"></script>
</body>
</html> 
