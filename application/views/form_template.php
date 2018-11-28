<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="<?= base_url() ?>css/backoff_ssek.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/datePicker.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/jquery.datePicker.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/jquery-1.8.0.min.js" type="text/javascript"></script>
<link href="<?=$this->config->item('base_url');?>/css/style.css" rel="stylesheet" type="text/css" />

<link href="<?= base_url() ?>css/new_menu.css" rel="stylesheet" type="text/css" />
<link href="<?= base_url() ?>css/backoff_ssek.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>/css/style.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/new_menu.js" type="text/javascript"></script>

<link rel="icon" type="image/gif" href="<?= base_url() ?>images/icon_ecolab.jpg" /> 
<title>
    <?
    $title_ = "";
    if (isset($title)) {
        $title_ = " - " . $title;
    }
    if ($this->config->item('nama_aplikasi')):
        echo $this->config->item('nama_aplikasi').$title_;
    endif;
    ?>
</title>
</head>
<body bgcolor="#E9EDFF">
    
    <?
    if ($this->session->userdata('username')):
    ?>
        <div id="alert-box">
            <table width="100%" border="0">
            <td>
                &nbsp;<img border="0" src="<?= base_url() ?>images/ecolab_logo.jpg"/>
            </td>
<!--            <td>
            <?if($this->session->userdata("user_group")=='ADMIN'):?>
                <?if($this->session->userdata("mode")=='USER'):?>
                    <td valign="bottom" width="10%">
                        <b><a style="text-decoration:none" href="<?= base_url() ?>Menu_utama/change_mode"><button class="button_logout">Admin Mode</button></a></b>
                    </td>
                <?else:?>
                    <td valign="bottom" width="10%">
                        <b><a style="text-decoration:none" href="<?= base_url() ?>Menu_utama/change_mode"><button class="button_logout">User Mode</button></a></b>
                    </td>
                <?endif;?>
            <?endif;?>
                
            </td>-->
            <td valign="top" align="right">
                <table>
                    <tr>
                        <td valign="middle" align="right">
                          
                        </td>
                    </tr>
                    <tr>
                        <td valign="bottom" align="right">
                            <b><font color="#FFFFFF">Welcome <?= $this->session->userdata("fullname") ?> </font></b>
                            <!--<b><font color="#FFFFFF">User ID. : <?= $this->session->userdata("username") ?></font></b>-->
                            <!--<b><font color="#FFFFFF">| Grup: <?= $this->session->userdata("user_group") ?> | </font></b>-->
                            <b><a style="text-decoration:none" href="<?= base_url() ?>index.php/Welcome/logout"><button class="button_logout">Log Out</button></a></b>
                        </td>
                    </tr>
                </table>
                
            </td>
        </table>
        </div>
    <?
    endif;
    ?>

<br />
</body>
<script type="text/javascript" src="/resources/js/plugins/google/analytics/gatag.js"></script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7365212-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</html>
<div id="content">
    <?= $content ?>
</div>

<br/>

<?
    if ($this->session->userdata('username')):
      $this->load->view('vfooter');
    endif;
?>

</body>
</html>
