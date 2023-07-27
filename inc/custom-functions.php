<?php
    /**
     * Functions which enhance the theme by hooking into WordPress
     *
     * @package NinjaHub
     */

//    $notifications = new \NH\APP\MODELS\FRONT\MODULES\Nh_Notification();
//    for ($i = 0; $i < 7; $i++) {
//        $notifications->send(13, 12, 'bidding', [ 'project_id' => '157' ]);
//    }


//    $ch = curl_init();
//
//    curl_setopt($ch, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/AC6fd8e3d3e4b54dcfbb681ebd0fec3cec/Messages.json');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_USERPWD, 'AC6fd8e3d3e4b54dcfbb681ebd0fec3cec' . ':' . '859d2d5288fd109930458ae91f2b342f');
//
//    // Disabling SSL Certificate verification
//    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//
//    $data = [
//        'To'   => '+2010169997000',
//        'From' => '+19894738633',
//        'Body' => 'test'
//    ];
//    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//
//    $result = curl_exec($ch);
//    if (curl_errno($ch)) {
//        echo 'Error:' . curl_error($ch);
//    }
//    curl_close($ch);