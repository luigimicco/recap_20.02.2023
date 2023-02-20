@extends('layouts/app');

@section('main-content')
    <section class="container">
        <div class="row">

            @if (session('message'))
                <div class="alert {{session('alert-type')}}">
                    {{session('message')}}
                </div>
            @endif
            <div class="col-12 ">

                <div class="card">
                    <div class="card-header">
                        <h2>List books</h2>
                    </div>
                    <div class="card-body">                
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Pages</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Soldout</th>
                                    <th scope="col"><a href="{{ route('books.create') }}" class="btn btn-warning">Create new
                                            book</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <th>{{ $book->ISBN }}</th>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->pages }}</td>
                                        <td>{{ $book->price }}</td>
                                        <td>{{ $book->year }}</td>
                                        <td>{{ $book->soldout }}</td>
                                        <td>
                                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-success">Show</a>
                                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Edit</a>
                                            <form class="d-inline delete" action="{{route('books.destroy', $book->id)}}" method="POST" data-element-name="{{ $book->title }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <h2>
                                        No items
                                    </h2>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    @vite('resources/js/confirmDelete.js')
@endsection