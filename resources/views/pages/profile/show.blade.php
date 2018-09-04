@extends('layouts.master')

@section('page-specific-headers')
<meta name="faculty-url" content="{{ env('FACULTY_APP_URL') }}">
<meta name="affinity-url" content="{{ env('AFFINITY_WEB_SERVICE') }}">
<meta name="curriculum-url" content="{{ env('CURRICULUM_WEB_SERVICE') }}">
<meta name="degrees-url" content="{{ env('DEGREES_WEB_SERVICE') }}">
<meta name="directory-url" content="{{ env('DIRECTORY_WEB_SERVICE') }}">
<meta name="media-url" content="{{ env('MEDIA_WEB_SERVICE') }}">
<meta name="waldo-url" content="{{ env('WALDO_WEB_SERVICE') }}">
<meta name="person-name" content="{{ $user->display_name }}">
<meta name="person-uri" content="{{ $user->uri }}">
<meta name="person-email" content="{{ $user->email }}">
<meta name="current-term-id" content="{{ $currentTerm->term_id }}">
@stop

{{-- META TAGS 4 SEO --}}
@section('title')
{{ $user->display_name }}
@stop

@section('description')
{{ $user->biography }}
@stop

@section('content')

{{--  PROFILE BANNER --}}
<div>
	<section class="FAC-banner">
        <div id="FAC-banner__overlay"></div>
        <div class="container">
            <div class="row align-items-center pt-3">
                <div class="col-12 col-md-4">
                    <h1 class="FAC-banner__name--sm">{{ $user->display_name }}</h1>
                    <div class="FAC-banner__department--sm">
                        {{ strtoupper($user->rank) }} |
                        @if($user->primary_department)
                            <a href="{{ facultyUrl('departments/' . $user->primary_department->department_id) }}">{{ $user->primary_department->name }}</a>
                        @endif
                    </div>
                    <img class="FAC-banner__image" src="{{ asset('imgs/profile-default.png') }}" alt="Photo of {{ $user->display_name }}" id="profile-image">
                </div>
                <div class="col-12 col-md-8">
                    <div id="FAC-banner__content">
                        
                        <div class="FAC-banner__department">{{ strtoupper($user->rank) }} |
                        	@if($user->primary_department)
	                        	<a href="{{ facultyUrl('departments/' . $user->primary_department->department_id) }}">{{ $user->primary_department->name }}</a>
	                        @endif
	                        @if($user->is_csun_alum)
	                        	<a class="FAC-banner__badge badge px-2 ml-2" href="#">CSUN Alum<i class="fas fa-graduation-cap ml-2"></i></a>
	                        @endif
                        </div>
                        
                        <h1 class="FAC-banner__name">{{ $user->display_name }}</h1> 
                        
                        @if($user->primary_connection)
                        	<div class="FAC-banner__title">{{ $user->primary_connection->pivot->title }}</div>
                        @endif
                                                
                        {{--
                        <ul class="FAC-banner__icons">
                            <li class="list-inline-item">
                                <a href="#"><i class="fab fa-twitter-square fa-lg"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#"><i class="fab fa-linkedin fa-lg"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#"><i class="fab fa-github-square fa-lg"></i></a>
                            </li>
                        </ul> 
                        --}}                       
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- VUE PORTION OF THE PROFILE --}}
<div id="profile_app">
</div>
@stop

{{-- LOAD PROFILE IMAGE ASYNCHRONOUSLY (OUTSIDE OF VUE) --}}
@section('page-specific-scripts')
<script>
$(function() {
    var mediaWsUrl = $("meta[name=media-url]").attr('content');
    var profileImgUri = $("meta[name=person-uri]").attr('content') +
        '/avatar';
    axios.get(
        profileImgUri,
        {
            baseURL: mediaWsUrl
        }
    ).then(function(response) {
        // Media WS results in a redirect when it returns the proper image
        // so we can use that as the "src" attribute in the profile image
        // placeholder
        $("#profile-image").attr('src', response.request.responseURL);
    }).catch(function(error) {
        console.error(error);
    });
});
</script>
@stop