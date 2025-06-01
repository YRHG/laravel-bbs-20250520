@php use Illuminate\Support\Facades\Vite; @endphp
@extends('layouts.app')

@section('title', isset($topic) ? 'トピックを編集' : '新規トピックを作成')

@section('content')

    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        @if ($topic->id)
                            トピックを編集
                        @else
                            新規トピックを作成
                        @endif
                    </h2>

                    <hr>

                    @if ($topic->id)
                        {{-- 编辑模式：更新已有话题 --}}
                        <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                            @method('PUT')
                            @else
                                {{-- 创建模式：创建新话题 --}}
                                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif
                                    @csrf

                                    {{-- 显示验证错误 --}}
                                    @include('shared._error')

                                    {{-- 标题输入 --}}
                                    <div class="mb-3">
                                        <input class="form-control" type="text" name="title"
                                               value="{{ old('title', $topic->title) }}"
                                               placeholder="タイトルを入力してください。" required/>
                                    </div>

                                    {{-- 分类选择 --}}
                                    <div class="mb-3">
                                        <select class="form-control" name="category_id" required>
                                            <option value="" hidden disabled selected>カテゴリーを選択してください。</option>
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- 正文内容 --}}
                                    <div class="mb-3">
                                <textarea name="body" class="form-control" id="editor" rows="6"
                                          placeholder="3文字以上入力してください。" required>{{ old('body', $topic->body) }}</textarea>
                                    </div>

                                    {{-- 提交按钮 --}}
                                    <div class="well well-sm">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="far fa-save mr-2" aria-hidden="true"></i> 保存
                                        </button>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    {{-- Simditor 编辑器的 CSS 文件 --}}
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
