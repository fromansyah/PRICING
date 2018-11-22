<link href="<?= base_url() ?>css/new_menu.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/new_menu.js" type="text/javascript"></script>

<head>
<link href="<?= base_url() ?>css/backoff_ssek.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>js/utility.js" type="text/javascript"></script>

<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />

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
                            <b><a style="text-decoration:none" href="<?= base_url() ?>Welcome/logout"><button class="button_logout">Log Out</button></a></b>
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
<br />
<body>
    <? echo $this->dynamic_menu->build_menu('1'); ?>
<br />
<br />
<div id="content" 
     style="width: auto; height: 548; overflow-y: scroll; top: 85;">
    <br/>
    <?= $content ?>
    <?
        if ($this->session->userdata('username')):
          $this->load->view('vfooter');
        endif;
    ?>
</div>
</body>
</html>