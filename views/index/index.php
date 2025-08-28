<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\helpers\Html;
use humhub\modules\popovervcard\widgets\VCardSpace;
use humhub\modules\popovervcard\widgets\VCardUser;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;


/* @var $this \humhub\components\View */

$user = User::findOne(['id' => 1]);
$space = Space::findOne(['id' => 1]);
?>


<div class="container">
    <div class="row">
        <div class="col-lg-12">

            <?= Html::containerLink($user) ?>&nsbp;
            <?= Html::containerLink($space) ?><br />

            <br/><br/><br/><br/><br/>

            <hr />

            <?= VCardUser::widget(['user' => $user]) ?>
            <?= VCardSpace::widget(['space' => $space]) ?>

        </div>
    </div>
</div>
