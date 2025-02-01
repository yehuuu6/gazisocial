<?php

namespace App\Livewire;

use Livewire\Component;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Computed;

class GiphySearch extends Component
{

    public string $query = '';

    #[Computed]
    public function gifs(): array
    {
        if (empty($this->query)) {
            return $this->getTrendingGifs();
        }

        return $this->searchGifs();
    }

    public function searchGifs(): array
    {

        $client = new Client([
            'base_uri' => 'https://api.giphy.com/v1/gifs/',
        ]);

        try {
            $response = $client->get('search', [
                'query' => [
                    'api_key' => env('GIPHY_API_KEY'),
                    'q' => $this->query,
                    'limit' => 20,
                ],
            ]);
        } catch (ClientException $e) {
            Toaster::error('GIPHY API Hatası. Büyük ihtimalle limit doldu...');
            return [];
        }

        return json_decode($response->getBody()->getContents(), true)['data'];
    }

    public function getTrendingGifs(): array
    {
        $client = new Client([
            'base_uri' => 'https://api.giphy.com/v1/gifs/',
        ]);

        try {
            $response = $client->get('trending', [
                'query' => [
                    'api_key' => env('GIPHY_API_KEY'),
                    'limit' => 20,
                ],
            ]);
        } catch (ClientException $e) {
            Toaster::error('GIPHY API Hatası. Büyük ihtimalle limit doldu...');
            return [];
        }

        return json_decode($response->getBody()->getContents(), true)['data'];
    }

    public function selectGif($gif)
    {
        $this->dispatch('gif-selected', gifUrl: $gif);
    }

    public function render()
    {
        return view('livewire.giphy-search');
    }
}
