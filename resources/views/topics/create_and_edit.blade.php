@php use Illuminate\Support\Facades\Vite; @endphp
@extends('layouts.app')

@section('title', isset($topic) ? 'トピック編集' : '新しいトピック作成')

@section('content')

    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        @if ($topic->id)
                            {{ __('トピックを編集する') }}
                        @else
                            {{ __('新しいトピックを作成する') }}
                        @endif
                    </h2>

                    <hr>

                    @if ($topic->id)
                        <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                            @method('PUT')
                            @else
                                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif
                                    @csrf

                                    {{-- 显示表单验证错误 --}}
                                    @include('shared._error')

                                    <div class="mb-3">
                                        <input class="form-control" type="text" name="title"
                                               value="{{ old('title', $topic->title) }}"
                                               placeholder="{{ __('タイトルを入力してください。') }}" required/>
                                    </div>

                                    <div class="mb-3">
                                        <select class="form-control" name="category_id" required>
                                            <option value="" hidden disabled
                                                    selected>{{ __('カテゴリーを選択してください。') }}</option>
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <textarea name="body" class="form-control" id="editor" rows="6"
                                                  placeholder="{{ __('3文字以上入力してください。') }}"
                                                  required>{{ old('body', $topic->body) }}</textarea>
                                    </div>

                                    <div class="well well-sm">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="far fa-save mr-2" aria-hidden="true"></i> {{ __('保存する') }}
                                        </button>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    {{-- 引入 Simditor 编辑器的 CSS --}}
    @vite('resources/editor/css/simditor.css')
@endsection

@section('scripts')
    @parent

    {{-- 为 Simditor 的所有 JS 文件添加 defer 属性 --}}
    <script src="{{ Vite::asset('resources/editor/js/module.js') }}" defer></script>
    <script src="{{ Vite::asset('resources/editor/js/hotkeys.js') }}" defer></script>
    <script src="{{ Vite::asset('resources/editor/js/uploader.js') }}" defer></script>
    <script src="{{ Vite::asset('resources/editor/js/simditor.js') }}" defer></script>

    {{-- 初始化 Simditor 编辑器 --}}
    <script type="module">
        if (window.$) {
            window.$(document).ready(function() {
                const editor = new Simditor({
                    textarea: window.$('#editor'),
                });
            });
        }
    </script>
@endsection
