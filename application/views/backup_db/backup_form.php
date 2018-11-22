<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.csv-0.71.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<!DOCTYPE html>
<head>
<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

$(document).ready(function(){

  $('#btn_generate').click(function(){
        window.location = $_base_url + 'Backup_db/do_backup';
  });
  

  $('#btn_cancel').click(function(){
    window.location = $_base_url + 'Menu_utama';
  });
});

</script>
    </head>
    <body>
        <br/><br/><br/><br/>
        <div align="center">
        <fieldset style="position: relative; width: 500px; height: 300px;">
            <legend>Back Up Database</legend>
            <br/><br/><br/>
            <p>
                <input type="button" value="Back Up" id="btn_generate" class="button_backup"/> &nbsp;
                <input type="button" value="Cancel" id="btn_cancel" class="button_cancel"/>
            </p>
        </fieldset>
        </div>
    </body>
</html>
<table height="30%" width="50%"><tr><td></td></tr></table>

