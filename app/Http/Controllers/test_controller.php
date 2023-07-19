<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Exception;
use Image;



class test_controller extends Controller
{
    public function getCapureByURL()
    {
        //Google API key 
        $googleApiKey = 'AIzaSyBDUvElk0Qp0_6n7XWRhMFPl3gLW3W_yVA'; 
 
        // Website url 
        $siteURL = "https://www.w3schools.com/"; 
        
        $val_err = ''; 
        if (filter_var($siteURL, FILTER_VALIDATE_URL) === false) { 
            $val_err = 'Please enter a valid website URL.';
        } 
        if(empty($val_err)){ 
            try{ 
                // Call Google PageSpeed Insights API 
                $googlePagespeedData = file_get_contents("https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url=$siteURL&screenshot=true&category=performance&key=$googleApiKey"); 
                
                // Decode json data 
                $googlePagespeedData = json_decode($googlePagespeedData, true); 
                //dd($googlePagespeedData);
                // Retrieve screenshot image data 
                $screenshot_data = $googlePagespeedData['lighthouseResult']['audits']['final-screenshot']['details']['data']; 

                // Get domain name from site URL
                $pieces = parse_url($siteURL); 
                $domain = isset($pieces['host']) ? $pieces['host'] : ''; 
                if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){ 
                    $domain = $regs['domain']; 
                } 

                // Save screenshot as an image 
                list($type, $screenshot_data) = explode(';', $screenshot_data); 
                list(, $screenshot_data)      = explode(',', $screenshot_data); 
                $screenshot_data64 = base64_decode($screenshot_data); 

                $file_name = !empty($domain)?$domain.'.jpeg':'screenshot-'.date("YmdHis").'.jpeg'; 
                Image::make($screenshot_data64)->save(public_path('/images/'.$file_name));

                // Display screenshot image 
                echo '<img src="/images/'.$file_name.'" />';
            }catch(Exception $e){ 
                $statusMsg = $e->getMessage(); 
                echo $statusMsg;
            }
        }else{ 
            $statusMsg = $val_err;
            echo $statusMsg;
        }          
    }

    public function ScreenShot()
    {
        $url = "https://www.w3schools.com/";

        if (filter_var($url, FILTER_VALIDATE_URL) !== false)
        { 
            try{
                // Get domain name from site URL
                $pieces = parse_url($url);
                $domain = isset($pieces['host']) ? $pieces['host'] : ''; 
                if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){ 
                    $domain = $regs['domain']; 
                } 

                $nameImage = $domain.'.jpeg';
                $pathToImage = public_path('/images/'.$nameImage);
                //Browsershot::url($url)->windowSize(1080, 800)->save($pathToImage)->setNodeBinary('/usr/bin/node') ->setNpmBinary('/usr/bin/npm');
                Browsershot::url($url)->save($pathToImage);
            }catch(Exception $e){
                echo $e;
            }
        }
        else
            echo "Please enter a valid website URL.";
 
        /* $screenshot = Browsershot::url($urlToCapture);
        $screenshot -> windowSize(1280, 720);
        //$screenshot -> save("captureWIthBrowsershot.png");
        dd($screenshot); */        
    }

    public function index()
    {
        return view('view');
    }

    public function callNodeFunction()
    {
        /*// Change the path to your Node.js script
        $nodeScriptPath = base_path('/index.js');

        // The parameter you want to pass to the Node.js script
        $parameter = "https://www.w3schools.com/";

        // Execute the Node.js script with the parameter
        $result = exec("node {$nodeScriptPath} {$parameter}");

        // Use $result as needed (it will contain the output from the Node.js script)
        //return 'first start Node JS '.$result;
        echo '<img src="/images/'.$result.'"/>';*/

        /* $URLS = array(
            'www.yabiladi.ma',
            'https://www.alnasnews.com.jo',
            'https://github.com/spatie/browsershot',
            'https://kinsta.com/',
            'https://iplogger.org/main/',
            'https://www.w3schools.com/',
            'spatie.be/docs/'
        ); */
        $URLS = $this->getDataFile();
        //dd($URLS);

        // max time execution request
        ini_set('max_execution_time', 400);
        try{
            foreach ($URLS as $url)
            {
                // Check if the URL contains 'http://' or 'https://'
                if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                    // If not, add 'https://'
                    $url = 'https://' . $url;
                }
                // Check if the URL is valid'
                if (filter_var($url, FILTER_VALIDATE_URL) !== false)
                { 
                    // get domain name
                    $pieces = parse_url($url);
                    $domain = isset($pieces['host']) ? $pieces['host'] : ''; 
                    if(preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)){ 
                        $domain = $regs['domain']; 
                    }

                    // named img by domian name and add extension
                    $nameImage = $domain.'.jpeg';

                    // Change the path to your Node.js script
                    $nodeScriptPath = base_path('/index.js');
                    // Escape the arguments to prevent command injection
                    $escapedSiteURL = escapeshellarg($url);
                    $escapedName = escapeshellarg($nameImage);

                    // Execute the Node.js script with the arguments
                    $result = exec("node {$nodeScriptPath} {$escapedSiteURL} {$escapedName}");
                }
            }
            echo "operation done!";
        }catch(Exception $e){
                echo $e;
        }
    }

    public function getDataFile()
    {
        // Open the file in read mode.
        $file = fopen("file_site/data.txt", "r");
        // Create an empty array to store the data.
        $data = [];
        // Read each line from the file and add it to the array.
        while (!feof($file)) {
            $line = fgets($file);
            $line = str_replace("\r\n", "", $line);
            $data[] = $line;
        }
        // Close the file.
        fclose($file);
        return $data;
    }

    public function checkURL()
    {
        // Example usage
        $urls = [
            'www.yabiladi.ma',
            'https://www.alnasnews.com.jo',
            'https://github.com/spatie/browsershot',
            'https://kinsta.com/',
            'https://iplogger.org/main/',
            'https://www.w3schools.com/',
            'spatie.be/docs/'
        ];

        foreach ($urls as $url) {
            $fixedUrl = $this->checkAndAddProtocol($url);
            echo "Original URL: $url<br/>";
            echo "Fixed URL: $fixedUrl<br/><br/>";
        }
    }
    function checkAndAddProtocol($url)
    {
        // Check if the URL contains 'http://' or 'https://'
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            // If not, add 'https://'
            $url = 'https://' . $url;
        }
        return $url;
    }
}
