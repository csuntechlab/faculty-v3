@extends('layouts.master')

@section('title')
    @if(!empty($title))
        {{ $title }}
    @else
        All Faculty
    @endif
@stop

@section('page-specific-headers')
<meta name="media-url" content="{{ env('MEDIA_WEB_SERVICE') }}">
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
                    <li class="breadcrumb-item active">Search Results: &quot;{{ $q }}&quot;</li>
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
                <input type="text" name="q" value="{{ !empty($q) ? $q : '' }}" placeholder="Search by Name..." class="form-control d-inline searchBanner__input">
            </div>
            <div class="col-md-2 col-sm-3 col-3 pl-0">
                <button type="submit" class="btn btn-primary btn-block searchBanner__btn"><i class="fas fa-search"></i>  Search</button>
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
                                <a href="tel:{{ $department->contact->telephone }}"><i class="fas fa-phone"></i>{{ formatPhoneNumber($department->contact->telephone) }}</a>
                            </div>
                        @endif
                        @if(!empty($department->contact->website))
                            <div class="departmentHeader__item pr-3">
                                <a href="{{ checkHttp($department->contact->website) }}"><i class="fas fa-globe-americas"></i>Website</a>
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
                        {{ $people->total() }} Faculty Member(s) <span class="font-weight-normal">in {{ $department->name }}</span>
                    @elseif($type == 'search_results')
                        {{ $people->total() }} Result(s) <span class="font-weight-normal">for &quot;{{ $q }}&quot;</span>
                    @else
                        {{ $people->total() }} Faculty Members
                    @endif
                </h5>
            </div>
        </div>

        @if($people->total() > 0)
            <div class="row text-center py-2">
                @foreach($people as $person)
                    <div class="col-lg-4 col-sm-6 col-12 py-2 mb-4" >
                        <a href="{{ route('profile', ['uri' => $person->uri]) }}" class="card profile-card">
                            <img class="profile-card__img d-block mx-auto mt-4"
                                 data-profile-uri="{{ $person->uri }}" 
                                 src="{{ asset('imgs/profile-default.png') }}"
                                 alt="Card image for {{ $person->display_name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $person->display_name }}</h5>
                                <div class="card-text">{{ $person->rank }}</div>
                                <div>
                                    @if($type == 'department_faculty')
                                        {{ $department->name }}
                                    @else
                                        @if(!empty($person->primary_connection))
                                            {{ $person->primary_connection->name }}
                                        @elseif(!empty($person->primary_department))
                                            {{ $person->primary_department->name }}
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        @if($people->total() > 0)
            <div class="row justify-content-center my-3 my-md-5">
                <div class="col-4">
                    <nav aria-label="Page navigation">
                        {!! $people->links() !!}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</section>
@stop

@section('page-specific-scripts')
<script>
$(function() {
    let mediaWsUrl = $("meta[name=media-url]").attr('content');
    // iterate over the card images to load the respective profile images
    $("img.profile-card__img").each(function(index, element) {
        let profileUri = $(element).attr('data-profile-uri');
        let profileImgUri = profileUri + '/avatar';

        // fire off the Axios call to retrieve the image
        axios.get(
            profileImgUri,
            {
                baseURL: mediaWsUrl + 'faculty/media'
            }
        ).then(function(response) {
            // Media WS results in a JSON object when it returns the proper image
            // result so we can use that as the "src" attribute in the profile image
            // placeholder
            $(element).attr('src', response.data.avatar_image);
        }).catch(function(error) {
            console.error(error);
        });
    });
});
</script>
@stop
