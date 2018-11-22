<?
    if($num_fail == 0){
        echo 'Upload data success.';
        echo "<br/>".$num_success.' row(s) has been uploaded.';
    }elseif($num_success == 0){
        echo 'Upload data failed.';
        for($i=0;$i<count($fail);$i++){
            echo "<br/>Line ".$fail[$i].' '.$fail_cam[$i].' '.$fail_note[$i];
        }
    }else{
        echo $num_success.' row(s) has been uploaded.';
        echo "<br/>".  $num_fail.' row(s) fail to upload.';
        for($i=0;$i<count($fail);$i++){
            echo "<br/>Line ".$fail[$i].' '.$fail_cam[$i].' '.$fail_note[$i];
        }
    }
    
//        print_r($fail);
//        print_r($fail_sp);
//        print_r($fail_note);
?>