@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content-box content-single">
                    <article class="post-8 page type-page status-publish hentry">
                        <header>
                            <h1 class="entry-title">{{ request()->filled('search') || request()->filled('gender') ? 'Search results' : 'All Users' }}

                                <span style="float: right; color: dodgerblue" data-title="fas fa-male" aria-label="fas fa-male">
                                    <i class="fas fas fa-male" aria-hidden="true"> . </i>
                                    {{ $total_males }}
                                </span>

                                <span style="float: right;margin-right: 20px; color: deeppink" data-title="fas fa-female" aria-label="fas fa-female">
                                    <i class="fas fas fa-female" aria-hidden="true"> . </i>
                                    {{ $total_females }}
                                </span>
                            </h1>
                        </header>
                        <div class="entry-content entry-summary">
                            <div class="geodir-search-container geodir-advance-search-default" data-show-adv="default">
                                <form class="geodir-listing-search gd-search-bar-style" name="geodir-listing-search"
                                      action="{{ route('home') }}" method="get">
                                    <div class="geodir-loc-bar">
                                        <div class="clearfix geodir-loc-bar-in">
                                            <div class="geodir-search">
                                                <div class='gd-search-input-wrapper gd-search-field-cpt gd-search-field-taxonomy gd-search-field-categories'>
                                                    <select name="gender" class="gender_select">
                                                        <option value="">Choose Gender</option>
                                                        <option
                                                            value="Male" {{ request()->input('gender') == 'Male' ? ' selected' : '' }}>
                                                            Male
                                                        </option>
                                                        <option
                                                            value="Female" {{ request()->input('gender') == 'Female' ? ' selected' : '' }}>
                                                            Female
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class='gd-search-input-wrapper gd-search-field-cpt gd-search-field-taxonomy gd-search-field-categories'>
                                                    <select name="city" class="city_select">
                                                        <option value="">Choose City</option>
                                                        <option value="48.8566,2.3522"  {{ request()->input('city') == '48.8566,2.3522' ? ' selected' : '' }}>London</option>
                                                        <option value="51.5072,0.1276"  {{ request()->input('city') == '51.5072,0.1276' ? ' selected' : '' }}>Paris</option>
                                                        <option value="39.0119,98.4842" {{ request()->input('city') == '39.0119,98.4842' ? ' selected' : '' }}>Kansas</option>
                                                    </select>
                                                </div>

                                                <div class='gd-search-input-wrapper gd-search-field-search'><span
                                                        class="geodir-search-input-label"><i
                                                            class="fas fa-search gd-show"></i><i
                                                            class="fas fa-times geodir-search-input-label-clear gd-hide"
                                                            title="Clear field"></i></span>
                                                    <input class="search_text gd_search_text" name="search"
                                                           value="{{ request()->input('search') }}" type="text"
                                                           placeholder="Search" aria-label="Search for"
                                                           autocomplete="off"/>
                                                </div>
                                                <button style="background-color: deeppink!important;" class="geodir_submit_search" data-title="fas fa-search"
                                                        aria-label="fas fa-search"><i class="fas fas fa-filter" aria-hidden="true"></i><span
                                                        class="sr-only">Search</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="geodir-loop-container">
                                <ul class="geodir-category-list-view clearfix gridview_onethird geodir-listing-posts geodir-gridview gridview_onethird">
                                    @foreach($users as $user)
                                        <li class="gd_place type-gd_place status-publish has-post-thumbnail">
                                            <div class="gd-list-item-left ">
                                                <div class="geodir-post-slider">
                                                    <div class="geodir-image-container geodir-image-sizes-medium_large">
                                                        <div class="geodir-image-wrapper">
                                                            <ul class="geodir-post-image geodir-images clearfix">
                                                                <li>
                                                                    <a href='#'>
                                                                        <img src="{{ URL::asset('assets/images/'.$user['gender'].'img.png') }}" width="140" height="60"
                                                                             class="geodir-lazy-load align size-medium_large"/>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="gd-list-item-right ">
                                                <div class="geodir-post-title">
                                                    <h2 class="geodir-entry-title gd-align-center">
                                                        <a style="color: #E80E8A!important;" href="#" title="View: {{ $user['first_name'] }}">{{ $user['first_name'] .' '. $user['last_name'] }}</a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="clear"></div>
                            </div>

                                                    @include('partials.pagination', ['users' => $users])
{{--                            {{ $users->appends(request()->query())->links('partials.pagination') }}--}}

{{--                            {{ $users->render() }}--}}
                        </div>
                        <footer class="entry-footer"></footer>
                    </article>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type='text/javascript'
            src='https://maps.google.com/maps/api/js?language=en&key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&region=GB'></script>
    <script defer>
        function initialize() {
            var mapOptions = {
                zoom: 12,
                minZoom: 1,
                maxZoom: 1000,
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.DEFAULT
                },
                center: new google.maps.LatLng('29.3352938', '48.0715612'),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false,
                panControl: false,
                mapTypeControl: true,
                scaleControl: false,
                overviewMapControl: false,
                rotateControl: false
            }
            var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            var image = new google.maps.MarkerImage("assets/images/female.png", null, null, null, new google.maps.Size(40, 52));
            var places = @json($users->items());

            for (place in places) {
                place = places[place];
                if (place.lat && place.lon) {
                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng(place.lat, place.lon),
                        icon: new google.maps.MarkerImage("assets/images/"+place.gender+".png", null, null, null, new google.maps.Size(40, 52)),
                        map: map,
                        title: place.first_name
                    });
                    var infowindow = new google.maps.InfoWindow();
                    google.maps.event.addListener(marker, 'click', (function (marker, place) {
                        return function () {
                            infowindow.setContent(generateContent(place))
                            infowindow.open(map, marker);
                        }
                    })(marker, place));
                }
            }
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        function generateContent(place) {
            var content = `
            <div class="gd-bubble" style="">
                <div class="gd-bubble-inside">
                    <div class="geodir-bubble_desc">
                    <div class="geodir-bubble_image">
                        <div class="geodir-post-slider">
                            <div class="geodir-image-container geodir-image-sizes-medium_large ">
                                <div id="geodir_images_5de53f2a45254_189" class="geodir-image-wrapper" data-controlnav="1">
                                    <ul class="geodir-post-image geodir-images clearfix">
                                        <li>
                                            <div class="geodir-post-title">
                                                <h4 class="geodir-entry-title">
                                                    <a href="{{ route('home', '') }}/` + place.id + `" title="View: ` + place.first_name + `">` + place.first_name + `</a>
                                                </h4>
                                            </div>
                                            <a href="#"><img src="assets/images/${place.gender}img.png" alt="` + place.first_name + `" class="align size-medium_large" width="200" height="230"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="geodir-bubble-meta-side">
                    <div class="geodir-output-location">
                    <div class="geodir-output-location geodir-output-location-mapbubble">
                        <div class="geodir_post_meta  geodir-field-post_title"><span class="geodir_post_meta_icon geodir-i-text">
                            <i class="fas fa-minus" aria-hidden="true"></i>
                            <span class="geodir_post_meta_title">Place Title: </span></span>` + place.first_name + " " + place.last_name + `</div>
                        <div class="geodir_post_meta  geodir-field-address" itemscope="" itemtype="http://schema.org/PostalAddress">
                            <span class="geodir_post_meta_icon geodir-i-address"><i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            <span class="geodir_post_meta_title">Address: </span></span><span itemprop="streetAddress">` + place.lat + `</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
            </div>`;

            return content;

        }
    </script>
@endsection
