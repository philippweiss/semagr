<?php

function clearDatabase(){

    $sql = "DROP TABLE lvleiter_kurs, studienplanpunkt_kurs, termine";
    mysql_query($sql);
    $sql = "DROP TABLE kurs, lvleiter, studienplanpunkt";
    mysql_query($sql);
    $sql = "DROP TABLE studienfach, studienzweig";
    mysql_query($sql);
    $sql = "DROP TABLE studienrichtung, uni";
    mysql_query($sql);

    $sql = 'create table uni(id int(4) auto_increment primary key, title varchar(64));';
    mysql_query($sql);
    $sql = 'create table studienrichtung(id int(4) auto_increment primary key, title varchar(64), uni_id int(4), foreign key (uni_id) references uni(id));';
    mysql_query($sql);
    $sql = 'create table studienzweig (id int(4) auto_increment primary key, title varchar(64), studienrichtung_id int(4), foreign key (studienrichtung_id) references studienrichtung(id));';
    mysql_query($sql);
    $sql = 'create table studienfach(id int(4) auto_increment primary key, title varchar(64), studienzweig_id int(4), foreign key(studienzweig_id) references studienzweig(id));';
    mysql_query($sql);
    $sql = 'create table studienplanpunkt(id int(4) auto_increment primary key, title varchar(128), studienfach_id int(4), foreign key(studienfach_id) references studienfach(id));';
    mysql_query($sql);
    $sql = 'create table kurs(id int(8) primary key, type varchar(32), title varchar(128), sst int(2), language varchar(32));';
    mysql_query($sql);
    $sql = 'create table lvleiter(id int(8) auto_increment primary key, name varchar(128));';
    mysql_query($sql);
    $sql = 'create table termine(id int(8) auto_increment primary key, weekday varchar(8), start datetime, end datetime, place varchar(128), kurs_id int(4), foreign key(kurs_id) references kurs(id));';
    mysql_query($sql);
    $sql = 'create table studienplanpunkt_kurs(studienplanpunkt_id int(4), foreign key(studienplanpunkt_id) references studienplanpunkt(id), kurs_id int(8), foreign key(kurs_id) references kurs(id));';
    mysql_query($sql);
    $sql = 'create table lvleiter_kurs(lvleiter_id int(8), foreign key (lvleiter_id) references lvleiter(id), kurs_id int(8), foreign key (kurs_id) references kurs(id));';
    mysql_query($sql);
}

function dbconnect(){
    
    $con = mysql_connect('localhost','root','root');
    mysql_select_db('semagr');
    mysql_query( "set names 'utf8'" );
    
}

function makeDatetimes($date,$time){

    $datearray = explode('.',$date);
    $date = $datearray[2].'-'.$datearray[1].'-'.$datearray[0];
    $times = explode('-',str_replace(' Uhr','',$time));
    $starttime = $times[0].':00';
    $endtime = $times[1].':00';
    $start = $date.' '.$starttime;
    $end = $date.' '.$endtime;
    $datetimes = array($start,$end);
    //echo $datetimes[0].' '.$datetimes[1];
    return $datetimes;
}



function checkCookie(){
    
    if(isset($_COOKIE['id'])){
    
        $selectedLectures = array();
        $i = 0;
        
        foreach($_COOKIE['id'] as $name => $value){
                    
            $selectedLectures[$i] = $value;
            $i += 1;
        }
        
    return $selectedLectures;

    }
    
}

function checkTitle($id){
    
    dbconnect();
    $res = mysql_query('select title from class where id = '.$id);
    $data = mysql_fetch_assoc($res);
    return $data['title'];
    
   
}

function checkCollision($currentid){
    
    $selectedLectures = checkCookie();
    $currentlecture = array(array());
   
    dbconnect();
    $query = "select date, TIME_TO_SEC(start) as start, TIME_TO_SEC(end) as end from schedule where class_id = ".$currentid;
    $res = mysql_query($query);
    
    $i = 0;
    while($data = mysql_fetch_assoc($res)){
        
        $currentlecture[$i][0] = $data['date'];
        $currentlecture[$i][1] = $data['start'];
        $currentlecture[$i][2] = $data['end'];
        $i ++;
    }
    
    $currentlecturecut = $currentlecture;
    
    
   
    for($h = 0; $h < $i; $h++){
        
        foreach($selectedLectures as $x => $value){
                 
            
            if(!($currentid == $value)){
                
                $otherlecture = array(array());
                
                $query2 = "select date, TIME_TO_SEC(start) as start, TIME_TO_SEC(end) as end from schedule where class_id = ".$value;
                $res2 = mysql_query($query2);
                
                $j = 0;
                
                while($data2 = mysql_fetch_assoc($res2)){
                                   
                    $otherlecture[$j][0] = $data2['date'];
                    $otherlecture[$j][1] = $data2['start'];
                    //echo $data2['start']."s".$j."s";
                    $otherlecture[$j][2] = $data2['end'];
                    //echo $data2['end']."e".$j."e";
                    //echo $data2['date']."d".$j."d";
                    if($currentlecturecut[$h][0] == $otherlecture[$j][0]){ 
                                                
                        //cutstart
                        if($currentlecturecut[$h][1] > $otherlecture[$j][1] && $currentlecturecut[$h][1] < $otherlecture[$j][2] && $currentlecturecut[$h][2] > $otherlecture[$j][1] && $currentlecturecut[$h][2] > $otherlecture[$j][2]){
                            
                            $currentlecturecut[$h][1] = $otherlecture[$j][2];
                            //echo $currentlecturecut[$h][1]."s".$currentlecturecut[$h][2]."e";
                            //echo "a";
                        }
                        //cutend
                        elseif($currentlecturecut[$h][1] < $otherlecture[$j][1] && $currentlecturecut[$h][1] < $otherlecture[$j][2] && $currentlecturecut[$h][2] > $otherlecture[$j][1] && $currentlecturecut[$h][2] < $otherlecture[$j][2]){
                        
                            $currentlecturecut[$h][2] = $otherlecture[$j][1];
                            //echo "b";
                        }
                        //cutall
                        elseif($currentlecturecut[$h][1] > $otherlecture[$j][1] && $currentlecturecut[$h][1] < $otherlecture[$j][2] && $currentlecturecut[$h][2] > $otherlecture[$j][1] && $currentlecturecut[$h][2] < $otherlecture[$j][2]){
                        
                            $currentlecturecut[$h][2] = $currentlecturecut[$h][1];
                            //echo "c";
                        }
                        //cutmiddle
                        elseif($currentlecturecut[$h][1] < $otherlecture[$j][1] && $currentlecturecut[$h][1] < $otherlecture[$j][2] && $currentlecturecut[$h][2] > $otherlecture[$j][1] && $currentlecturecut[$h][2] > $otherlecture[$j][2]){
                        
                            $currentlecturecut[$h][2] -= ($otherlecture[$j][2] - $otherlecture[$j][1]);
                            //echo "d";                       
                        }
                        //else {echo "e";}
                        
                    }
                    //else {echo "f";}
                    
                
                    $j++;
                }
            }
        }
        
     }
     
    $sum = 0;            
    for($k=0; $k<$i; $k++){
                
            $sum += $currentlecture[$k][2] - $currentlecture[$k][1];
    }
            
    $cutsum = 0;            
    for($k=0; $k<$i; $k++){
                
            $cutsum += $currentlecturecut[$k][2] - $currentlecturecut[$k][1];
    }
   
    $result = round(($cutsum/$sum)*100);
   
    if($result >= 90){
        
        return "<div style='width:".$result."px' class='green' >".$result."%</div>";
    }
    if($result < 90 && $result >= 70){
        
        return "<div style='width:".$result."px' class='yellow' >".$result."%</div>";
    } 
    if($result < 70){
        
        return "<div style='width:".$result."px' class='red' >".$result."%</div>";
    }
    
    
    
}


    











?>