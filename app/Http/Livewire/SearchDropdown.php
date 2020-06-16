<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search='';
    public function render()
    {
        $movies = [];
        if( strlen($this->search) >= 2 ){
           
            $movies = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/search/movie?query='.$this->search)
                ->json()['results'];
        }
        return view('livewire.search-dropdown',[
                'movies' => collect($movies)->take(7),
        ]);
       
    }
}
