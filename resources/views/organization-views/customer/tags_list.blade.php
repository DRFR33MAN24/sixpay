@extends('layouts.organization.app')

@section('title', translate('Tag List'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/rating.png')}}" alt="{{ translate('tag') }}">
            <h2 class="page-header-title">{{translate('Tag List')}}</h2>
        </div>

        <div class="card">
            <div class="card-header __wrap-gap-10">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="card-header-title">{{translate('Tag Table')}}</h5>
                    <span class="badge badge-soft-secondary text-dark">{{ $tags->total() }}</span>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <form action="{{url()->current()}}" method="GET">
                        <div class="input-group">
                            <input id="datatableSearch_" type="search" name="search"
                                   class="form-control mn-md-w280"
                                   placeholder="{{translate('Search by Name')}}" aria-label="Search"
                                   value="{{$search}}" required autocomplete="off">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">{{translate('Search')}}</button>
                            </div>
                        </div>
                    </form>
                    <form action="{{route('organization.customer.add-tags')}}" method="POST">
                    @csrf
                        <div class="input-group">
                            <input id="datatableSearch_" type="text" name="name"
                                   class="form-control mn-md-w280"
                                   placeholder="{{translate('Tag Name')}}" aria-label="Add Tag"
                                   >
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">{{translate('Add Tag')}}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="table-responsive datatable-custom">
                <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th>{{translate('SL')}}</th>
                            <th>{{translate('name')}}</th>
  
                            <th class="text-center">{{translate('action')}}</th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($tags as $key=>$tag)
                        <tr>
                            <td>{{$tags->firstitem()+$key}}</td>
                            <td>
                                <a class="media gap-3 align-items-center text-dark" href="#">

                                    <div class="card-body">
                                        {{$tag['name']}}
                                    </div>
                                </a>
                            </td>


                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                <a class="action-btn btn btn-outline-info"
                                    href="{{route('organization.customer.edit-tag',[$tag['id']])}}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a class="action-btn btn btn-outline-danger"
                                    href="{{route('organization.customer.delete-tag',[$tag['id']])}}">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-4 px-3">
                <div class="d-flex justify-content-end">
                    {!! $tags->links() !!}
                    <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                </div>
            </div>
        </div>
    </div>
@endsection

