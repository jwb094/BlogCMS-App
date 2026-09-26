
@extends('layouts.backend-layout')
@section('title','Category - Index')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="my-4">
            <a class="col-sm-2 btn btn-primary" href="{{ route('admin.tags.create') }}">New Category</a>
        </div>
        <form action={{ route('admin.category.index') }} method="GET">

            <div class="row">
                <div class="col-xs-12 col-md-2 mb-3">
                    <x-form.input type="text" id="tagname" class="form-control" name="name" placeholder="Friends"></x-form.input>
                </div>
                <div class="col-12 col-md-3 mb-3 | form-check">
                    <button type="submit" class="btn btn-primary mt-6 | text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Search
                    </button>

                </div>
                <div class="col-12 col-md-3 mb-3 | form-check">
                    <a class="btn btn-secondary" href={{ route('admin.category.index') }}> Reset</a>
                </div>
            </div>

        </form>
        <div class="row">
            <table class="table">
                <thead>
                    <tr class="table-dark">
                        <th scope="col">Name</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['category'] as $key => $value)
                    <tr>
                        <td>{{ $value->name }}</td>
                        <td>
                            <a href={{ route('admin.category.edit',$value) }} class="btn btn-primary">Update</a>
                            <form action="{{ route('admin.category.destroy',$value) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Category?')">Delete</button>
                            </form>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $data['category']->links() }}
        </div>
    </div>
</div>
@endsection