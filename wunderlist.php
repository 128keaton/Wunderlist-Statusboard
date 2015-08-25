<?php 

    //Defines
    $access_token = 'accesstoken';
    $client_id = 'client_id';
    
    // required to load (only when not using an autoloader)
    header('content-type: application/json; charset=utf-8');
    $tomorrow_id;
    $today_id;
    // set url
	//  echo($output);
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, "https://a.wunderlist.com/api/v1/lists");
    //return the transfer as a string
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, array(        'X-Access-Token: '.$access_token,        'X-Client-ID: '.$client_id    ));
    // $output contains the output string
    $output2 = curl_exec($ch2);
    $json = json_decode($output2, true);
    // close curl resource to free up system resources
    curl_close($ch2);
    foreach ($json as $key => $val) {
        
        if ($val['title'] == "Today"){
            //  echo ("Today! \n");
            $today_id = $val['id'];
        } else
        if ($val['title'] == "Tomorrow"){
            //  echo ("Tomorrow! \n");
            $tomorrow_id = $val['id'];
        }

    }

    
    if(!empty($tomorrow_id) && !empty($today_id)){
        $today = curl_init();
        curl_setopt($today, CURLOPT_URL, "https://a.wunderlist.com/api/v1/tasks?list_id=".$today_id);
        //return the transfer as a string
        curl_setopt($today, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array(        'X-Access-Token: '.$access_token,        'X-Client-ID: '.$client_id    ));
        // $output contains the output string
        $json = json_decode(curl_exec($today), true);
        // close curl resource to free up system resources
        $task_count_today = 0;
        foreach ($json as $key => $val['title']) {
            $task_count_today++;
        }

        curl_close($today);
        $tomorrow = curl_init();
        curl_setopt($tomorrow, CURLOPT_URL, "https://a.wunderlist.com/api/v1/tasks?list_id=".$tomorrow_id);
        //return the transfer as a string
        curl_setopt($tomorrow, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array(        'X-Access-Token: '.$access_token,        'X-Client-ID: '.$client_id    ));
        // $output contains the output string
        $json = json_decode(curl_exec($tomorrow), true);
        // close curl resource to free up system resources
        $task_count_tomorrow = 0;
        foreach ($json as $key => $val['title']) {
            $task_count_tomorrow++;
        }

        //echo($task_count_tomorrow);
        curl_close($tomorrow);
        $arr = array(        "graph" => array(            'title' => 'Tasks',            "refreshEveryNSeconds" => '120',            "datasequences" => array(                array(                    "title"=>"Today",                    "color" => "red",                    "datapoints" => array(                        array(                            "title" => "count",                            "value" => $task_count_today                        )                    )                ),                 array(                    "title"=>"Tomorrow",                    "color" => "green",                    "datapoints" => array(                        array(                            "title" => "count",                            "value" => $task_count_tomorrow                        )                    )                )            )        )    );
        echo json_encode($arr);
    }

    ?>