@extends('layouts.master')

@section('title', 'Category')


@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="#">  Category</a></li>
<li class="breadcrumb-item"><a href="#"> Edit Category</a></li>

@endsection
@section('content')

<form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('put')

      @include('dashboard.category._form', [
             'btn_label' =>'Update'
            ])
     
</form>

@endsection