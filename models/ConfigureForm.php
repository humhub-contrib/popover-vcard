<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\models;

use Yii;

class ConfigureForm extends \yii\base\Model
{

    public $userContent;
    public $spaceContent;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userContent', 'spaceContent'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
        ];
    }

    public function loadSettings()
    {
        $settings = Yii::$app->getModule('popover-vcard')->settings;


        return true;
    }

    public function saveSettings()
    {
        $settings = Yii::$app->getModule('popover-vcard')->settings;
        return true;
    }

}
