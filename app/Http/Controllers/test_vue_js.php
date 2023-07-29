<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use GuzzleHttp\Client;

class test_vue_js extends Controller
{

    public function getMessage(Request $request)
    {
        return response()->json(['message' => 'welcome M.'.$request->input('name')]);
    }

    public function index()
    {
        return view('welcome');
    }

    public function index1()
    {
        /* $url = "www.w3schools.com";
        function get_visitors($url) {
            $data = file_get_contents("http://api.similarweb.com/v1/website/" . $url . "/traffic/overview");
            
            if ($data === false) {
                return null;
            }
            
            $json = json_decode($data);
            return $json->total_visitors;
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $url = "www.w3schools.com";
            $visitors = get_visitors($url);
            echo $visitors;
        } */    
        // Usage example
        $apiKey = "544705a9039a434a980baee9a7388915";
        $websiteUrl = "w3schools.com";

        /*$totalVisits = $this->getSimilarWebData($websiteUrl, $apiKey);

        foreach($totalVisits as $to)
            echo $to; */

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.similarweb.com/v1/website/".$websiteUrl."/total-traffic-and-engagement/visits?api_key=".$apiKey."&country=us&granularity=monthly",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
            "accept: application/json"
            ],
        ]);
        
        $response = curl_exec($curl);

        echo '<h1>Visitors : '.$response.'</h1>';

    }
    function getSimilarWebData($websiteUrl, $apiKey)
    {
        $endpoint = "https://api.similarweb.com/v1/similar-rank/{$websiteUrl}/rank?api_key={$apiKey}";
        
        $client = new Client();

        try {
            $response = $client->get($endpoint, [
                'headers' => [
                    'User-Agent' => 'MyApp', // Replace with your user agent
                    'Accept' => 'application/json',
                    'Authorization' => "Basic " . base64_encode($apiKey . ":"),
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            // Process and display the data
            $totalVisits = $data;

            return $totalVisits;
        } catch (Exception $e) {
            // Handle API request errors
            return "Error: " . $e->getMessage();
        }
    }

    public function scraping()
    {
        $url = "w3schools.com";

        // Change the path to your Node.js script
        $nodeScriptPath = base_path('scriptsNode/scraping.js');
        // Escape the arguments to prevent command injection
        $escapedSiteURL = escapeshellarg($url);
        // Execute the Node.js script with the arguments
        $result = exec("node {$nodeScriptPath} {$escapedSiteURL}");
        echo $result;
    }
}
