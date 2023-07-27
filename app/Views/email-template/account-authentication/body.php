<?php
    /**
     * @Filename: body.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     */

    $data = $variables['data'];
?>

<p>Dear <?= $data['user']->first_name ?>,</p>

<p>Thank you for choosing our platform! To ensure the security of your account, we have implemented an authentication process. As requested, we are providing you with your unique
   authentication code.</p>

<p>Authentication Code: <strong>[<?= $data['digits'] ?>]</strong></p>

<p>Please use this code to complete the authentication process within 5 minutes. If you did not request this code or believe it was sent to you in error, please disregard this
   email.</p>

<p>Please note that this code is confidential and should not be shared with anyone. Our support team will never ask you to disclose your authentication code.

<p>If you encounter any issues during the authentication process or have any questions, please feel free to contact our support team at support@nh.org.
   We are here to assist you.</p>

<p>Thank you for your cooperation.</p>

<p>Best regards,</p>