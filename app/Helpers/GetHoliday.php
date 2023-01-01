<?php

namespace App\Helpers;

/**
 * Get Holiday
 */

class GetHoliday {
  public static function getHoliday($date) {
    $url = 'https://kalenderindonesia.com/api/YZ35u6a7sFWN/libur/masehi/'.$date;
    $kalender = file_get_contents($url);
    $kalender = json_decode($kalender, true);
    $libur = false;
    $holiday = null;
    if ($kalender['data'] != false) {
        if ($kalender['data']['holiday']['data']) {
            foreach ($kalender['data']['holiday']['data'] as $key => $value) {
                if ($value['date'] == date('Y-m-d')) {
                    $holiday = $value['name'];
                    $libur = true;
                    break;
                }
            }
        }
    }
    $data = [
      'libur' => $libur,
      'holiday' => $holiday
    ];
    return $data;
  }
}