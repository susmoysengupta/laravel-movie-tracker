@extends('layouts.main')
@section('content')

<!-- TV info starts here -->
<div class="tv-info border-b border-gray-800">
    <div class="container mx-auto px-4 py-16 flex flex-col md:flex-row">
        <img src="{{ $tvShow['poster_path'] }}" alt="poster" class="w-64 lg:w-96">
        <div class="md:ml-24">
            <h2 class="text-4xl font-semibold">{{ $tvShow['name'] }}</h2>
            <div class="flex flex-wrap items-center text-gray-400 text-sm">
                <span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" class="svg-inline--fa fa-star fa-w-18 w-4 text-orange-500" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>
                </span>
                <span class="ml-1">{{ $tvShow['vote_average'] }}</span>
                <span class="mx-2">|</span>
                <span>{{ $tvShow['first_air_date'] }}</span>
                <span class="mx-2">|</span>
                <span>
                    <div class="text-gray-400 text-sm">
                        {{ $tvShow['genres'] }}
                    </div>
                </span>
            </div>
            <p class="text-gray-300 mt-8">
                {{ $tvShow['overview'] }} 
            </p>
            <div class="mt-12">
                <h4 class="text-white font-semibold">
                    Featured Crew
                </h4>
                <div class="flex mt-4">
                    @foreach ($tvShow['created_by'] as $crew)
                        <div class="mr-8">
                            <div>{{ $crew['name'] }}</div>
                            <div class="text-sm text-gray-400">Creator</div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div x-data="{isOpen:false}">
                @if (count($tvShow['videos']) > 0)
                    <div class="mt-12">
                        <button
                            @click="isOpen = true"
                            class="flex inline-flex items-center bg-orange-500 text-gray-900 rounded font-semibold px-5 py-4 hover:bg-orange-600 transition ease-in-out duration-150"
                        >
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="play" class="svg-inline--fa fa-play fa-w-14 w-6" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path></svg>
                            <span class="ml-2">Play Trailer</span>
                        </button>
                    </div>
                    <!-- Video modal starts here -->
                    <div x-show.transition.opacity="isOpen" style="background-color: rgba(0, 0, 0, .5);" class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto">
                        <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                            <div class="bg-gray-900 rounded">
                                <div class="flex justify-end pr-4 pt-2">
                                    <button
                                        @click="isOpen = false"
                                        @keydown.escape.window="isOpen = false"
                                        class="text-3xl leading-none hover:text-gray-300">&times;
                                    </button>
                                </div>
                                <div class="modal-body px-8 py-8">
                                    <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                                        <iframe class="responsive-iframe absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/{{ $tvShow['videos'][0]['key'] }}" style="border:0;" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Video modal ends here -->
                @endif
            </div>

        </div>
    </div>
</div>
<!-- TV info ends here -->


<!-- Cast Starts here -->
<div class="tv-cast border-b border-gray-800">
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-semibold">Cast</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
            @foreach ($tvShow['casts'] as $cast)
                <div class="mt-8">
                    <a href="{{ route('actors.show', $cast['id'] ) }}">
                        <img src="{{ 'https://image.tmdb.org/t/p/w300/' . $cast['profile_path'] }}" alt="cast" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>
                    <div class="mt-2">
                        <a href="{{ route('actors.show', $cast['id'] ) }}" class="text-lg mt-2 hover:text-gray-300">{{ $cast['name'] }}</a>
                        <div class="flex items-center text-gray-400 text-sm mt-1">
                            <span>{{ $cast['character'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Cast ends here -->


<!-- Image start here -->
<div class="tv-images" x-data="{ isOpen: false, image: '' }">
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-semibold">Images</h2>
        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($tvShow['images'] as $image)
                <div class="mt-8">
                    <a href="#" @click.prevent="isOpen = true, image= '{{ 'https://image.tmdb.org/t/p/original/' . $image['file_path'] }}' ">
                        <img src="{{ 'https://image.tmdb.org/t/p/w500/' . $image['file_path'] }}" alt="parasite" class="hover:opacity-75 transition ease-in-out duration-150">
                    </a>
                </div>
            @endforeach
        </div>
        <div x-show.transition.opacity="isOpen" style="background-color: rgba(0, 0, 0, .5);" class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto">
            <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                <div class="bg-gray-900 rounded">
                    <div class="flex justify-end pr-4 pt-2">
                        <button
                            @click="isOpen = false"
                            @keydown.escape.window="isOpen = false"
                            class="text-3xl leading-none hover:text-gray-300">&times;
                        </button>
                    </div>
                    <div class="modal-body px-8 py-8">
                        <img :src="image" alt="poster">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Image ends here -->
    
@endsection


