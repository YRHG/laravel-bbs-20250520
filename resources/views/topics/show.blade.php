@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->excerpt)

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
            <div class="card ">
                <div class="card-body">
                    <div class="text-center">
                        {{ __('Author') }}：{{ $topic->user->name }}
                    </div>
                    <hr>
                    <div class="media">
                        <div align="center">
                            <a href="{{ route('users.show', $topic->user->id) }}">
                                <img class="thumbnail img-fluid" src="{{ $topic->user->avatar }}" width="300px"
                                     height="300px" alt="{{ $topic->user->name }}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
            <div class="card ">
                <div class="card-body">
                    <h1 class="text-center mt-3 mb-3">
                        {{ $topic->title }}
                    </h1>

                    <div class="article-meta text-center text-secondary">
                        {{ $topic->created_at->diffForHumans() }}
                        ⋅
                        <i class="far fa-comment"></i>
                        {{ $topic->reply_count }}
                    </div>

                    <div class="topic-body mt-4 mb-4">
                        {!! $topic->body !!}
                    </div>

                    @can('update', $topic)
                        <div class="operate">
                            <hr>
                            <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm"
                               role="button">
                                <i class="far fa-edit"></i> {{ __('Edit') }}
                            </a>
                            <a href="#" class="btn btn-outline-secondary btn-sm" role="button">
                                <i class="far fa-trash-alt"></i> {{ __('Delete') }}
                            </a>
                        </div>
                    @endcan

                </div>
            </div>
            {{-- 用户回复列表 --}}
            <div class="card topic-reply mt-4">
                <div class="card-body">
                    @include('topics._reply_box', ['topic' => $topic])
                    @include('topics._reply_list', ['replies' => $topic->replies()->with('user')->get()])
                </div>
            </div>
        </div>
    </div>
@stop
