<?php
    /**
     * @Filename: notifications.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use NH\APP\MODELS\FRONT\MODULES\Nh_Notification;

    global $user_ID;
    $notifications_obj = new Nh_Notification();

    $notifications = $notifications_obj->get_notifications();
    $count         = $notifications['new_count'];
    $found_posts   = $notifications['found_posts'];

    // TODO:: Create cronjob to remove old notifications
?>

<div class="nh-notifications">
    <div class="bell">
        <button class="btn nh-notification-bell" data-count="<?= $count ?>">
            <span class="nh-notification-count"><?= $count ?></span>
            <i class="fa-regular fa-bell"></i>
        </button>
    </div>
    <div class="nh-notification-list container" data-page="2" data-last="<?= $found_posts > 10 ? 0 : 1 ?>">
        <div class="nh-notification-group-container">
            <?php
                if (!empty($notifications['notifications'])) {
                    ?>
                    <div class="nh-notification-clear-parent">
                        <button class="btn nh-notification-clear">
                            <?= __('clear all') ?>
                        </button>
                    </div>
                    <div class="nh-notifications-group">
                        <?php
                            foreach ($notifications['notifications'] as $notification) {
                                ?>
                                <div class="nh-notification-item <?= $notification->new ? 'nh-new-notification' : '' ?>" data-id="<?= $notification->ID ?>">
                                    <a href="<?= $notification->url ?>">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="nh-notification-image">
                                                    <img src="<?= $notification->thumbnail ?>" alt="<?= __('Notification Thumbnail', 'ninja') ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="nh-notification-content">
                                                    <h6><?= $notification->title ?></h6>
                                                    <p><?= $notification->content ?></p>
                                                    <span><?= $notification->date ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                    <?php
                } else {
                    get_template_part('app/Views/template-parts/notifications/notification', 'empty');
                }
            ?>
        </div>
    </div>
</div>
