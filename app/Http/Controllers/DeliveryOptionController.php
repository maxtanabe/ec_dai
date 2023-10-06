<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryOption;

class DeliveryOptionController extends Controller{
  public function index(){
    //配送希望日の選択肢を取得
    $options = DeliveryOption::getDeliveryOptions();
    //変数（取得した選択肢）をビューに渡す
    return view("delivery_options.index",["options" => $options]);
  }
}