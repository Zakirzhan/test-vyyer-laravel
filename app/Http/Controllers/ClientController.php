<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ClientController extends Controller
{
    protected $user = [];
    protected $access_token;
    protected $audience;



    public function index(Request $request)
    {
        $this->initializeDatas($request);

        $params = [
            "Page"=> 1,
            "PerPage"=>20
        ];

        $scan_histories = $this->getScanHistories($params);

        return view('dashboard',compact('scan_histories'));
    }

    protected function getScanHistories($params)
    {
        //temporary scanHistories after creating 1 array from 2, we will remove it
        if($tmp_scan_histories = $this->get('scans',$params)){

            $scan_histories = [];

            $IDs = $this->getIds($tmp_scan_histories);
            // переделаем массив так, чтобы было удобно во вьюхе
            $identities = $this->filterIdentities($this->get('identities',["IDs"=> $IDs]));

            foreach ($tmp_scan_histories['Data'] as $k => $tmp_scan_history){
                $scan_histories[$k] = $tmp_scan_history;
                $scan_histories[$k]['identity'] = isset($identities[$tmp_scan_history['IdentityID']]) ? $identities[$tmp_scan_history['IdentityID']] : null;
            }

            //сортировка по дате
            usort($scan_histories, function($a, $b) {
                return $b['CreatedAt'] <=> $a['CreatedAt'];
            });

            return $scan_histories;
        }
    }


    protected function get($method, $data){

        try {
            $client = new Client([
                'base_uri' => $this->audience,
            ]);

            $uri = self::getUri($method);

            $response = $client->request('post', $uri, [
                'headers' => [
                    'content-type'  => 'application/json',
                    'X-User-Id'     => 'Auth0User',
                    'X-Org-Id'      => 'Auth0Org',
                    'Authorization' => 'Bearer '.$this->access_token],
                'json' => $data,
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), true);
            }
        } catch (Exception $ex){
            die( 'Caught exception: '.  $ex->getMessage());
        }
    }
    protected function filterIdentities($array)
    {
        $result = [];

        foreach ($array['Data'] as $k => $item) {
            $result[$item['ID']] = $item;
        }

        return $result;
    }

    protected function getIds($array)
    {
        $IDs = [];

        foreach ($array['Data'] as $key => $item):
            $IDs[] = $item["IdentityID"];
        endforeach;

        return array_unique($IDs);
    }


    protected function initializeDatas(Request $request)
    {
        $this->access_token = $request->session()->get('access_token');
        $this->audience = $request->session()->get('audience');
    }

    protected function getUri($method)
    {
        $methods = ["scans", "identities"];

        $uri = in_array($method,$methods) ? '/api/v2/'.$method.'/get' : null;

        return $uri;
    }
}
