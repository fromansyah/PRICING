<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.csv-0.71.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
<script type="text/javascript">

$_base_url = '<?= base_url() ?>';
$_type = 'generate';

var $userfile;

$(document).ready(function(){

  $userfile = $('#userfile')[0];

  $userfile.focus();

  $('#btn_generate').click(function(){

    var fileInput = document.getElementById('userfile');
    var fileName = fileInput.files[0].name;

    if ($.trim($userfile.value) == '') {
      alert('File can not empty.');
      $userfile.focus();
      return false;
    }
    
    if ($_type == 'generate') {
        window.location = $_base_url + 'index.php/Upload/do_upload_customer/'+ fileName;
        //alert(fileName);
    }
  });
  
  $('#btn_cancel').click(function(){
    window.location = $_base_url + 'index.php/Customer/';
  });
  
  $('#download_template').click(function(){
    window.location = $_base_url + 'index.php/Customer/download_template';
  });
});

</script>
<br/><br/><br/><br/>
<div align="center">
<fieldset style="position: relative; width: 500px; height: 400px;">
    <legend>Upload Customer</legend>
    <br/>
    <br/>
    <input type="button" value="Download Template" id="download_template"  class="btn btn-primary"/>
    <br/>
    <br/>
    <p>
    Customer CSV File : <input type="file" name="userfile" id="userfile" size="20" class="input_text" accept=".csv"/>
    </p>
    <br/>
    <p>
        <input type="button" value="Upload" id="btn_generate" class="button_upload"/> &nbsp;
        <input type="button" value="Cancel" id="btn_cancel" class="button_cancel"/>
    </p>
</fieldset>
</div>
