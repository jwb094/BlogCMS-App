@extends('layouts.backend-layout')
@section('title','Comments - Dashboard')
@section('content')
<div class="container-fluid">
    <div class="row">


        <!-- Main content -->
        <div class="col-md-12 ms-sm-auto col-lg-12 px-md-4 my-auto">

            <section class=" my-5 mx-auto">
                <form action={{ route('admin.comments.update',$comment) }} method="POST">
                    @csrf
                    @method('PUT')
                    <h1 class="h3 mb-3 fw-normal text-center">Comment - #{{ $comment->id }}</h1>
                    <div class="form-check mt-3">
                        <x-form.label for="category_name" class="form-label"> Name</x-form.label>
                        <x-form.input type="text" id="category_name" class="form-control" name="name" readonly value="{{ $comment->name }}"></x-form.input>
                    </div>
                    <div class="form-check mt-3">
                        <x-form.label for="description" class="form-label">Email</x-form.label>
                        <x-form.input type="text" id="category_name" class="form-control" name="email" readonly value="{{ $comment->email }}"></x-form.input>

                    </div>
                    <div class="form-check mt-3">
                        <x-form.label for="content" class="form-label">Content</x-form.label>
                        <x-form.textarea type="text" id="content" class="form-control" name="content" readonly rows="3">{{ $comment->content }}</x-form.textarea>
                    </div>

                    <x-form.label for="content" class="form-label">Status</x-form.label>
                    <div class="row | d-flex flex-row">
                        <div class="form-check">
                            <x-form.label class="form-check-label" for="pending">
                                Pending
                            </x-form.label>

                            <x-form.input class="form-check-input" value="pending" type="radio" name="status" id="pending"     :checked="$comment->status === 'pending'"
                                />
                        </div>

                        <div class="form-check">
                            <x-form.label class="form-check-label" for="approved">
                                Approved
                            </x-form.label>

                            <x-form.input class="form-check-input" value="approved" type="radio" name="status" id="approved"     :checked="$comment->status === 'approved'"
                                />
                        </div>

                        <div class="form-check">
                            <x-form.label class="form-check-label" for="rejected">
                                Rejected
                            </x-form.label>

                            <x-form.input class="form-check-input" value="rejected" type="radio" name="status" id="rejected"    :checked="$comment->status === 'rejected'"
                                />
                        </div>



                    </div>
                    <x-form.button class="btn btn-primary w-100 py-2 mt-2" type="submit">Save</x-form.button>
                </form>
            </section>
        </div>

    </div>
</div>
@endsection
