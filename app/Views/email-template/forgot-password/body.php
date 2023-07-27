<?php
    /**
     * @Filename: body.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     */

    $data = $variables['data'];
?>
<p>Dear
    <?= $data['user']->first_name ?>,
</p>

<p>We have received a request to reset your password for Nh. To ensure the security of your account, please
   follow the instructions below to reset your password: </p>

<p>Click on the following link to access the password reset page: <a href="<?= $data['url_query'] ?>"><?= $data['url_query'] ?></a>
   If the link above does not work, copy and paste the entire URL into your web browser's address bar.</p>

<p>Once you access the password reset page, you will be prompted to enter a new password for your account.
   Please
   choose a strong password that is unique and not easily guessable.</p>

<p>After setting your new password, click on the "Reset Password" button to confirm the changes.</p>

<p>If you did not initiate this password reset request, please disregard this email. Your current password will
   remain unchanged.</p>

<p>Please note that for security reasons, the password reset link will expire after 1 hour. If you don't reset
   your password within this timeframe, you may need to request another password reset.</p>
