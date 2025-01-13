<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\widgets;

use humhub\components\Widget;
use humhub\modules\popovervcard\Module;
use humhub\modules\space\models\Membership;
use humhub\modules\space\models\Space;
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
class VCardSpace extends Widget
{
    /**
     * @var Space
     */
    public $space;

    public function run()
    {
        if ($this->space->visibility === Space::VISIBILITY_NONE && !$this->space->isMember()) {
            return false;
        }
        /** @var Module $module */
        $module = Yii::$app->getModule('popover-vcard');

        $memberCount = Membership::getSpaceMembersQuery($this->space)->count();

        $twig = new Environment(new ArrayLoader());
        $twig->addExtension(new SandboxExtension(new SecurityPolicy(
            ['if', 'for'],
            ['escape', 'e'],
            [],
            [Space::class => ['name', 'description']],
        ), true));

        $templateParams = ['space' => $this->space, 'memberCount' => $memberCount];

        try {
            $description = $twig->createTemplate($module->getConfiguration()->spaceContent)
                ->render($templateParams);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            $description = $e->getMessage();
        }

        return $this->render('vcard-space', [
            'space' => $this->space,
            'description' => $description,
            'memberCount' => $memberCount,
        ]);
    }

}
