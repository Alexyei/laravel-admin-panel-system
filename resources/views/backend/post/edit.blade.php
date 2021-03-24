@extends('layouts.backend')
@section('title','Редактировать категорию')
@section('content')
    <div class="page-header">
        <h3 class="page-title">Категории</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Категории</a></li>
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
                    <h4 class="title">Редактировать категорию</h4>
                    <form action="{{route('category.update',$category['id'])}}" method="post" class="forms-sample">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Название</label>
                            <input required value="{{old('name')??$category['name']}}" type="text" class="form-control" id="name" placeholder="Введите название" name="name">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Обновить</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
