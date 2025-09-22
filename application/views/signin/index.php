<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo base_url('assets/images/favicon.png'); ?>" type="image/png">

    <title>Sign In - Bukukas</title>
    <!-- Masukkan link ke file CSS atau style Anda -->
    <style>
        body {
            font-family: Arial, sans-serif;
            <?php
        if (get_setting("show_background_image_in_signin_page") === "yes") {
            $background_url = get_file_uri('files/system/sigin-background-image.jpg');
            echo "background: url('$background_url') center/cover no-repeat fixed;";
        } else {
            echo "background: #fff;"; // Fallback background color if no image
        }
        ?>
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signin-box {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        .signin-box h2 {
            color: #333;
        }

        .signin-box img {
            width: 140px;
            height: 60px;
            border-radius: 0;
            margin-bottom: 20px;
        }

        .signin-box form {
            margin-top: 20px;
        }

        .signin-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #fff;
            border-radius: 4px;
        }

        .signin-box button {
            background-color: #D30110;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .signin-box button:hover {
            background-color: #2980b9;
        }
        .custom-alert {
    background-color: #f8d7da; /* Light red background color */
    border-color: #f5c6cb; /* Light red border color */
    color: #721c24; /* Dark red text color */
    border-radius: 5px; /* Rounded corners */
}
        footer {
            position: absolute;
            bottom: 10px;
            color: #fff;
        }
        /* Add this CSS in your style block or external stylesheet */
.logo-img {
    border-radius: 5px; /* Add a border-radius for a rounded look */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow */
    transition: transform 0.3s ease-in-out; /* Add a smooth transition effect on hover */
}

.logo-img:hover {
    transform: scale(1.1); /* Enlarge the logo slightly on hover */
}

    </style>
</head>
<body>
    <div class="signin-box">
       
        <?php
            if (isset($form_type) && $form_type == "request_reset_password") {
                $this->load->view("signin/reset_password_form");
            } else if (isset($form_type) && $form_type == "new_password") {
                $this->load->view('signin/new_password_form');
            } else {
                $this->load->view("signin/signin_form");
            }
            ?>
    </div>
    <footer><div align="center"><strong>Powered by Chaakra Consulting</strong></div></footer>
</body>
</html>
