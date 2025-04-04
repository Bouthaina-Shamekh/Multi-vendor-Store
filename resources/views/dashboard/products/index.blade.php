@extends('layouts.master')

@section('title')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active"> Product</a></li>

@endsection

@section('content')
<div class="mb-5">
    <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
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
                    <th>Category</th>
                    <th>Store</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                   
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <!-- <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50"></td> -->
                    <td>
    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" height="60">
    @else
        No Image
    @endif
</td>
                    <!-- <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" height="60"> -->
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</a></td>
                    <td>{{ $product->category->name }}</a></td>
                    <td>{{ $product->store->name}}</a></td>
                    <td>{{ $product->parent_id }}</td>
                   
                    <!-- <td>{{ $product->products_number }}</td> -->
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>
                   
                    <td>
                       
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                      
                    </td>
                    <td>
                  
                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                            @csrf
                            <!-- Form Method Spoofing -->
                            
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                       
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">No products defined.</td>
                </tr>
                @endforelse
            </tbody>

           
        </table>

      </div>
      <!-- /.row -->
      {{ $products->withQueryString()->links() }}
      

@endsection