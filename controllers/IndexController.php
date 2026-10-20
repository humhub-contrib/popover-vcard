<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\controllers;

use humhub\components\Controller;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\popovervcard\Module;
use humhub\modules\popovervcard\widgets\VCardSpace;
use humhub\modules\popovervcard\widgets\VCardUser;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;
use yii\web\HttpException;

/**
 * Class IndexController
 * @package humhub\modules\popovervcard\controllers
 */
class IndexController extends Controller
{
    /**
     * @return string
     * @throws HttpException
     * @throws \yii\db\IntegrityException
     */
    public function actionLoad()
    {
        $contentContainerId = Yii::$app->request->post('id');
        $contentContainerGuid = Yii::$app->request->post('guid');

        if ($contentContainerId !== null) {
            if (!is_scalar($contentContainerId) || !ctype_digit((string)$contentContainerId)) {
                throw new HttpException(400, 'Invalid container id');
            }
            $contentContainer = ContentContainer::findOne(['id' => (int)$contentContainerId]);
        } elseif ($contentContainerGuid !== null) {
            if (!is_string($contentContainerGuid)) {
                throw new HttpException(400, 'Invalid container guid');
            }
            $contentContainer = ContentContainer::findOne(['guid' => $contentContainerGuid]);
        } else {
            throw new HttpException(400, 'No container provided');
        }

        if ($contentContainer === null) {
            throw new HttpException(404, 'Could not find container!');
        }

        $instance = $contentContainer->getPolymorphicRelation();

        /** @var Module $module */
        $module = Yii::$app->getModule('popover-vcard');

        if ($instance instanceof User) {
            if (empty($module->getConfiguration()->userEnabled)) {
                return '';
            }

            if (!$this->canViewUser($instance)) {
                return '';
            }

            return $this->renderAjaxContent(VCardUser::widget(['user' => $instance]));
        } elseif ($instance instanceof Space) {
            if (empty($module->getConfiguration()->spaceEnabled)) {
                return '';
            }

            if (!$this->canViewSpace($instance)) {
                return '';
            }

            return $this->renderAjaxContent(VCardSpace::widget(['space' => $instance]));
        }

        return '';
    }

    private function canViewUser(User $user): bool
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->id == $user->id) {
            return true;
        }

        if (!$user->isVisible()) {
            return false;
        }

        return !Yii::$app->user->isGuest || $user->visibility === User::VISIBILITY_ALL;
    }

    private function canViewSpace(Space $space): bool
    {
        if (Yii::$app->user->isGuest) {
            return $space->visibility === Space::VISIBILITY_ALL;
        }

        return $space->visibility !== Space::VISIBILITY_NONE || $space->isMember();
    }

}
