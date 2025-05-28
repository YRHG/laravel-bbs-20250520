@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-pen"></i> {{ isset($topic) ? __('編集投稿') : __('新規投稿') }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($topic) ? route('topics.update', $topic) : route('topics.store') }}">
                    @csrf
                    @if(isset($topic))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label">{{ __('タイトル') }}</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title', $topic->title ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">{{ __('カテゴリ') }}</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">{{ __('選択してください') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $topic->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="body" class="form-label">{{ __('内容') }}</label>
                        <textarea name="body" id="body" rows="8" class="form-control"
                                  required>{{ old('body', $topic->body ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($topic) ? __('更新') : __('投稿') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
