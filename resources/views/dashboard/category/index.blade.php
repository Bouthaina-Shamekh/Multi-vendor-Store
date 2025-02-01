@extends('layouts.master')

@section('title')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active"> Starter</a></li>

@endsection

@section('content')
<div class="mb-5">
    <a href="{{ route('category.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
</div>

<!-- @if (session()->has('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>  
@endif

@if (session()->has('info'))
<div class="alert alert-info">
{{ session('info') }}
</div>  
@endif -->



<x-alert type="success" />
<x-alert type="info" />


<form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
    <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
    <select name="status" class="form-control mx-2">
        <option value="">All</option>
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="archived" @selected(request('status') == 'archived')>Archived</option>
    </select>
    <button class="btn btn-dark mx-2">Filter</button>
</form>


      <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <!-- <th>Products #</th> -->
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                   
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <!-- <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td> -->
                    <td>
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" height="60">
    @else
        No Image
    @endif
</td>
                    <!-- <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" height="60"> -->
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</a></td>
                    <td>{{ $category->parent_id }}</td>
                   
                    <!-- <td>{{ $category->products_number }}</td> -->
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->created_at }}</td>
                   
                    <td>
                       
                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                      
                    </td>
                    <td>
                  
                        <form action="{{ route('category.destroy', $category->id) }}" method="post">
                            @csrf
                            <!-- Form Method Spoofing -->
                            
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                       
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">No categories defined.</td>
                </tr>
                @endforelse
            </tbody>

           
        </table>

      </div>
      <!-- /.row -->
      {{ $categories->withQueryString()->links() }}

@endsection