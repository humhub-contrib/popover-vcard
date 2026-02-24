<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\assets;

use humhub\components\assets\AssetBundle;
use yii\helpers\Url;

class Assets extends AssetBundle
{
    public $forceCopy = false;
    public $sourcePath = '@popover-vcard/resources';
    public $css = [
        'humhub.vcard.popover.css',
    ];
    public $js = [
        'humhub.vcard.popover.js',
    ];

    /**
     * @inheritdoc
     */
    public static function register($view)
    {
        parent::register($view);

        $view->registerJsConfig('vcard.popover', [
            'delay' => 500,
            'loadUrl' =>  Url::to(['/popover-vcard/index/load']),
        ]);
    }

}
