<?php

$action=$_GET['action'];
switch($action){
    case 'getData':
        getData();
    break;

    case 'setSwitchState':
        setSwitchState();
    break;
}


function getData(){
    try{
    $dev=$_GET['dev'];
    $ip=$_GET['ip'];
    $sn=$_GET['sn'];
    $data=[];
    for($i=0;$i<count($dev);$i++){
        $sql='select marker from TestOrder where devnum=\''.$dev[$i].'\';';
        // echo $sql;
        $result=query_sql($ip[$i],$sql);
        // echo $result;
        $_data=$result->fetch_assoc();
        // echo $_data['marker'].'  ';
        $data[$sn[$i]]=$_data['marker'];
    }
    echo json_encode($data);
    exit();
}
catch(Exception $ex){
    echo 'error';
    exit();
}
}

function setSwitchState(){
    $ip=$_GET['ip'];
    $dev=explode(',',$_GET['dev']);
    $switchState=$_GET['switchState'];
    if($switchState=='true'){
        $state='1';
    }else{
        $state='0';
    }

    $devNum=count($dev);
    // echo $devNum;
    for($i=0;$i<$devNum;$i++){
        $sql='update TestOrder set marker='.$state.' where devnum=\''.$dev[$i].'\';';
        query_sql($ip,$sql);
        echo $sql;
    }
    // echo 'ip:'.$ip.'  dev:'.$dev[0].'  switchState:'.$switchState;
    // echo 'sdsdqwdwqdwqdq';
    exit();
}

//数据库查询
function query_sql($ip,$sql){
    $mysqli = new mysqli($ip,'root','te998','TEtest');
    $query = $mysqli->query($sql);
    $mysqli->close();
    return $query;
}
?>