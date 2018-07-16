<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('PopoverVcardModule.base', '<strong>VCard</strong> Configuration'); ?></div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['id' => 'configure-form', 'enableClientValidation' => false, 'enableClientScript' => false]); ?>

        <div class="row">
            <div class="col-md-6">
                <h4><?= Yii::t('PopoverVcardModule.base', 'User VCard'); ?></h4>
                <br/>
                <?= $form->field($model, 'userEnabled')->checkbox(); ?>
                <?= $form->field($model, 'userContent')->textarea(['rows' => 15]); ?>
            </div>
            <div class="col-md-6">
                <h4><?= Yii::t('PopoverVcardModule.base', 'Space VCard'); ?></h4>
                <br/>
                <?= $form->field($model, 'spaceEnabled')->checkbox(); ?>
                <?= $form->field($model, 'spaceContent')->textarea(['rows' => 15]); ?>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton(Yii::t('base', 'Save'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>