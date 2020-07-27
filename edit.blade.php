<!--「PHP/Laravel 12 課題1」よりタイトルだけ作成200714-->
<!--「PHP/Laravel 16 課題3」より内容を作成200726-->
{{--layouts/profile.blade.phpを読み込む--}}
@extends('layouts.profile')

{{--profile.blade.phpの@yield('title')に'プロフィールの編集'を埋め込む--}}
@section('title', 'プロフィールの編集')

{{--admin.blade.phpの@yield('content')に以下のタグを埋め込む--}}
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <h2>プロフィール編集画面</h2>
        
        <form action="{{ action('Admin\ProfileController@update') }}" method="post" enctype="multipart/form-data">
          
          <!-- エラーがあればリストとして表示させる記述 -->
          @if (count($errors) > 0)
            <ul>
              @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          @endif
          
          <div class="form-group row">
            <label class="col-md-2">名前</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="name" value="{{ $profile_form->name }}">
            </div>
          </div>
          
          <div class="form-group row">
            <label class="col-md-2">性別</label>
            <div class="col-md-10">
              <input type="text" class="form-control" name="gender" value="{{ $profile_form->gender }}">
            </div>
          </div>
          
          <div class="form-group row">
            <label class="col-md-2">趣味</label>
            <div class="col-md-10">
              <textarea class="form-control" name="hobby" rows="3">{{ $profile_form->hobby }}</textarea>
            </div>
          </div>
          
          <div class="form-group row">
            <label class="col-md-2">自己紹介欄</label>
            <div class="col-md-10">
              <textarea class="form-control" name="introduction" rows="12">{{ $profile_form->introduction }}</textarea>
            </div>
          </div>
          
          <div class="form-group row">
            <div class="col-md-10">
              <input type="hidden" name="id" value="{{ $profile_form->id }}">
              {{ csrf_field() }}
              <input type="submit" class="btn btn-primary" value="更新">
            </div>
          </div>
          
        </form>
        
        
        <div class="row mt-5">
          <div class="col-md-4 mx-auto">
            <ul class="list-group">
              @if ($profile_form->histories != NULL)
                <h2>編集履歴</h2>
                @foreach ($profile_form->histories as $history)
                  <li class="list-group-item">{{ $history->edited_at }}</li>
                @endforeach
              @endif
            </ul>
          </div>
        </div>
        
      </div>
    </div>
  </div>
@endsection
