<div class="relative md:ml-4 mt-3 md:mt-0" x-data="{ isOpen: true }" @click.away = "isOpen = false">
    <input 
        wire:model.debounce.586ms="search" 
        type="text" 
        class="bg-gray-800 text-sm rounded-full w-64 px-4 pl-8 py-1 focus:outline-none focus:shadow-outline" 
        placeholder="Search(Press '/' to focus)"
        @focus = "isOpen = true"
        @keydown = "isOpen = true"
        @keydown.escape.window = "isOpen = false"
        @keydown.shift.tab = " isOpen = false"
        x-ref="search"
        @keydown.window = "
            if( event.keyCode == 191 ){
                event.preventDefault();
                $refs.search.focus();
            }
        "
    >
    {{-- <span class="fa-fa-film"></span> --}}
    <div class="absolute top-0">
        <svg  class="fa fa-search fa-w-4 w-4 text-gray-500 mb-1 ml-2"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>
    </div>
    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3"></div>
    @if (strlen($search) >= 2)
        <div 
            class="z-index absolute bg-gray-800 text-sm rounded w-64 mt-4" 
            x-show.transition.opacity="isOpen"
        >
            @if ($movies->count())
                @foreach ($movies as $movie)
                    <ul>
                        <li class="border-b border-gray-700">
                            <a 
                                href="{{ route('movies.show', $movie['id']) }}"
                                class="block hover:bg-gray-700 px-3 py-3 flex items-center transition ease-in-out duration-150"
                                @if( $loop->last ) @keydown.tab="isOpen = false" @endif
                            >
                                @if ($movie['poster_path'])
                                    <img src="{{ 'https://image.tmdb.org/t/p/w92/' . $movie['poster_path'] }}" alt="poster" class="w-8">
                                @else
                                    <img src="https://via.placeholder.com/50x75" alt="poster" class="w-8">
                                @endif
                                <span class="ml-4">{{ $movie['title'] }}</span>
                            </a>
                        </li>
                    </ul>
                @endforeach
            @else
                    <div class="px-3 py-3">No results for "{{ $search }}"</div>
            @endif
        </div>
    @endif
</div>