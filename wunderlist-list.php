//Defines
<?php
$token=
$id=

?>


 <style>
 .taskName{
     font-size: 22px;
     text-align: center;
 }
 .divider img{
     height: 60%;
     float: right;
     vertical-align: middle;
     margin-top: 6px;
     fill: rgb(255,0,0);
     
 }
 .divider{
     vertical-align: middle;
     line-height: 120%;
 }
 
 </style>
<?php // required to load (only when not using an autoloader)


$tomorrow_id;
$today_id;
// set url

//  echo($output);
$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_URL, "https://a.wunderlist.com/api/v1/lists");


//return the transfer as a string
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
        'X-Access-Token: '.$token,
        'X-Client-ID: '.$id
    ));
// $output contains the output string
$output2 = curl_exec($ch2);
$json = json_decode($output2, true);
// close curl resource to free up system resources

curl_close($ch2);
foreach ($json as $key => $val) {
    if ($val['title'] == "Today"){
         // echo ("Today! \n");
        $today_id = $val['id'];
        
        
    }else if ($val['title'] == "Tomorrow"){
            //  echo ("Tomorrow! \n");
            $tomorrow_id = $val['id'];
        }

}

$ch3 = curl_init();

curl_setopt($ch3, CURLOPT_URL, "https://a.wunderlist.com/api/v1/tasks?list_id=".$today_id);


//return the transfer as a string
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
        'X-Access-Token: '.$token,
        'X-Client-ID: '.$id
    ));

// $output contains the output string
$output3 = curl_exec($ch3);

$json2 = json_decode($output3, true);
// close curl resource to free up system resources
$tasksToday = Array();

foreach ($json2 as $key => $val) {
array_push($tasksToday, $val['title']);

}


curl_close($ch3);

$ch4 = curl_init();

curl_setopt($ch4, CURLOPT_URL, "https://a.wunderlist.com/api/v1/tasks?list_id=".$tomorrow_id);


//return the transfer as a string
curl_setopt($ch4, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch4, CURLOPT_HTTPHEADER, array(
        'X-Access-Token: '.$token,
        'X-Client-ID: '.$id
    ));

// $output contains the output string
$output4 = curl_exec($ch4);

$json3 = json_decode($output4, true);
// close curl resource to free up system resources
$tasksTomorrow = Array();

foreach ($json3 as $key => $val) {
array_push($tasksTomorrow, $val['title']);

}


curl_close($ch4);




?>

<table id="projects">
<tr><td  class="divider">Today:<img src="alert.png" alt="calendar-bang@2x" width="" height="" /></td></tr>
	<?php
	if(count($tasksToday) == 0 && count($tasksTomorrow) == 0){
    	echo '<tr><td></td></tr><tr><td></td></tr><tr><td><h3 class = "no-torrents">No Tasks</h3></td></tr>';
	}
	foreach($tasksToday as $task){
    
    $green = '#72f455';
    $blue = '#33a0af';




	
	
echo'	<tr>
		<td class="taskName" style="width: auto">'.$task.'</td>
       

	</tr>';
	
	}
	echo'<tr><td class="divider">Tomorrow:</td></tr>';
	foreach($tasksTomorrow as $task){
    
    $green = '#72f455';
    $blue = '#33a0af';




	
	
echo'	<tr>
		<td class="taskName" style="width: auto">'.$task.'</td>
       

	</tr>';
	
	}


	
	?>
	

