<!DOCTYPE html>
<html lang="en">

<head>

	<base href="<?=base_url()?>" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lütfen Giriş Yapın.</title>

    <!-- Bootstrap Core CSS -->
    <link href="images/template/<?=$this->template->getName()?>/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="images/template/<?=$this->template->getName()?>/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="images/template/<?=$this->template->getName()?>/dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="images/template/<?=$this->template->getName()?>/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="images/template/<?=$this->template->getName()?>/bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="images/template/<?=$this->template->getName()?>/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Lütfen Giriş Yapın</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="login">
                            <input type="hidden" name="submit" value="1" />

                            <div class="infobox clearfix infobox-close-wrapper success-bg mrg20B" id="divInfoBox" style="display:none;">
                            <a href="#" title="Kapat" class="glyph-icon infobox-close icon-remove"></a>
                            <p>
                            <? if (isset($hata_mesaji)): ?>
                            <?=$hata_mesaji?>
                            <? endif;?>
                            </p>
                            </div>
                            <? if (isset($hata_mesaji)): ?>
                            <script> $("#divInfoBox").css("display", "block"); </script>
                            <? endif;?>

                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Kullanıcı Adı" name="txtUserName" type="txtUserName" autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Şifre" name="txtPassword" type="txtPassword" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" value="Giriş Yap" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="images/template/<?=$this->template->getName()?>/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="images/template/<?=$this->template->getName()?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="images/template/<?=$this->template->getName()?>/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="images/template/<?=$this->template->getName()?>/bower_components/raphael/raphael-min.js"></script>
    <script src="images/template/<?=$this->template->getName()?>/bower_components/morrisjs/morris.min.js"></script>
    <script src="images/template/<?=$this->template->getName()?>/js/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="images/template/<?=$this->template->getName()?>/dist/js/sb-admin-2.js"></script>



<? //=$content ?>
<script>
<?
$global_message = $this->session->flashdata("galobal_message");
if (strlen($global_message) > 0): ?>
$.notify("<?=$global_message?>", "success");
<? endif; ?>
</script>


</body>

</html>

