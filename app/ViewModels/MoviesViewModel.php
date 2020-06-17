<?php

namespace App\ViewModels;

use Spatie\ViewModels\ViewModel;
use Carbon\Carbon;

class MoviesViewModel extends ViewModel
{
    Public $popularMovies;
    Public $genres;
    Public $nowPlayings;

    public function __construct($popularMovies, $genres, $nowPlayings)
    {
        $this->popularMovies = $popularMovies;
        $this->genres = $genres;
        $this->nowPlayings = $nowPlayings;
    }

    public function popularMovies()
    {
        return $this->formatMovie($this->nowPlayings);
    }

    public function nowPlayings()
    {
        return $this->formatMovie($this->nowPlayings);
    }

    public function genres()
    {
        return collect($this->genres)->mapWithKeys(function ($genre){
            return [ $genre['id'] => $genre['name'] ];
        });
    }

    private function formatMovie($movie)
    {
        return collect($movie)->map(function($movie){
            $formattedGenres = collect($movie['genre_ids'])->mapWithKeys(function ($genre){
                return [ $genre => $this->genres()->get($genre) ];
            })->implode(', ');

            return collect($movie)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'],
                'vote_average' =>  $movie['vote_average'] * 10 .'%',
                'release_date' => Carbon::parse($movie['release_date'])->format('M d, Y'),
                'genres' => $formattedGenres
            ])->only([
                'poster_path', 'vote_average', 'release_date', 'genres', 'id', 'title', 'overview'
            ]);
        });
    }
}
