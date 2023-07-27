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

<p>Thank you for choosing to register with NH! We're excited to have you join our growing community of businesses.</p>

<p>Before we can get started, we need to verify your email address to ensure the security of your account.</p>

<p>Your verification code is: <strong>[<?= $data['digits'] ?>]</strong></p>

<p>Please note, this verification code is only valid for the next 5 minutes. If you did not request this verification code, please ignore this email, and consider changing your
        password as a precautionary measure.</p>

<p>Should you have any questions or need further assistance, don't hesitate to contact our support team at info@nh.org.</p>

<p>We look forward to supporting your business needs!</p>

<p>Best Regards,</p>

<p>P.S: Never share your verification code with anyone. We will never ask for this information via email, phone, or any other communication method.</p>
