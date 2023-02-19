@extends('layouts/app')

@include('partials.popup')

@section('main-content')
    <section class="container">
        <div class="row">

            <div class="col-12 ">
                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-6">
                                <h2>Recycled bin</h2>
                            </div>
                            <div class="col-6 text-end">
                                @if (count($books))
                                <form class="d-inline delete double-confirm" action="{{route('books.restore-all')}}" method="POST" >
                                    @csrf
                                    <button type="submit" class="btn btn-primary" title="restore all"><i class="fa-solid fa-recycle"></i>&nbsp;Restore all</button>
                                </form>            
                                @endif                   
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Soldout</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $book)
                                    <tr>
                                        <th>{{ $book->ISBN }}</th>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{$book->soldout ? 'soldout': '' }}</td>
                                        <td class="text-end">
                                            <form class="d-inline" action="{{route('books.restore', $book->id)}}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success" title="restore"><i class="fa-solid fa-recycle"></i></button>
                                            </form>                                            
                                            <form class="d-inline delete double-confirm" action="{{route('books.force-delete', $book->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="delete"><i class="fa-solid fa-trash"></i></button>
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
                    <div class="card-footer text-end">
                        <b>{{count($books)}}</b> item/s
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    @vite('resources/js/confirmDelete.js')
@endsection