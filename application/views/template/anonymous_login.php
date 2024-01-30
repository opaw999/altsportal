<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>AltSPortal | Login Page</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="Timekeeping Portal" name="description" />
    <meta content="altsportal,timekeeping,portal,timekeeping portal,dtr" name="keywords">
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link rel="shortcut icon" href="<?php echo base_url('favicon (1).ico'); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo base_url('favicon (1).ico'); ?>" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/bootstrap/4.1.3/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/font-awesome/css/all.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/animate/animate.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/default/style.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/default/style-responsive.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/default/theme/default.css'); ?>" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="<?php echo base_url('assets/plugins/parsley/src/parsley.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/plugins/gritter/css/jquery.gritter.css'); ?>" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url('assets/plugins/pace/pace.min.js'); ?>"></script>
    <!-- ================== END BASE JS ================== -->
</head>

<body class="pace-top">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin login-cover -->
    <div class="login-cover">
        <?php

        // $imagesDir = 'assets/img/login-bg/';
        // $images = glob($imagesDir . '*.{jpg,jpeg,png}', GLOB_BRACE);
        // $randomImage = $images[array_rand($images)];

        $portal_bg = 'assets/img/login-bg/portal.jpg';
        ?>
        <div class="login-cover-image" style="background-image: url(<?php echo base_url($portal_bg); ?>)" data-id="login-cover-image"></div>
        <div class="login-cover-bg"></div>
    </div>
    <!-- end login-cover -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-v2" data-pageload-addclass="animated fadeIn">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <!-- <span class="logo"></span> <b>Promo</b> DTR -->
                    <span class=""><img src="<?php echo base_url('assets/img/logo/asp7.png'); ?>" width="70%"></span>
                    <small>Alturas Supplier's Portal</small>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <form id="login-form" data-parsley-validate="true" action="" method="post" class="margin-bottom-0">
                    <div class="form-group m-b-20">
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" data-parsley-required="true" />
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" data-parsley-required="true" />
                    </div>
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-success btn-block btn-lg sign_in"><span class="loading_"> Sign me in</span></button>
                    </div>
                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login -->
    </div>
    <!-- end page container -->
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?php echo base_url('assets/plugins/jquery/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/4.1.3/js/bootstrap.bundle.min.js'); ?>"></script>

    <script src="<?php echo base_url('assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/js-cookie/js.cookie.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/theme/default.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/apps.min.js'); ?>"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?php echo base_url('assets/js/demo/login-v2.demo.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/parsley/dist/parsley.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/highlight/highlight.common.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/demo/render.highlight.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/gritter/js/jquery.gritter.js'); ?>"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
            LoginV2.init();
            Highlight.init();


            $("form#login-form").submit(function(e) {

                e.preventDefault();
                var formData = new FormData(this);

                $("button.sign_in").prop("disabled", true);
                $("span.loading_").html('<i class="fas fa-spinner fa-pulse"></i> Signing in...');
                $.ajax({
                    url: "<?php echo site_url('anonymous/authentication'); ?>",
                    type: 'POST',
                    data: formData,
                    success: function(data) {

                        response = data.trim();
                        if (response == "success") {

                            location.replace("<?= base_url() ?>")

                        } else {

                            $("button.sign_in").prop("disabled", false);
                            $("span.loading_").html('Sign me in');
                            $.gritter.add({
                                image: '<?php echo base_url('assets/plugins/gritter/images/warning.png'); ?>',
                                title: 'Opsss!',
                                text: 'Invalid Account! Sorry you cannot login.'
                            });

                            return false;
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>
</body>

</html>