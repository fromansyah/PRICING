<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.csv-0.71.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">

<script type="text/javascript">

var _base_url = '<?= base_url() ?>';

function back()
{
    window.location = _base_url + 'Employee/new_upload_emp/';
}

</script>
<?php   
//    $path="C:/xampp/htdocs/PRICING/csv";
    $path=base_url()."csv";
    $file="log_employee.txt";
?>
<br/><br/><br/>
<button class="btn btn-warning" onclick="back()"><i class="glyphicon glyphicon-backward"></i> Back</button>
<div id="logFile">
    <h2>Log File Employee</h2>
    <code>
        <pre><? echo htmlspecialchars(file_get_contents("$path/$file")); ?></pre>
    </code>
</div>

