<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use Carbon\Carbon;
class TvShowViewModel extends ViewModel
{
    public $tvShow;

    public function __construct($tvShow)
    {
        $this->tvShow = $tvShow;
    }

    public function tvShow()
    {
        return collect($this->tvShow)->merge([
            'poster_path' =>  $this->tvShow['poster_path'] 
                ? 'https://image.tmdb.org/t/p/w500' . $this->tvShow['poster_path']
                : 'https://via.placeholder.com/500.jpg',
            'vote_average' =>  $this->tvShow['vote_average'] * 10 .'%',
            'first_air_date' => Carbon::parse($this->tvShow['first_air_date'])->format('M d, Y'),
            'genres' => collect($this->tvShow['genres'])->pluck('name')->flatten()->implode(', '),
            'crews' => collect($this->tvShow['credits']['crew'])->take(2),
            'casts' => collect($this->tvShow['credits']['cast'])->take(5),
            'images' => collect($this->tvShow['images']['backdrops'])->take(9),
            'videos' => collect($this->tvShow['videos']['results']),
           
        ])->only([
            'poster_path', 'vote_average', 'first_air_date', 'genres', 'crews', 'casts', 'images', 
                'videos', 'name', 'id', 'overview', 'poster_path', 'created_by'
        ]);
    }
}
