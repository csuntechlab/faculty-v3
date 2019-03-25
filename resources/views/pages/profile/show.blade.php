@extends('layouts.master')

@section('page-specific-headers')
<meta name="faculty-url" content="{{ env('FACULTY_APP_URL') }}">
<meta name="helix-url" content="{{ env('HELIX_APP_URL') }}">
<meta name="affinity-url" content="{{ env('AFFINITY_WEB_SERVICE') }}">
<meta name="curriculum-url" content="{{ env('CURRICULUM_WEB_SERVICE') }}">
<meta name="degrees-url" content="{{ env('DEGREES_WEB_SERVICE') }}">
<meta name="directory-url" content="{{ env('DIRECTORY_WEB_SERVICE') }}">
<meta name="media-url" content="{{ env('MEDIA_WEB_SERVICE') }}">
<meta name="citations-url" content="{{ env('CITATIONS_WEB_SERVICE') }}">
<meta name="projects-url" content="{{ env('PROJECTS_WEB_SERVICE') }}">
<meta name="waldo-url" content="{{ env('WALDO_WEB_SERVICE') }}">
<meta name="person-name" content="{{ $user->display_name }}">
<meta name="person-uri" content="{{ $user->uri }}">
<meta name="person-email" content="{{ $user->email }}">
<meta name="current-term-id" content="{{ $currentTerm->term_id }}">

{{-- for waldo map --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css"
        integrity="sha512-M2wvCLH6DSRazYeZRIm1JnYyh22purTM+FDB5CsyxtQJYeKq83arPe5wgbNmcFXGqiSH2XR8dT/fJISVA1r/zQ=="
        crossorigin=""/>
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
	<section class="profile-banner d-flex align-items-center">
        <div class="profile-banner__overlay">
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-4">
                    <!-- <h1 class="profile-banner__name d-block d-md-none text-center">{{ $user->display_name }}</h1>
                    <div class="profile-banner__department text-primary text-center d-block d-md-none">
                        {{ strtoupper($user->rank) }} |
                        @if($user->primary_department)
                            <a href="{{ facultyUrl('departments/' . $user->primary_department->department_id) }}">{{ $user->primary_department->name }}</a>
                        @endif
                    </div> -->
                    <img class="profile-banner__image img-fluid mx-auto d-block" src="{{ asset('imgs/profile-default.png') }}" alt="Photo of {{ $user->display_name }}" id="profile-image">
                </div>
                <div class="col-12 col-md-8">
                    <div class="profile-banner__content">
                        <div class="row">
                            <div class="col-12 order-2 order-md-1">
                                <div class="profile-banner__department">{{ strtoupper($user->rank) }} |
                                    @if($user->primary_department)
                                        <a href="{{ route('departments.faculty', ['id' => $user->primary_department->department_id]) }}">{{ $user->primary_department->name }}</a>
                                    @endif
                                    @if($user->is_csun_alum)
                                        <a class="profile-banner__badge badge badge-primary px-2 ml-2" href="#">CSUN Alum<i class="fas fa-graduation-cap ml-2"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 order-1 order-md-2">
                                <h1 class="profile-banner__name">
                                    <span class="position-relative">
                                        {{ $user->display_name }}
                                        <span id="audio-play" class="profile-banner__audio-icon d-none">
                                            <i class="fas fa-volume-up"></i>
                                        </span>
                                    </span>
                                </h1> 

                                <audio id="audio" class="d-none">
                                </audio>
                            </div>
                            @if($user->primary_connection_line)
                                <div class="col-12 order-3">
                                    <div class="profile-banner__title">
                                        {{ $user->primary_connection_line }}
                                    </div>
                                </div>
                            @endif
                        </div>
                                                
                        {{--
                        <ul class="profile-banner__icons list-unstyled">
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
        '/avatar?source=true';
    var profileAudioUri = $("meta[name=person-uri]").attr('content') +
        '/audio';
    var audioElem = document.querySelector("#audio");
    var audioPlayButton = document.querySelector("#audio-play");

    axios.get(
        profileImgUri,
        {
            baseURL: mediaWsUrl + 'faculty/media'
        }
    ).then(function(response) {
        $("#profile-image").attr('src',response.request.responseURL);
    }).catch(function(error) {
        console.error(error);
    });

    //hit media webservice and retrieve raw audio file
    axios.get(
        profileAudioUri,
        {
            baseURL: mediaWsUrl + 'faculty/media'
        }
    ).then(function(response) {
        //check to make sure the audio file exists
        if( response.data.audio_recording !== undefined && response.data.audio_recording !== null) {
            //set the <audio> element src attribute to the audio file we just retrieved from media
            $("#audio").attr('src',response.data.audio_recording + "?source=true")

            //make the play icon visible and add event listener
            audioPlayButton.classList.remove("d-none");
            audioPlayButton.addEventListener("click", handlePlayButton, false);
            
            // the rest of this code uses the HTMLMediaElement API to handle playing, pausing, and ending the video
            function handlePlayButton() {
                if (audioElem.paused) {
                    playAudio();
                } else {
                    audioElem.pause();
                }
            }
            async function playAudio() {
                try {
                    await audioElem.play();
                    audioPlayButton.classList.add("playing");
                } catch(err) {
                    audioPlayButton.classList.remove("playing");
                }
            }
            function handlePausedOrEndedAudio() {
                audioPlayButton.classList.remove("playing");
            }
            audioElem.addEventListener('ended', () => {
                handlePausedOrEndedAudio();
            });
            audioElem.addEventListener('pause', () => {
                handlePausedOrEndedAudio();
            });
        }
    }).catch(function(error) {
        console.error(error);
    });

});
</script>
{{-- Waldo map scripts --}}
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"
            integrity="sha512-lInM/apFSqyy1o6s89K4iQUKg6ppXEgsVxT35HbzUupEVRh2Eu9Wdl4tHj7dZO0s1uvplcYGmt3498TtHq+log=="
            crossorigin=""></script>
@stop

{{-- WALDO MODAL --}}
@section('modal')
    {{--waldo map modal--}}
    @include('pages.profile.partials.waldo-map')
@stop