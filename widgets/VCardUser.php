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
    public $user;

    public function run()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('popover-vcard');

        $twig = new Environment(new ArrayLoader());
        $twig->addExtension(new SandboxExtension(new SecurityPolicy(['if', 'for'], ['escape', 'e'], [Profile::class => 'about']), true));

        $templateParams = ['user' => $this->user, 'profile' => $this->user->profile];

        try {
            $description = $twig->createTemplate($module->getConfiguration()->userContent)
                ->render($templateParams);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            $description = $e->getMessage();
        }

        return $this->render('vcard-user', [
            'user' => $this->user,
            'description' => $description
        ]);
    }

}