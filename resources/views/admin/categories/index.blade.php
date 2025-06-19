{{-- ファイルパス: resources/views/admin/categories/index.blade.php --}}
{{-- File Path: resources/views/admin/categories/index.blade.php --}}

@extends('admin.layouts.app') {{-- 管理画面の共通レイアウトファイルを継承することを想定 --}}

@section('title', 'カテゴリ管理')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>カテゴリ一覧</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">カテゴリ名</th>
                        <th scope="col">作成日時</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{-- @forelse ループでデータを表示し、データがない場合はメッセージを表示 --}}
                    @forelse ($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">データがありません。</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
