<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//「PHP/Laravel 14 課題5」よりバリデーションを追記

//「Profile」Modelを使えるようにする記述
use App\Profile;

//「PHP/Laravel 17」課題より追記
use App\ProfileHistory;
use Carbon\Carbon;


class ProfileController extends Controller {
  
  //「PHP/Laravel 08 課題5」より以下にactionを作成
  //「PHP/Laravel 14 課題5」よりバリデーションを追記
  public function add() {
    return view('admin.profile.create');
  }
  
  //「PHP/laravel 14 課題5」より追記
  public function create(Request $request) {
    // Validationをかける(内容はProfileモデルの$rulesに定義)
    $this->validate($request, Profile::$rules);
    
    $profile = new Profile;
    $form = $request->all();
    
    // フォームから送信されてきた「_token」を削除する記述
    unset($form['_token']);
    
    // データベースに保存する記述
    $profile->fill($form);
    $profile->save();
    
    // admin/profile/createにリダイレクトする
    return redirect('admin/profile/create');
  }
  
  //「PHP/Laravel 16」課題1よりeditの内容を追記
  public function edit(Request $request) {
    // Profile Modelからデータを取得する記述(idで抽出)
    $profile = Profile::find($request->id);
    if (empty($profile)) {
      abort(404);
    }
    // admin/profile/editのviewを表示する
    return view('admin.profile.edit', ['profile_form' => $profile]);
  }
  
  //「PHP/Laravel 16」課題3よりupdateアクションを定義
  public function update(Request $request) {
    // Validationをかける
    $this->validate($request, Profile::$rules);
    
    // Profileモデルからidでデータを抽出する
    $profile = Profile::find($request->id);
    
    $profile_form = $request->all();
    
    // 該当するデータを上書きして保存する
    unset($profile_form['_token']);
    $profile->fill($profile_form)->save();
    
    // 「PHP/Laravel 17」課題より編集履歴の記録を追加
    $history = new ProfileHistory;
    $history->profile_id = $profile->id;
    $history->edited_at = Carbon::now();
    $history->save();
    
    // 投稿一覧にリダイレクトするようにした
    return redirect('admin/news');
  }
  
}
