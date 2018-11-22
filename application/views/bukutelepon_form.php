<!doctype html>

<script type="text/javascript">
$(document).ready(function () {
$('#yellow-trigger').click(function () {
    $('#red-box').hide();
    $('#yellow-box').fadeIn('slow');
});

$('#red-trigger').click(function () {
    $('#yellow-box').hide();
    $('#red-box').fadeIn('slow');     
});

});
</script>


<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
 <!--   <body>
        <h2 style="margin-top:0px">Bukutelepon <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
                <label for="varchar">nama <?php echo form_error('nama') ?></label>
                <input type="text" class="form-control" name="nama" id="nama" placeholder="nama" value="<?php echo $nama; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">alamat <?php echo form_error('alamat') ?></label>
                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="alamat" value="<?php echo $alamat; ?>" />
            </div>
	    <div class="form-group">
                <label for="varchar">notelepon <?php echo form_error('notelepon') ?></label>
                <input type="text" class="form-control" name="notelepon" id="notelepon" placeholder="notelepon" value="<?php echo $notelepon; ?>" />
            </div>
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('bukutelepon') ?>" class="btn btn-default">Cancel</a>
	</form>
    </body>-->
    <div class="control-group">
    <label class="control-label">Choose one:</label>
    <div class="controls">
        <label class="radio inline">
            <input type="radio" name="color-radio" id="yellow-trigger" value="yellow" />Yellow Box</label>
        <label class="radio inline">
            <input type="radio" name="color-radio" id="red-trigger" value="red" />Red Box</label>
    </div>
</div>
        <div id="yellow-box" class="hide">
            <p>I'm yellow</p>
        </div>
        <div id="red-box" class="hide">
            <p>I'm red</p>
        </div>
</html>

