<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SpotifyService
{
    protected $httpClient;
    protected $accessToken;

    public function __construct($accessToken)
    {
        $this->httpClient = new Client([
            'base_uri' => 'https://api.spotify.com/v1/',
        ]);
        $this->accessToken = env('SPOTIFY_ACCESS_TOKEN');
    }

    public function getTopAlbums($limit = 20)
    {
        try {
            $response = $this->httpClient->request('GET', 'browse/new-releases', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ],
                'query' => [
                    'limit' => $limit,
                ],
            ]);
    
            $body = $response->getBody()->getContents();
            //dd($body); // Dump the response body to inspect its contents
    
            return json_decode($body, true);
        } catch (RequestException $e) {
            dd($e->getMessage()); // Dump the error message
            // Handle request exception
            return null;
        }
    }
    public function searchAlbums($query, $limit = 20)
    {
        try {
            $response = $this->httpClient->request('GET', 'search', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ],
                'query' => [
                    'q' => $query,
                    'type' => 'album',
                    'limit' => $limit,
                ],
            ]);
    
            $body = $response->getBody()->getContents();
            $decodedBody = json_decode($body, true);
            //dd($decodedBody);
    
            // Check if the response contains the 'albums' key and if it has 'items'
            if (isset($decodedBody['albums']) && isset($decodedBody['albums']['items'])) {
                // Iterate over each album item and add an 'id' key
                foreach ($decodedBody['albums']['items'] as &$album) {
                    //dd($album);
                    // Assuming 'id' is available in the 'album' object
                    $album['id'] = $album['id']; 
                    //dd($album['id']);// You might need to adjust this based on the actual structure of the response
                }
            }
            //dd($decodedBody);
    
            return $decodedBody;
        } catch (RequestException $e) {
            // Handle request exception
            return null;
        }
    }
    
    public function getAlbumDetails($albumId)
    {
        try {
            $response = $this->httpClient->request('GET', 'albums/' . $albumId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                ],
            ]);

            $body = $response->getBody()->getContents();
            //dd($body);
            return json_decode($body, true);
        } catch (RequestException $e) {
            // Handle request exception
            return null;
        }
    }
    public function searchFavorites($favoritedAlbums, $options = [])
    {
        //dd($favoritedAlbums);
        $requestData = [
            'url' => 'https://api.spotify.com/v1/albums/',
            'params' => [
                'ids' => implode(',', $favoritedAlbums)
            ]
        ];
        //dd($requestData);

        // Merge additional options
        $requestData = array_merge($requestData, $options);
        //dd($requestData);

        // Perform the request
        return $this->performRequest($requestData);
    }

    protected function performRequest($requestData)
    {
        // Construct the request headers
        $headers = [
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Accept' => 'application/json',
        ];

        // Construct the request options
        $options = [
            'headers' => $headers,
        ];
        //dd($options);
        //dd($requestData['params']['ids']);

        // Merge additional options
        if (isset($requestData['params']['ids'])) {
            $options = array_merge($options, $requestData['params']);
            //dd($options);
        }

        try {
            // Make the HTTP GET request
            //dd($requestData);
            $response = $this->httpClient->get($requestData['url'], [
                'headers' => $options['headers'],
                'query' => [
                    'ids' => $options['ids']
                ]
            ]);
            //dd($response);

            // Decode the response body
            $body = $response->getBody()->getContents();
            //dd($body);
            $decodedBody = json_decode($body, true);

            // Return the decoded body
            return $decodedBody;
        } catch (\Exception $e) {
            // Handle exceptions
            return null;
        }
    }


}
