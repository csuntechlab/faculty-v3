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

<section class="bg-white py-5">
    <h1 class="text-primary text-center">Welcome New Faculty</h1>
</section>
<section>
    <!-- <div id="reorder" class="btn">Reorder</div> -->
    <div id="cycleLinear" class="btn">cycle linear</div>
    <div id="cycleRandom" class="btn">cycle random</div>
    <div class="container py-5">
        


        @if($people->total() > 0)
            <div class="row text-center py-2 grid">
                @foreach($people as $person)
                    <div class="newFac">
                        <a href="{{ route('profile', ['uri' => $person->uri]) }}" class="card welcome-card">
                            <img class="profile-card__img d-block mx-auto mt-4"
                                 data-profile-uri="{{ $person->uri }}" 
                                 src="{{ asset('imgs/profile-default.png') }}"
                                 alt="Card image for {{ $person->display_name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $person->display_name }}</h5>
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
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<!-- <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script> -->

<script>

$.fn.random = function() {
  return this.eq(Math.floor(Math.random() * this.length));
}

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



    // function reorder( ){
    //     console.log("reorder");
    //     var newFac = document.querySelectorAll('.newFac');
    //     for (var i = 0; i < newFac.length; i++) {
    //         var randomNumb1 = Math.floor(Math.random() * newFac.length)
    //         var randomNumb2 = Math.floor(Math.random() * newFac.length)
    //         var randomNumb3 = Math.floor(Math.random() * newFac.length)
    //         var randomNumb4 = Math.floor(Math.random() * newFac.length)
    //         var randomNumb5 = Math.floor(Math.random() * newFac.length)
    //         var randomNumb6 = Math.floor(Math.random() * newFac.length)

    //         console.log("random number: " + randomNumb1)
    //         console.log("i: " + i)
    //         if (randomNumb1 === i || randomNumb2 === i) {
    //             newFac[i].classList.add('newFac--med');
    //         } else {
    //             newFac[i].classList.remove('newFac--med');
    //         }
    //         if (randomNumb3 === i || randomNumb4 === i) {
    //             newFac[i].classList.add('newFac--big');
    //         } else {
    //             newFac[i].classList.remove('newFac--big');
    //         }
    //         if (randomNumb5 === i || randomNumb6 === i) {
    //             newFac[i].classList.add('newFac--giant');
    //         } else {
    //             newFac[i].classList.remove('newFac--giant');
    //         }
    //         // $grid.isotope('shuffle');
    //         // $grid.isotope('layout');
    //         $grid.masonry('layout');
            
    //     }
    // };

    // reorder();
    // setInterval(reorder, 3000);

    $(".grid").children('.newFac').first().addClass("active");

    function cycleLinear(){
        console.log("cycleLinear");

        $(".newFac.active").addClass("interum");
        if( $(".interum").next(".newFac").length ) {
            $(".interum").next(".newFac").addClass("active");
        } else {
            //no more cards, go back to begining
            $(".newFac").first().addClass("active")
        }
        
        $(".interum").removeClass("active");
        $(".interum").removeClass("interum");
    };

    function cycleRandom(){
        console.log("cycleRandom");

        $(".newFac.active").addClass("was-active");
        $(".was-active").removeClass("active");
        if( $(".newFac:not(.was-active)").length )
            $(".newFac:not(.was-active)").random().addClass("active")
        else {
            console.log("we've cycled thru everything so start over");
            $(".newFac").removeClass("was-active");
            $(".newFac").random().addClass("active")
        }        
    };

    // cycle();
    setInterval(cycleRandom, 3000);

    $("#reorder").on( "click", function() {
        reorder();
    });

    $("#cycleLinear").on( "click", function() {
        cycleLinear();
    });

    $("#cycleRandom").on( "click", function() {
        cycleRandom();
    });


});



</script>

<style>

#reorder,
#cycleLinear,
#cycleRandom {
    position: fixed;
}

#cycleLinear {
    top: 50px;
}

#cycleRandom {
    top: 80px;
}
</style>
@stop
