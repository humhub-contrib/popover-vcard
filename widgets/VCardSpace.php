<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\popovervcard\widgets;

use humhub\components\Widget;
use humhub\modules\space\models\Membership;


/**
 * Class VCardUser
 * @package humhub\modules\popovervcard\widgets
 */
class VCardSpace extends Widget
{
    public $space;

    public function run()
    {
        $memberCount = Membership::getSpaceMembersQuery($this->space)->count();

        return $this->render('vcard-space', [
            'space' => $this->space,
            'memberCount' => $memberCount
        ]);
    }

}