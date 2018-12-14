<link href="<?=$this->config->item('base_url');?>css/jquery.alert.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/table.css" />

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script>
/*
Auto Refresh Page with Time script
By JavaScript Kit (javascriptkit.com)
Over 200+ free scripts here!
*/
//enter refresh time in "minutes:seconds" Minutes should range from 0 to inifinity. Seconds should range from 0 to 59
    
var limit="15:00"
var $_base_url = '<?= base_url() ?>';

if (document.images){
    var parselimit=limit.split(":")
    parselimit=parselimit[0]*60+parselimit[1]*1
}

function beginrefresh(){
    if (!document.images)
        return
    
    if (parselimit==1)
        //window.location.reload()
        window.location = $_base_url + 'index.php/Menu_utama/'
    
    else{ 
        parselimit-=1
        curmin=Math.floor(parselimit/60)
        cursec=parselimit%60
        
        if (curmin!=0)
            curtime=curmin+" minutes and "+cursec+" seconds left until page refresh!"
        else
            curtime=cursec+" seconds left until page refresh!"
        
        window.status=curtime
        setTimeout("beginrefresh()",1000)
    }
}

window.onload=beginrefresh

function view_plan() {
      window.location = 'http://pricing-tomcat.azurewebsites.net/birt/frameset?__report=plan_notif_report.rptdesign&__format=xls';
}

</script>

<script type="text/javascript">
            google.load("visualization", "1.1", {packages: ["bar"]});
            google.setOnLoadCallback(drawChart);
            
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                        ['Category', 'Value'],
                        <?php
                            foreach ($asset_result as $asset) {
                                echo "['" . $asset->category . "'," . $asset->value . '],';
                            }
                        ?>
                    ]);
 
                var options = {
                    chart: {
                        title: 'Company Assets ' ,
                        subtitle: <?echo $asset_result[0]->year?>
                    }
                };
 
                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
 
                chart.draw(data, options);
            }
</script>

<script type="text/javascript">
    //load package
    google.load('visualization', '1', {packages: ['corechart']});

    <?php //$result = $pie_data;
    //get number of rows returned
    $num_results = count($asset_result);
    if( $num_results > 0){ ?>

            function drawVisualization() {
                // Create and populate the data table.
                var data = google.visualization.arrayToDataTable([
                    ['Asset', 'Value'],
                    <?php
                    foreach ($asset_result as $asset) {
                        echo "['" . $asset->category . "'," . $asset->value . '],';
                    } ?>
                ]);
                // Create and draw the visualization.
                new google.visualization.PieChart(document.getElementById('visualization')).
                draw(data, {title:""});
            }
 
            google.setOnLoadCallback(drawVisualization);

    <?php
    }else{
        echo "No data found.";
    } ?>
</script>
<? //print_r($notification)?>
<!--<fieldset style="position: absolute; left: 1%; width: 96%; height: 83%">-->
    <b><font size="3" color="grey">&nbsp;&nbsp;Notification :</font></b>
                <table width="100%">
                    <tr>
                        <td width="2%">
                        </td>
                        <td width="40%">
                            <table class="responstable">
                                <tbody STYLE=" height: 50px; width: 100px; font-size: 12px; overflow: auto;">
                                <?  foreach ($notification as $row):
                                        if($row->notif_count > 0):?>
                                <tr>
                                  <td align="left"><b><a style="font-size: 15px;" href="#" onclick="<?=$row->link?>('<?=$this->session->userdata("emp_id")?>')"><button class="<?=$row->class?>">&nbsp;<?=$row->notification?></button></a></b></td>
                                </tr>
                                <?      endif;
                                    endforeach;?>
                                </tbody>
                            </table>
                        </td>
                        <td width="50%">
                        </td>
                    </tr>
                </table>
            <!--</fieldset>-->
<table width="100%" height="78%">
    <tr>
        <td></td>
    </tr>
</table>
