<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\modules\popovervcard\widgets\VCardAddons;
use humhub\modules\user\widgets\Image;

/* @var $this \humhub\components\View */
/* @var $user \humhub\modules\user\models\User */

?>

<div class="vcardWrapper">
    <div class="vcardContent">
        <div class="vcardHeader"
             style="<?php if ($user->getProfileBannerImage()->hasImage()): ?> background-image: url(<?= $user->getProfileBannerImage()->getUrl(); ?>);<?php endif; ?>">
            <div class="headerContent">
                <div class="imageWrapper pull-left"><?= Image::widget(['user' => $user, 'width' => 60]); ?></div>
                <div class="displayName"><?= $user->displayName; ?></div>
                <div class="title">System Administration</div>
            </div>
        </div>
        <div class="vcardBody">
            <?= $description ?>

            <?= VCardAddons::widget(['container' => $user]); ?>
        </div>
        <div class="vcardFooter">
            <a href="" class="btn btn-primary btn-sm">Send message</a>
            <div class="pull-right"></div>
        </div>
    </div>
</div>