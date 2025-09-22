<div class="panel panel-default mb15">
    <div class="panel-heading text-center">
        <?php if (get_setting("show_logo_in_signin_page") === "yes") { ?>
            <h2 id="login-title"></h2>
            <a href="<?php echo base_url() ?>">
                <img class="logo-img" src="<?php echo get_file_uri(get_setting("system_file_path") . get_setting("site_logo")); ?>" width="60" alt="Logo">
            </a>
        <?php } else { ?>
            <h2 id="login-title"></h2>
        <?php } ?>
    </div>
</div>
<!-- Modal -->
<div class="panel-body p30" align="center">
    <div id="formLogin">
        <?php echo form_open("signin", array("id" => "signin-form", "class" => "general-form", "role" => "form")); ?>
        <?php if (validation_errors()) { ?>
            <div class="alert custom-alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <div class="form-group">
            <?php
            echo form_input(array(
                "name" => "email",
                "class" => "form-control p10",
                "placeholder" => lang('email'),
                "autofocus" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
                "data-rule-email" => true,
                "data-msg-email" => lang("enter_valid_email")
            ));
            ?>
        </div>
        <div class="form-group">
            <?php
            echo form_password(array(
                "name" => "password",
                "class" => "form-control p10",
                "placeholder" => lang('password'),
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required")
            ));
            ?>
        </div>
        <input type="hidden" name="redirect" value="<?php
                                                    if (isset($redirect)) {
                                                        echo $redirect;
                                                    }
                                                    ?>" />

        <div class="form-group mb0">
            <button class="btn btn-lg btn-primary btn-block mt15" type="submit"><?php echo lang('signin'); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
    <div id="containerLoginSso">
        <div id="msgFormSso">
        </div>
        <form action="<?= base_url('signin/sso_login'); ?>" method="post" id="formLoginSso">
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <div style="margin-top: 10px;">
                <button type="submit" class="btn btn-lg btn-primary btn-block mt15" id="btnLoginSso">Login</button>
            </div>
        </form>
    </div>
    <div style="padding-top: 10px;">
        <a href="" id="loginSso">Login SSO Chaakra</a>
        <a href="" id="loginForm">Login Primary</a>
    </div>
    <!--<div class="mt5"><?php echo anchor("signin/request_reset_password", lang("forgot_password")); ?></div>-->

    <?php if (!get_setting("disable_client_signup")) { ?>
        <div class="mt20"><?php echo lang("you_dont_have_an_account") ?> &nbsp; <?php echo anchor("signup", lang("signup")); ?></div>
    <?php } ?>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $("#containerLoginSso").hide();
            $("#loginForm").hide();
            $("#login-title").text('Login')
            $("#loginSso").click(function(e) {
                e.preventDefault();
                $("#formLogin").hide();
                $("#loginSso").hide();

                $("#loginForm").fadeIn(300);
                $("#containerLoginSso").slideDown(300);
                $("#login-title").text('Login SSO')
            })

            $("#loginForm").click(function(e) {
                e.preventDefault();
                $("#containerLoginSso").hide(300);
                $("#loginSso").show();

                $("#loginForm").hide();
                $("#formLogin").slideDown(300);
                $("#login-title").text('Login')
            })

            $("#formLoginSso").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function() {
                        $("#btnLoginSso").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                    },
                    success: function(data) {
                        if (data.success == true) {
                            if (data.data_app != null) {
                                $("#msgFormSso").html('<div style="color:green;">Login Berhasil</div>');
                                $("#btnLoginSso").html('Login');
                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 1000);
                            } else {
                                $("#msgFormSso").html('<div style="color:red;">Akun belum di sinkronisasi</div>');
                                $("#btnLoginSso").html('Login');
                            }
                        } else {
                            $("#msgFormSso").html('<div style="color:red;">Username atau password salah</div>');
                            $("#btnLoginSso").html('Login');
                        }
                    }
                })
            })
        })
    </script>
</div>