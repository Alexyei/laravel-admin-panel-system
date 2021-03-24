@extends('layouts.backend')
@section('title','Категории')
@section('content')
    <div class="page-header">
        <h3 class="page-title">Категории</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Категории</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Список</li>
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
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body overflow-auto">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-light">
                            <tr>
                                <th style="width: 10%">ID</th>
                                <th  style="width: 60%">Название</th>
                                <th style="width: 30%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    {{$category['id']}}
                                </td>
                                <td> {{$category['name']}}</td>
                                <td>
                                    <a class="btn btn-info btn-icon-text" href="{{route('category.edit',$category['id'])}}">
                                        <i class="mdi mdi-file-check btn-icon-append">
                                        </i>
                                        Редактировать
                                    </a>
                                    <form action="{{route("category.destroy", $category['id'])}}" method="POST" style="display: inline-block">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-icon-text">
                                            <i class="mdi mdi-delete btn-icon-prepend"></i>
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-xl-12 col-sm-12 grid-margin stretch-card">
            {{$categories->links()}}
        </div>
    </div>
@endsection
