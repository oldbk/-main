<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 04.01.2016
 */

require_once __DIR__ . '/init.php';

if( !lockCreate("cron_rating_bweek") ) {
    exit("Script already running.");
}

use \components\models\UserEventRating;
use \components\models\EventRating;

echo sprintf('Start Rating BWEEK Finish cron [%s]', date('d.m.Y H:i:s')).PHP_EOL;
$db = \components\Component\Db\CapitalDb::connection();
$db->beginTransaction();
try {
	/** @var EventRating[] $Ratings */
	$Ratings = EventRating::whereRaw('enable_type = "week" and is_enabled = 1')
		->get();
	foreach ($Ratings as $Rating) {
		$reward_till = (new \DateTime())->modify('+'.$Rating->reward_till_days.' days')->setTime(0, 0);

		UserEventRating::where('iteration_num', '=', $Rating->iteration_num)
			->where('is_end', '=', 0)
			->where('rating_id', '=', $Rating->id)
			->update(['is_end' => 1, 'reward_till' => $reward_till]);

		$Rating->iteration_num += 1;
		$Rating->save();
	}

    $db->commit();
    echo 'Finish'.PHP_EOL;
} catch (\Exception $ex) {
    $db->rollBack();
    if($ex->getMessage() != '') {
        echo 'Error. See log file cron_rating_bweek.txt'.PHP_EOL;
        $app->logger->crit($ex);
    }
}

lockDestroy('cron_rating_bweek');