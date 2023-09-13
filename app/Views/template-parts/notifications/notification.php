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

<div class="ninjanotifications">
    <div class="bell">
        <button class="btn ninjanotification-bell" data-count="<?= $count ?>">
            <span class="ninjanotification-count"><?= $count ?></span>
            <i class="fa-regular fa-bell"></i>
        </button>
    </div>
    <div class="ninjanotification-list container" data-page="2" data-last="<?= $found_posts > 10 ? 0 : 1 ?>">
        <div class="ninjanotification-group-container">
            <?php
                if (!empty($notifications['notifications'])) {
                    ?>
                    <div class="ninjanotification-clear-parent">
                        <button class="btn ninjanotification-clear">
                            <?= __('clear all') ?>
                        </button>
                    </div>
                    <div class="ninjanotifications-group">
                        <?php
                            foreach ($notifications['notifications'] as $notification) {
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
