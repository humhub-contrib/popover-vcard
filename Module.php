<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard;

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
        return Yii::t('PopovervcardModule.base', 'Popover Vcard');
    }

    public function getDescription()
    {
        return Yii::t('PopovervcardModule.base', 'Xyz');
    }

}
