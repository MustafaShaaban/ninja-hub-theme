<?php
    /**
     * @Filename: notifications-ajax.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;

    $notifications_obj = new Nh_Notification();
    $nh_notification  = $args['data'];
    $notification      = $notifications_obj->notification_html($notifications_obj->assign($nh_notification));


?>
<div class="ninjanotification-item <?= $notification->new ? 'ninjanew-notification' : '' ?>" data-id="<?= $notification->ID ?>">
    <a href="<?= $notification->url ?>">
        <div class="row">
            <div class="col-sm-2">
                <div class="ninjanotification-image">
                    <img src="<?= $notification->thumbnail ?>" alt="<?= __('Notification Thumbnail', 'ninja') ?>"/>
                </div>
            </div>
            <div class="col-sm-10">
                <div class="ninjanotification-content">
                    <h6><?= $notification->title ?></h6>
                    <p><?= $notification->content ?></p>
                    <span><?= $notification->date ?></span>
                </div>
            </div>
        </div>
    </a>
</div>
