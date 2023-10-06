<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model{
  //配送希望日の選択肢を取得するメソッド
  public static function getDeliveryOptions(){
    //仮の管理者設定を用意
    $config = [
      "min_days_offset" => 1,
      "display_count" => 5,
      "shift_next_day_after_3pm" => true,
      "exclude_weekends" => true,
      "prefecture_delays" => [
        "Hokkaido" => 2,
        "Okinawa" => 3
      ]
    ];

    $options = [];

    //最短配送日の設定
    $minDaysOffset = $config["min_days_offset"];
    //表示する選択肢の数の設定
    $displayCount = $config["display_count"];
    //15時以降の注文の場合の設定
    if($config["shift_next_day_after_3pm"] && now()->hour >= 15){
      //現在時間を取得し、15時以降の注文の場合は最短配送日を1日後にずらす
      $minDaysOffset++;
    }
    //土日の除外設定
    if($config["exclude_weekends"]){
      $excludeDays = [6,7]; //土曜日と日曜日
    } else {
      $excludeDays = [];
    }
    //配送先の都道府県による設定
    $prefecture = "Tokyo";
    //配送先の都道府県による配送日の遅れを設定
    $prefectureDelay = 0;
    if(isset($config["prefecture_delays"][$prefecture])){
      $prefectureDelay = $config["prefecture_delays"][$prefecture];
    }
    for($i = 0; $i < $displayCount; $i++){
      $deliveryDate = now()->addDays($minDaysOffset + $i + $prefectureDelay);
      //除外日のチェック
      if(in_array($deliveryDate->dayOfWeek, $excludeDays)){
        $displayCount++;
        continue;
      }
      $options[] = [
        "date" => $deliveryDate->format("Y-m-d"),
        "formatted_date" => $deliveryDate->format("Y/m/d (D)"),
      ];
    }
    return $options;
  }
}
