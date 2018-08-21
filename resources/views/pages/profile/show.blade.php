@extends('layouts.master')

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
                	 @if(!empty($imageData))
                     	<img class="FAC-banner__image" src="{{ $imageData }}" alt="Photo of {{ $user->display_name }}">
                     @else
                     	<img class="FAC-banner__image" src="{{ asset('imgs/profile-default.png') }}" alt="Photo of {{ $user->display_name }}">
                     @endif
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