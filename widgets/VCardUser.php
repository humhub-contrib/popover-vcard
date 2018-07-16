<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\widgets;

use humhub\components\Widget;


/**
 * Class VCardUser
 * @package humhub\modules\popovervcard\widgets
 */
class VCardUser extends Widget
{
    public $user;

    public function run()
    {
        return $this->render('vcard-user', [
            'user' => $this->user,
        ]);
    }

}