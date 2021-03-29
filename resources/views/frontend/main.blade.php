@extends('layouts.frontend')
@section('title','Главная страница')
@section('content')

    <!------------------------ Site Title ---------------------->
    <section class="site-title parallax">
        <div class="site-background" data-aos="fade-up" data-aos-delay="100">

            <h1>Мой блог</h1>
            <h3>Программирование и не только</h3>
        </div>
    </section>

    <!------------x----------- Site Title ----------x----------->

    <!-- ---------------------- Site Content -------------------------->

    <section class="container">
        <div class="site-content">
            <div class="posts">
                @if(empty($posts))
                <p>Список постов пуст</p>
                    @else
                    @foreach($posts as $post)
                <div class="post-content" data-aos="zoom-in" data-aos-delay="200">
                    <div class="post-image">
                        <div>
                            <img src="{{asset('images/post/main/'.$post['mainImg'])}}" class="img" alt="blog1">
                        </div>
                        <div class="post-info flex-row">
                            <span><i class="fas fa-user text-gray"></i>&nbsp;&nbsp;Admin</span>
                            <span><i class="fas fa-calendar-alt text-gray"></i>&nbsp;&nbsp; {{strftime( "%B %e, %Y", strtotime($post['created_at'])) }}</span>
                            <span><i class="fas fa-comments text-gray"></i>&nbsp;&nbsp; {{100}}</span>
                        </div>
                    </div>
                    <div class="post-title">
                        <a href="{{route('post',[$post['id'], Illuminate\Support\Str::slug($post['name'])])}}">{{$post['name']}}</a>
                        <p>{{$post['description']}}</p>
                        <p>Идентфикатор этого поста {{$post['id']}}</p>
                        <a class="btn post-btn" href="{{route('post',[$post['id'], Illuminate\Support\Str::slug($post['name'])])}}">Читать &nbsp; <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <hr>
                    @endforeach
                        {{$posts->links('pagination.main')}}
                    @endif
            </div>

        </div>

    </section>
    <section>
        <div class="blog">

            <div class="category">
                <h2>Category</h2>
                <ul class="category-list">
                    <li class="list-items" data-aos="fade-left" data-aos-delay="100">
                        <a href="#">Software</a>
                        <span>(05)</span>
                    </li>
                    <li class="list-items" data-aos="fade-left" data-aos-delay="200">
                        <a href="#">Techonlogy</a>
                        <span>(02)</span>
                    </li>
                    <li class="list-items" data-aos="fade-left" data-aos-delay="300">
                        <a href="#">Lifestyle</a>
                        <span>(07)</span>
                    </li>
                    <li class="list-items" data-aos="fade-left" data-aos-delay="400">
                        <a href="#">Shopping</a>
                        <span>(01)</span>
                    </li>
                    <li class="list-items" data-aos="fade-left" data-aos-delay="500">
                        <a href="#">Food</a>
                        <span>(08)</span>
                    </li>
                </ul>
            </div>
            <div class="popular-tags">
                <h2>Popular Tags</h2>
                <div class="tags flex-row">
                    <span class="tag" data-aos="flip-up" data-aos-delay="100">Software</span>
                    <span class="tag" data-aos="flip-up" data-aos-delay="200">technology</span>
                    <span class="tag" data-aos="flip-up" data-aos-delay="300">travel</span>
                    <span class="tag" data-aos="flip-up" data-aos-delay="400">illustration</span>
                    <span class="tag" data-aos="flip-up" data-aos-delay="500">design</span>
                    <span class="tag" data-aos="flip-up" data-aos-delay="600">lifestyle</span>
                    <span class="tag" data-aos="flip-up" data-aos-delay="700">love</span>
                    <span class="tag" data-aos="flip-up" data-aos-delay="800">project</span>
                </div>
            </div>

        </div>
    </section>
    <!-- -----------x---------- Site Content -------------x------------>
@endsection

