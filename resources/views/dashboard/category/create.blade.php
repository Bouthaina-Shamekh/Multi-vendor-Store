@extends('layouts.master')

@section('title', 'Category')


@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="#"> Create Category</a></li>

@section('content')

<form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
            <label for="">Category Name</label>
            <input type="text" name="name" class="form-controler" />
      </div>

      <div class="form-group">
            <label for="">Category Parent</label>
            <select name="parent_id" class="form-controler form-select">
                  <option value="">Primary Category</option>
                  @foreach ($parents as $parent )
                  <option value="{{$parent->id}}">{{$parent->name}}</option>
                  @endforeach
            </select>
      </div>

      <div class="form-group">
            <label for="">Desecription</label>
            <textarea type="text" name="desecription" class="form-controler"></textarea>
      </div>

      <div class="form-group">
            <label id="image">Image<label>
                        <input type="file" name="image" class="form-controler" />
      </div>

      <div class="form-group">
            <label for="">Status</label>
            <div>
                  <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"  value="active" checked>
                        <label class="form-check-label" >
                              Active
                        </label>
                  </div>
                  <div class="form-check">
                        <input class="form-check-input" type="radio" name="status"  value="archived">
                        <label class="form-check-label" >
                              Aechived
                        </label>
                  </div>
            </div>
      </div>


      <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
      </div>
</form>

@endsection