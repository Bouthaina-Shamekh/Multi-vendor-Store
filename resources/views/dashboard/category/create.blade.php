@extends('layouts.master')

@section('title', 'Category')


@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="#"> Create Category</a></li>

@endsection
@section('content')

<form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
      @csrf

      @include('dashboard.category._form')

      
</form>

@endsection