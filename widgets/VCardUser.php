<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\widgets;

use humhub\components\Widget;
use humhub\modules\popovervcard\Module;
use humhub\modules\user\models\Profile;
use humhub\modules\user\models\ProfileField;
use humhub\modules\user\models\User;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\SandboxExtension;
use Twig\Loader\ArrayLoader;
use Twig\Sandbox\SecurityPolicy;
use Yii;

/**
 * Class VCardUser
 * @package humhub\modules\popovervcard\widgets
 */
class VCardUser extends Widget
{
    /**
     * @var User
     */
    public $user;

    public function run()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('popover-vcard');

        $allowedProfileProperties = [
            Profile::class => ProfileField::find()->select('internal_name')->column(),
        ];

        $twig = new Environment(new ArrayLoader());
        $twig->addExtension(new SandboxExtension(new SecurityPolicy(
            ['if', 'for'],
            ['escape', 'e'],
            $allowedProfileProperties,
            $allowedProfileProperties + [
                User::class => User::getTableSchema()->getColumnNames(),
            ],
        ), true));

        $templateParams = ['user' => $this->user, 'profile' => $this->user->profile];

        try {
            $description = $twig->createTemplate($module->getConfiguration()->userContent)
                ->render($templateParams);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            $description = $e->getMessage();
        }

        return $this->render('vcard-user', [
            'user' => $this->user,
            'description' => $description,
        ]);
    }

}
