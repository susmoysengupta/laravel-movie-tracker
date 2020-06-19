<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use Carbon\Carbon;
class TvViewModel extends ViewModel
{
    Public $popularTv;
    Public $topRated;
    Public $genres;

    public function __construct($popularTv, $topRated, $genres)
    {
        $this->popularTv = $popularTv;
        $this->genres = $genres;
        $this->topRated = $topRated;
    }

    public function popularTv()
    {
        return $this->formatMovie($this->popularTv);
    }

    public function topRated()
    {
        return $this->formatMovie($this->topRated);
    }

    public function genres()
    {
        return collect($this->genres)->mapWithKeys(function ($genre){
            return [ $genre['id'] => $genre['name'] ];
        });
    }

    private function formatMovie($tv)
    {
        return collect($tv)->map(function($show){

            $formattedGenres = collect($show['genre_ids'])->mapWithKeys(function ($genre){
                return [ $genre => $this->genres()->get($genre) ];
            })->implode(', ');

            return collect($show)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500' . $show['poster_path'],
                'vote_average' =>  $show['vote_average'] * 10 .'%',
                'first_air_date' => Carbon::parse($show['first_air_date'])->format('M d, Y'),
                'genres' => $formattedGenres
            ])->only([
                'poster_path', 'vote_average', 'first_air_date', 'genres', 'id', 'name', 'overview'
            ]);
        });
    }
}
