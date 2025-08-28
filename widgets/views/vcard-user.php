<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\helpers\Html;
use humhub\modules\popovervcard\widgets\VCardAddons;
use humhub\modules\user\widgets\Image;
use humhub\widgets\bootstrap\Button;

/* @var $this \humhub\components\View */
/* @var $user \humhub\modules\user\models\User */

?>

<div class="vcardWrapper">
    <div class="vcardContent">
        <div class="vcardHeader"
             style="<?php if ($user->getProfileBannerImage()->hasImage()): ?> background-image: url(<?= $user->getProfileBannerImage()->getUrl(); ?>);<?php endif; ?>">
            <div class="headerContent">
                <div class="imageWrapper float-start"><?= Image::widget(['user' => $user, 'width' => 95]); ?></div>
                <div class="displayName"><?= Html::encode($user->displayName); ?></div>
                <div class="title"><?= Html::encode($user->profile->title); ?></div>
            </div>
        </div>
        <div class="vcardBody">
            <?= $description ?>

            <?= VCardAddons::widget(['container' => $user]); ?>
        </div>
        <div class="vcardFooter">
            <?php if (Yii::$app->hasModule('mail') && !Yii::$app->user->isGuest && Yii::$app->user->id !== $user->id): ?>
                <?= Html::a(Yii::t('PopoverVcardModule.base', 'Send message'), ['/mail/mail/create', 'ajax' => 1, 'userGuid' => $user->guid], ['class' => 'btn btn-primary btn-sm', 'data-bs-target' => '#globalModal']); ?>
            <?php endif; ?>
            <div class="float-end">
                <?= Button::primary(Yii::t('PopoverVcardModule.base', 'Open profile'))
                ->link(['/user/profile', 'container' => $user])
                ->sm() ?>
            </div>
        </div>
    </div>
</div>
