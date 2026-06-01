@extends('admin.layouts.master')
@section('title', __('translate.Destination Details'))

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> {{ __('translate.Destination Details') }} </h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <a href="{{ dashboard_route('admin.tourbooking.destinations.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> {{ __('translate.Back to List') }} </a>
                        <a href="{{ dashboard_route('admin.tourbooking.destinations.edit', [$destination]) }}" class="btn btn-success">
                            <i class="fas fa-edit"></i> {{ __('translate.Edit') }} </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> {{ __('translate.Basic Information') }} </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px;"> {{ __('translate.ID') }} </th>
                                            <td>{{ $destination->id }}</td>
                                        </tr>
                                        <tr>
                                            <th> {{ __('translate.Name') }} </th>
                                            <td>{{ $destination->name }}</td>
                                        </tr>
                                        <tr>
                                            <th> {{ __('translate.Country') }} </th>
                                            <td>{{ $destination->country }}</td>
                                        </tr>
                                        <tr>
                                            <th> {{ __('translate.Status') }} </th>
                                            <td>
                                                @if($destination->status)
                                                    <span class="badge badge-success"> {{ __('translate.Active') }} </span>
                                                @else
                                                    <span class="badge badge-danger"> {{ __('translate.Inactive') }} </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('translate.Featured') }}</th>
                                            <td>
                                                @if($destination->is_featured)
                                                    <span class="badge badge-info"> {{ __('translate.Yes') }} </span>
                                                @else
                                                    <span class="badge badge-secondary"> {{ __('translate.No') }} </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> {{ __('translate.Created At') }} </th>
                                            <td>{{ $destination->created_at->format('F d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th> {{ __('translate.Updated At') }} </th>
                                            <td>{{ $destination->updated_at->format('F d, Y h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    @if($destination->image)
                                        <div class="text-center">
                                            <h5 class="mb-3">{{ __('translate.Featured') }} Image</h5>
                                            <img src="{{ asset($destination->image) }}"
                                                alt="{{ $destination->name }}"
                                                class="img-fluid rounded" 
                                                style="max-height: 300px;">
                                        </div>
                                    @else
                                        <div class="text-center p-5 bg-light rounded">
                                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                                            <p class="mb-0"> {{ __('translate.No image available') }} </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title"> {{ __('translate.Description') }} </h3>
                        </div>
                        <div class="card-body">
                            @if($destination->description)
                                <div class="description-content">
                                    {!! $destination->description !!}
                                </div>
                            @else
                                <p class="text-muted"> {{ __('translate.No description available') }} </p>
                            @endif
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title"> {{ __('translate.SEO Information') }} </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;"> {{ __('translate.Meta Title') }} </th>
                                    <td>{{ $destination->meta_title ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <th> {{ __('translate.Meta Keywords') }} </th>
                                    <td>{{ $destination->meta_keywords ?? 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <th> {{ __('translate.Meta Description') }} </th>
                                    <td>{{ $destination->meta_description ?? 'Not set' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="card-title"> {{ __('translate.Related Tours') }} </h3>
                        </div>
                        <div class="card-body">
                            @if($destination->tours && $destination->tours->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th> {{ __('translate.ID') }} </th>
                                                <th> {{ __('translate.Name') }} </th>
                                                <th> {{ __('translate.Price') }} </th>
                                                <th> {{ __('translate.Status') }} </th>
                                                <th> {{ __('translate.Actions') }} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($destination->tours as $tour)
                                                <tr>
                                                    <td>{{ $tour->id }}</td>
                                                    <td>{{ $tour->title }}</td>
                                                    <td>{{ number_format($tour->price, 2) }}</td>
                                                    <td>
                                                        @if($tour->status)
                                                            <span class="badge badge-success"> {{ __('translate.Active') }} </span>
                                                        @else
                                                            <span class="badge badge-danger"> {{ __('translate.Inactive') }} </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ dashboard_route('admin.tourbooking.tours.show', [$tour]) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted"> {{ __('translate.No tours associated with this destination') }} </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .description-content {
        min-height: 100px;
    }
    .description-content img {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush
