<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */


use humhub\helpers\Html;
use humhub\modules\popovervcard\widgets\VCardAddons;
use humhub\modules\space\widgets\Image;
use humhub\widgets\bootstrap\Button;

/* @var $this \humhub\components\View */
/* @var $space \humhub\modules\space\models\Space */
/* @var $memberCount integer */

?>

<div class="vcardWrapper">
    <div class="vcardContent">
        <div class="vcardHeader"
             style="<?php if ($space->getProfileBannerImage()->hasImage()): ?> background-image: url(<?= $space->getProfileBannerImage()->getUrl(); ?>);<?php endif; ?>">
            <div class="headerContent">
                <div class="imageWrapper float-start"><?= Image::widget(['space' => $space, 'width' => 95]); ?></div>
                <div class="displayName"><?= Html::encode($space->name); ?></div>
                <div class="title"><i
                            class="fa fa-users"></i> <?= Yii::t('PopoverVcardModule.base', '{count} members', ['count' => $memberCount]); ?>
                </div>
            </div>
        </div>
        <div class="vcardBody">
            <?= $description ?>

            <?= VCardAddons::widget(['container' => $space]); ?>
        </div>
        <div class="vcardFooter">
            <div class="float-end">
                <?= Button::primary(Yii::t('PopoverVcardModule.base', 'Open space'))
                    ->link(['/space/space', 'container' => $space])
                    ->sm() ?>
            </div>
        </div>
    </div>
</div>
