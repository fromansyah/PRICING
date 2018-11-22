<script type="text/javascript">

$_base_url = '<?= base_url() ?>';

$(document).ready(function(){
  $('#btn_cancel').click(function(){
    window.location = $_base_url + 'Backup_db';
  });
});

</script>
<br/><br/><br/><br/>
<br/><br/><br/><br/>
<fieldset style="position: absolute; top: 80px; left: 0px; width: 1200px; height: 180px">
    <font size ="small" color="green"><?=$message?></font>
    <br/>
    <font size ="small" color="green"><?=$message2?></font>
    <br/>
    <br/>
    <input type="button" value="OK" id="btn_cancel" class="button_ok"/>
</fieldset>

<table height="200" width="1300"></table>
