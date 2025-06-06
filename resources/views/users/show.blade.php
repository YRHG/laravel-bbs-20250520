@extends('layouts.app')

@section('title', $user->name . ' のプロフィール')

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="card ">
                <img class="card-img-top"
                     src="{{ $user->avatar }}"
                     alt="{{ $user->name }}">
                <div class="card-body">
                    <h5><strong>{{ __('プロフィール') }}</strong></h5>
                    <p>{{ $user->introduction }}</p>
                    <hr>
                    <h5><strong>{{ __('登録日') }}</strong></h5>
                    <p>January 01 1901</p>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="card ">
                <div>
                    <h1 class="mb-0" style="font-size:22px;">{{ $user->name }}</h1>
                    <p style="font-size: 0.8em; color: #6c757d; margin-top: 0;">
                        {{ $user->email }}
                    </p>
                </div>
            </div>
            <hr>

            {{-- 用户发布的内容 --}}
            <div class="card ">
                <div class="card-body">
                    {{ __('利用可能なデータはありません。 📭') }}
                </div>
            </div>

        </div>
    </div>
@stop
