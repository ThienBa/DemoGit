@extends('layouts.main')

@section('title', 'Bài viết')
@section('content')
    <div id="main-content-wp" class="clearfix blog-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{url('/')}}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Bài viết</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-blog-wp">
                    <div class="section-head clearfix">
                        <h3 class="section-title">Blog</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @foreach ($posts as $post)
                                <li class="clearfix">
                                    <a href="{{url('bai-viet/'.$post->id.'-'.Str::slug($post->title).'.html')}}" title="" class="thumb fl-left">
                                        <img src="{{asset($post->thumbnail)}}" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="{{url('bai-viet/'.$post->id.'-'.Str::slug($post->title).'html')}}" title="" class="title">{{$post->title}}</a>
                                        <span class="create-date">{{$post->created_at}}</span>
                                        <p>{{$post->cat_id==1?"Điện thoại":"Máy tính - Laptop"}}
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="section float-right" id="paging-wp">
                    {{$posts->links()}}
                </div>
            </div>
            <div class="sidebar fl-left">
                @include('inc.product_selling')
                @include('inc.banner')
            </div>
        </div>
    </div>
@endsection
