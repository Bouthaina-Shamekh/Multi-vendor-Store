@extends('layouts.master')



@section('breadcrumb')
@parent
      <li class="breadcrumb-item"><a href="#">Category</a></li>

@section('content')

<div class="mb-5">
  
    <a href="{{ route('category.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
   
</div>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Products #</th>
            <th>Status</th>
            <th>Created At</th>
            <!-- <th colspan="2"></th> -->
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
        <tr>
            <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50"></td>
            <td>{{ $category->id }}</td>
            <td><a href="{{ route('dashboard.categories.show', $category->id) }}">{{ $category->name }}</a></td>
            <td>{{ $category->parent->name }}</td>
            <td>{{ $category->products_number }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->created_at }}</td>
            <td>
                <!-- @can('categories.update') -->
                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                <!-- @endcan -->
            </td>
            <td>
                <!-- @can('categories.delete') -->
                <form action="{{ route('category.destroy', $category->id) }}" method="post">
                    @csrf
                    <!-- Form Method Spoofing -->
                    
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
                <!-- @endcan -->
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9">No categories defined.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
            