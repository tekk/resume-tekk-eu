<?
/* 
Installation 
1.      Name this file counter.inc.php 
2.     Change the $expire variable's value to whatever you want 
3.     Set the date the counter was started, or comment it out of you don't want it 
4.     Insert the following date into the counter.log file or it won't work 
0 
100.42.162.106||1327934882 
5.      Upload the 2 files (counter.inc.php, counter.log) 
6.      CHMOD the counter.log file to 777 
7.      Include the counter.inc.php wherever you want to count your visits 
   
*/ 
     $date_started = "Feb, 28 2018"; 
     $expire= 120;                                                    // ip expires after $expire seconds 
     $logfile= "~/tekk.eu/web/counter.log"; // file where visits and ip logs are stored 
     
     // *************************** don't change anything below this line ************************* 
     $ip= getenv('REMOTE_ADDR'); 
     $visits=0; 
     $badhit= false; 
     $now= time(); 
     
     
     $ips = array(array()); 
     if (file_exists($logfile)) 
          { 
               if ($loggedips=file($logfile)) 
                    { 
                         $visits=trim($loggedips[0]); 
                         for ($i=1; $i< count($loggedips); $i++) 
                              { 
                                   $loggedips[$i]=trim($loggedips[$i]); 
                                   $ips[$i] = explode('||', $loggedips[$i]); 
                                   if (($ips[$i][0]==$ip) && ($now-$ips[$i][1]< $expire)) 
                                        $badhit= true; 
                              } 
                         if ($badhit) 
                              { 
                                   echo $visits; 
                                   if($date_started != "") { echo " visits since ". $date_started; } 
                              } 
                         else 
                              { 
                                   $visits++; 
                                   $fp= fopen($logfile, 'w'); 
                                   fputs($fp,"$visits\n"); 
                                   for ($i=1; $i< count($loggedips); $i++) 
                                        { 
                                             if ($now-$ips[$i][1] < $expire) 
                                                  { fputs($fp, $ips[$i][0]."||".$ips[$i][1]."\n"); } 
                                        } 
                                   fputs($fp, "$ip||$now\n"); 
                                   fclose($fp); 
                                   echo $visits;     
                                   if($date_started != "") { echo " visits since ". $date_started; } 
                              } 
                    } 
          } 
     else 
          { echo "logfile is missing"; } 
     
?>

