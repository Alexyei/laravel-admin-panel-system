@extends('layouts.frontend')
@section('title')
{{$post['name']}}
@endsection
@section('content')
    <!------------------------ Site Title ---------------------->
    <section class="site-title parallax"
             style="background-image: url({{asset('images/post/main/'.$post['mainImg'])}})">
        <!--             data-aos="fade-up" data-aos-delay="100"-->
        <div class="site-background" data-aos="fade-up" data-aos-delay="100">
            <h1>{{$post['name']}}</h1>
            <div class="post-info flex-row">
                <span><i class="fas fa-user text-gray"></i>&nbsp;&nbsp;Admin</span>
                <span><i class="fas fa-calendar-alt text-gray"></i> {{strftime( "%B %e, %Y", strtotime($post['created_at'])) }}</span>
                <span><i class="fas fa-comments text-gray"></i><span
                        class="comment-count">100</span></span>
            </div>
        </div>
    </section>

    <!------------x----------- Site Title ----------x----------->


    <!-- ---------------------- Site Content -------------------------->


    <!-- --------------------- Post Content ----------------- -->
    <section class="container">
        <div class="site-content">
            <div class="post">
                <div class="post-data">
                    {!!$post['text']!!}
                </div>
            </div>
        </div>
    </section>
    <!-- ----------x---------- Post Content --------x-------- -->


    <!-- --------------------- Blog Carousel ----------------- -->
{{--    <?php if (count($randomPosts) > 2): ?>--}}
{{--    <section>--}}
{{--        <div class="carousel">--}}
{{--            <div class="container">--}}
{{--                <div class="owl-carousel owl-theme blog-post">--}}
{{--                    <?php foreach ($randomPosts as $val): ?>--}}
{{--                    <div class="blog-content" data-aos="fade-right" data-aos-delay="200">--}}
{{--                        <!--                    <img src="/public/images/main/Blog-post/post-01.jpg">-->--}}
{{--                        <div class="img"--}}
{{--                             style="background-image: url('/public/upload/images/news/main/<?= $val['id'] ?>.jpg')">--}}

{{--                        </div>--}}
{{--                        <div class="blog-title">--}}
{{--                            <h3><?= htmlspecialchars($val['name'], ENT_QUOTES) ?></h3>--}}
{{--                            <a href="/post/<?= $val['id'] . '/' . $val['alias'] ?>" class="btn btn-blog">Читать</a>--}}
{{--                            <span>Admin</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <?php endforeach; ?>--}}
{{--                </div>--}}
{{--                <div class="owl-navigation">--}}
{{--                    <span class="owl-nav-prev"><i class="fas fa-long-arrow-alt-left"></i></span>--}}
{{--                    <span class="owl-nav-next"><i class="fas fa-long-arrow-alt-right"></i></span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <?php endif; ?>--}}
    <!-- ----------x---------- Blog Carousel --------x-------- -->


    <!-- --------------------- Comments ----------------- -->
    <section class="container">
        <div class="site-content">
            <div class="post">
                <div class="comment-data">

                    @auth
                    <h1 class="title">Написать комментарий</h1>
                    <form autocomplete="off" action="#" method="post">
                        @csrf
                        <!--                    <h2 class="title">Изменить данные</h2>-->
                        <div class="input-field">
                            <!--                        <i class="fas fa-user"></i>-->
                            <textarea id="mainComment" rows="5" class="form-control" name="text"
                                      placeholder="Ваш комментарий..."></textarea>
                        </div>
                        <button data-parent-id=0  data-post-id='{{$post['id']}}' id="addComment" type="submit" class="btn solid">
                            <i class="fas fa-spinner fa-spin del"></i><span class="text">Отправить</span>
                        </button>
                    </form>
                    @endauth
                    @guest

                    <h2><a class="login-link" href="{{route('enter')}}">Войдите</a> чтобы оставить комментарий</h2>

                        @endguest
                    <hr>
                    <h1 class="title">Комментарии <span class="comment-count">100</span></h1>

                    <div class="userComments">
                        @include('partials.replies', ['comments' => $post->comments, 'post_id' => $post->id, 'level' => 0])
{{--                        <?php foreach ($comments as $val): ?>--}}
{{--                        <?= $val ?>--}}
{{--                    <?php endforeach; ?>--}}
                    </div>
                </div>

            </div>
        </div>


        <form class="replyRow" style="display:none" autocomplete="off" action="#"
              method="post">
            <!--                    <h2 class="title">Изменить данные</h2>-->
            <div class="input-field">
                <!--                        <i class="fas fa-user"></i>-->
                <textarea id="replyComment" rows="5" class="form-control" name="text"
                          placeholder="Ваш комментарий..."></textarea>
            </div>
            <button id="addReply" data-post-id='{{$post['id']}}' type="submit" class="btn solid">
                <i class="fas fa-spinner fa-spin del"></i><span class="text">Отправить</span>
            </button>
        </form>

    </section>

   @auth
    <div class="bg-modal-comments">
        <!--    <div class="modal-contents-comments">-->


        <form class="modal-contents-comments" autocomplete="off" action="/comment/complain" method="post">
            <h1 class="title">Что-то не так с комментарием</h1>
            <a class="modal-close-comments"><i class="fas fa-times"></i></a>

            <div class="complain-row">
                <input type="radio" id="cause_1" name="cause" value="abuse"/>
                <div class="labels">
                    <label class="main-label" for="cause_1">Он выражает нетерпимость, связан с травлей или оскорбителен</label>
                    <label class="more-label" for="cause_1">Этот комментарий содержит нападки на человека или группу людей</label>
                </div>
            </div>

            <div class="complain-row">
                <input type="radio" id="cause_2" name="cause" value="unfriendly"/>
                <div class="labels">
                    <label class="main-label" for="cause_2">Он недружелюбен или враждебен</label>
                    <label class="more-label" for="cause_2">Этот комментарий груб или унизителен</label>
                </div>
            </div>
            <div class="complain-row">
                <input type="radio" id="cause_3" name="cause" value="spam"/>
                <div class="labels">
                    <label class="main-label" for="cause_3">Он больше не нужен или это спам</label>
                    <label class="more-label" for="cause_3">Этот комментарий устарел, порождает бесконечные дискуссии или не относится к
                        данному сообщению.</label>
                </div>
            </div>

            <div class="complain-row">
                <input type="radio" id="cause_4" name="cause" value="other"/>
                <div class="labels">
                    <label class="main-label" for="cause_4">Что-то ещё</label>
                    <label class="more-label" for="cause_4">Проблема не обозначена выше</label>
                </div>
            </div>

            <div class="complain-action">
                <button id="addComplain" type="submit" class="btn solid">
                    <i class="fas fa-spinner fa-spin del"></i><span class="text">Отправить</span>
                </button>
{{--<?=$_SESSION['account']['comp_count']?>--}}
                <p>У вас осталось <span class="complain-user-daily">5</span> предупреждений на сегодня</p>
            </div>
        </form>
        <!---->
        <!--    </div>-->
    </div>

    @endauth
    <!-- ----------x---------- Comments --------x-------- -->


    <!-- --------------------- Category and Popular Tags ----------------- -->
    <section>
        <div class="blog">
            <!--            <div class="container">-->
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
            <!--            </div>-->
        </div>
    </section>
    <!-- ----------x---------- Category and Popular Tags --------x-------- -->


    <!-- -----------x---------- Site Content -------------x------------>
@endsection
@section('scripts')
    <script src="{{asset('scripts/frontend/comments.js')}}"></script>
@endsection
