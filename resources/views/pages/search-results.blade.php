@extends('layouts.master')

@section('title')
    @if(!empty($title))
        {{ $title }}
    @else
        All Faculty
    @endif
@stop


@section('content')
<div class="pb-1 bg-white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('departments') }}">All Departments</a></li>
                @if($type == 'department_faculty')
                    <li class="breadcrumb-item active">{{ $department->name }}</li>
                @elseif($type == 'search_results')
                    <li class="breadcrumb-item active">Search Results: "{{ $query }}"</li>
                @else
                    <li class="breadcrumb-item active">All Faculty</li>
                @endif
            </ol>
        </nav>

    </div>
</div>

<section class="searchBanner bg-white pb-5 pt-4">
    <div class="container">
        {!! Form::open(['route' => 'search', 'method' => 'GET']) !!}
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-8 col-7 pr-0">
                <input type="text" name="q" value="{{ !empty($query) ? $query : '' }}" placeholder="Search by Name..." class="form-control d-inline searchBanner__input">
            </div>
            <div class="col-md-2 col-sm-3 col-3 pl-0">
                <button type="button" class="btn btn-primary btn-block searchBanner__btn"><i class="fas fa-search"></i>  Search</button>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="row">
            <div class="col-12 pt-5 text-center" >
                <a href="{{ route('departments') }}">Browse By Department</a> 
            </div>
        </div>
    </div>
</section>




<section>
    <div class="container py-5">
        @if($type == 'department_faculty')
            <div class="departmentHeader mb-sm-5 mb-4 clearfix">
                <h3 class="departmentHeader__title">{{ $department->name }}</h3>
                @if(!empty($department->contact))
                    <div class="departmentHeader__itemWrapper clearfix">
                        @if(!empty($department->contact->location))
                            <div class="departmentHeader__item pr-3">
                                <i class="far fa-building"></i>{{ $department->contact->location }}
                            </div>
                        @endif
                        @if(!empty($department->contact->office))
                            <div class="departmentHeader__item pr-3">
                                <i class="fas fa-map-marker-alt"></i>{{ $department->contact->office }}
                            </div>
                        @endif
                        @if(!empty($department->contact->mail_drop))
                            <div class="departmentHeader__item pr-3">
                                <i class="far fa-envelope"></i>{{ $department->contact->mail_drop }}
                            </div>
                        @endif
                        @if(!empty($department->contact->telephone))
                            <div class="departmentHeader__item pr-3">
                                <i class="fas fa-phone"></i>{{ formatPhoneNumber($department->contact->telephone) }}
                            </div>
                        @endif
                        @if(!empty($department->contact->website))
                            <div class="departmentHeader__item pr-3">
                                <a href="{{ $department->contact->website }}"><i class="fas fa-globe-americas"></i>Website</a>
                            </div>
                        @endif
                        @if(!empty($department->contact->email))
                            <div class="departmentHeader__item pr-3">
                                <a href="mailto:{{ $department->contact->email }}"><i class="fas fa-envelope"></i>{{ $department->contact->email }}</a>  
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        <div class="row">
            <div class="col-sm-12 text-center text-md-left">
                <h5 class="mb-3">
                    @if($type == 'department_faculty')
                        {{ $people->count() }} Faculty Member(s) <span class="font-weight-normal">in {{ $department->name }}</span>
                    @elseif($type == 'search_results')
                        {{ $people->count() }} Result(s) <span class="font-weight-normal">for "{{ $query }}"</span>
                    @else
                        {{ $people->count() }} Faculty Members
                    @endif
                </h5>
            </div>
        </div>

        <div class="row text-center py-2">
            <div class="col-lg-4 col-sm-6 col-12 py-2 mb-4" >
                <a href="#" class="card profile-card">
                    <img class="profile-card__img d-block mx-auto mt-4"  src="https://cdn.metalab.csun.edu/media/faculty/steven.fitzgerald/avatar.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Steven Fitzgerald</h5>
                        <div class="card-text">Professor</div>
                        <div>Computer Science</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 py-2 mb-4" >
                <a href="#" class="card profile-card">
                    <img class="profile-card__img d-block mx-auto mt-4"  src="https://cdn.metalab.csun.edu/media/faculty/steven.fitzgerald/avatar.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Cheryl Spector</h5>
                        <div class="card-text">Professor</div>
                        <div>English</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 py-2 mb-4" >
                <a href="#" class="card profile-card">
                    <img class="profile-card__img d-block mx-auto mt-4"  src="https://cdn.metalab.csun.edu/media/faculty/steven.fitzgerald/avatar.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Nerces Kevork Kazandjian</h5>
                        <div class="card-text">Faculty</div>
                        <div>Computer Science</div>
                    </div>
                </a>
            </div>


            <div class="col-lg-4 col-sm-6 col-12 py-2 mb-4" >
                <a href="#" class="card profile-card">
                    <img class="profile-card__img d-block mx-auto mt-4"  src="https://cdn.metalab.csun.edu/media/faculty/steven.fitzgerald/avatar.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Bobbie (Roberta) Emetu</h5>
                        <div class="card-text">Assistant Professor</div>
                        <div>Health Sciences</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 py-2 mb-4" >
                <a href="#" class="card profile-card">
                    <img class="profile-card__img d-block mx-auto mt-4"  src="https://cdn.metalab.csun.edu/media/faculty/steven.fitzgerald/avatar.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Cati Acevedo-Torres</h5>
                        <div class="card-text">Lecturer</div>
                        <div>Finance, Financial Planning, and Insurance</div>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6 col-12 py-2 mb-4" >
                <a href="#" class="card profile-card">
                    <img class="profile-card__img d-block mx-auto mt-4"  src="https://cdn.metalab.csun.edu/media/faculty/steven.fitzgerald/avatar.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Thomas J Abraham</h5>
                        <div class="card-text">Lecturer</div>
                        <div>Educational Leadership & Policy Studies</div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row justify-content-center my-3 my-md-5">
            <div class="col-4">
                <nav aria-label="Page navigation example">
                <ul class="pagination pagination-lg justify-content-center">
                    <li class="page-item pr-2">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item px-2"><a class="page-link" href="#">1</a></li>
                    <li class="page-item px-2"><a class="page-link" href="#">2</a></li>
                    <li class="page-item px-2"><a class="page-link" href="#">3</a></li>
                    <li class="page-item pl-2">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
@stop

@section('page-specific-scripts')
<script>
$(function() {

});
</script>
@stop
