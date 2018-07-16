<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard;

use humhub\modules\popovervcard\models\Configuration;
use Yii;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{


    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to([
            '/popover-vcard/admin'
        ]);
    }

    public function getName()
    {
        return Yii::t('PopoverVcardModule.base', 'Popover Vcard');
    }

    public function getDescription()
    {
        return Yii::t('PopoverVcardModule.base', 'Xyz');
    }


    /**
     * Returns the module configuration model
     *
     * @return Configuration
     */
    public function getConfiguration()
    {
        $model = new Configuration();
        $model->loadSettings();
        return $model;
    }

}
