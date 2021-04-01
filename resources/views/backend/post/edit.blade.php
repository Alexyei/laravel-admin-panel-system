@extends('layouts.backend')
@section('title','Редактировать пост')
@section('styles')
    <link rel="stylesheet" href="{{asset('styles/vendors/tagify/tagify.css')}}" />
    <link rel="stylesheet" href="{{asset('styles/vendors/tagify/tagify.custom.css')}}" />
@endsection
@section('content')
    <div class="page-header">
        <h3 class="page-title">Посты</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Посты</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Редактировать</li>
            </ol>
        </nav>

    </div>
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                    <h4 class="success-title"><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                </div>
            @endif

            @if($errors)
                @foreach($errors->all() as $error)
                    <p class="text-danger">{{$error}}</p>
                @endforeach
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="title">Редактировать пост</h4>
                    <form action="{{route('post.update',$post['id'])}}" method="post" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input required value="{{old('name')??$post['name']}}" type="text" class="form-control" id="name" placeholder="Введите название"
                                   name="name">
                        </div>
                        <div class="form-group">
                            <!-- select -->
                                <label for="category">Выберите категорию</label>
                                <select name="category" class="form-control" id="category" required>
                                    <option slected value="">Не выбрана</option>
                                    @foreach ($categories as $category)
                                        <option {{($post['category']===$category['id'])?'selected':''}} value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="tags">Теги</label>
                            <input value="{{old('tags')}}" class="form-control" id="tags" placeholder="Добавьте теги (не более 5)"
                                   name="tags">
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea required type="text" class="form-control" id="description" placeholder="Краткое описание поста"
                                      name="description">{{old('description')??$post['description']}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="text">Текст</label>
                            <textarea required name="text" id="text" class="form-control tinyMCE-editor">
                                {{old('text')??$post['text']}}

                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="mainImg">Изображение статьи</label>
                            <img src="{{asset('images/post/main/'.$post['mainImg'])}}" alt="" class="img-uploaded" style="display: block; width: 300px">
                            <input type="file" name="mainImg" class="form-control" id="mainImg" accept="image/jpeg,image/png,image/gif, image/webp">
{{--                            <a href="" class="popup_selector" data-inputid="mainImg">Выбрать изображение</a>--}}
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Обновить</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{asset('scripts/backend/previewUploadImg.js')}}"></script>
    <script src="{{asset('scripts/vendors/tagify/tagify.min.js')}}"></script>
    <script>
        let tagify = new Tagify(document.querySelector('input[name=tags]'), {
            delimiters : null,
            templates : {
                tag : function(tagData){
                    try{
                        return `<tag title='${tagData.value}' contenteditable='false' spellcheck="false" class='tagify__tag ${tagData.class ? tagData.class : ""}' ${this.getAttributes(tagData)}>
                        <x title='remove tag' class='tagify__tag__removeBtn'></x>
                        <div>

                            <span class='tagify__tag-text'>${tagData.value}</span>
                        </div>
                    </tag>`
                    }
                    catch(err){}
                },

                dropdownItem : function(tagData){
                    try{
                        return `<div class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}' tagifySuggestionIdx="${tagData.tagifySuggestionIdx}">

                            <span>${tagData.value}</span>
                        </div>`
                    }
                    catch(err){}
                }
            },
            enforceWhitelist : true,
            whitelist : [
                @foreach($tags as $tag)
                { value: '{{$tag['name']}}', code:{{$tag['id']}} },
                    @endforeach
            ],
            dropdown : {
                enabled: 1, // suggest tags after a single character input
                classname : 'extra-properties' // custom class for the suggestions dropdown
            }, // map tags' values to this property name, so this property will be the actual value and not the printed value on the screen
            maxTags: 5
        })

        tagify.on('click', function(e){
            // console.log(e.detail);
        });

        tagify.on('remove', function(e){
            // console.log(e.detail);
        });

        tagify.on('add', function(e){
            // console.log( "original Input:", tagify.DOM.originalInput);
            // console.log( "original Input's value:", tagify.DOM.originalInput.value);
            // console.log( "event detail:", e.detail);
           // onAddTag(e);
        });

        // add tag callback
        // function onAddTag(e){
        //     // limit to "5" tags
        //     console.log(tagify);
        //     if( e.detail.index > 1 )
        //         tagify.removeTag(1);
        // }

        // add the first 2 tags and makes them readonly
        //var tagsToAdd = tagify.settings.whitelist.slice(0, 2)
        //tagify.addTags(tagsToAdd)
        @if(!old('tags'))
        tagify.addTags(
            [
                    @foreach($post->tags()->get() as $tag)
                { value: '{{$tag['name']}}', code:{{$tag['id']}} },
                @endforeach
            ]
        );
        @endif
    </script>
    <script src="{{asset('tinymce/js/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('tinymce/js/tinymce/tinymce_init.js').'?'.rand(10,1000)}}"></script>
@endsection
