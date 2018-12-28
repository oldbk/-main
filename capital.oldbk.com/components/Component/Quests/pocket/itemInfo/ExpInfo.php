<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 24.03.2016
 */

namespace components\Component\Quests\pocket\itemInfo;

use components\Component\Quests\object\Part;
use components\Component\Quests\object\Reward;
use components\Helper\FileHelper;
use components\Helper\item\ItemExp;
use components\models\NewDelo;
use components\models\User;

class ExpInfo extends BaseInfo
{
    public function getItemType()
    {
        return self::ITEM_TYPE_EXP;
    }

    /**
     * @param User $owner
     * @param Part $Part
     * @param Reward $Reward
     * @return bool
     */
    public function give($owner, Part $Part, Reward $Reward)
    {
        try {
            $GiveExp = new ItemExp($owner, $Reward->count);
            if(!$GiveExp->give()) {
                throw new \Exception;
            }

            $_data = array(
                'target_login'          => '�����',
                'type'                  => NewDelo::TYPE_QUEST_REWARD_EXP,
                'add_info'              => $Part->name,
            );

            if(!$GiveExp->newDeloGive($_data)) {
                throw new \Exception;
            }
        } catch (\Exception $ex) {
            FileHelper::writeException($ex, 'quest_reward_exp');
            return false;
        }
        
        return true;
    }
}