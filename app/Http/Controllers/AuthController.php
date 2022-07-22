<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    protected $user = [];
    protected $access_token;
    protected $audience;

    public function login()
    {
        return view("login");
    }

    public function authenticate(Request $request)
    {
        //in this place will be validator of request datas
        if(!$this->fill_user_data()){
            dd("user data invalid");
        }

        //getting audience from jwt
        $this->audience = (!$request->session()->get("audience")) ? $this->getAudience($request) : $request->session()->get("audience");

        //getting access token
        $this->access_token = (!$request->session()->get("access_token")) ? $this->getAccessToken($request) : $request->session()->get("access_token");

        return redirect('dashboard');
    }

    protected function getAccessToken(Request $request)
    {
        $data = [
            'grant_type' => 'password',
            'client_id' => $this->user['client_id'],
            'username' => $this->user['name'],
            'password' => $this->user['password'],
            'audience' => $this->audience];

        $result = $this->postData($data);

        if(isset($result['access_token'])){
            $access_token = $result['access_token'];
            $request->session()->put('access_token', $access_token);

            return $access_token;
        }
        return null;
    }



    protected function getJWT()
    {
        $data = [
            'grant_type' => 'password',
            'client_id' => $this->user['client_id'],
            'username' => $this->user['name'],
            'password' => $this->user['password']];

        $json = $this->postData($data);

        return isset($json['id_token']) ? $json['id_token'] : null;
    }

    protected function getAudience(Request $request)
    {
        //getting a JWT token
        $jwt = $this->getJWT();
        $decoded_token = $this->jwtDecoder($jwt);

        if(isset($decoded_token['http://custom/api_url'])){
            $audience = $decoded_token['http://custom/api_url'];
            $request->session()->put('audience', $audience);

            return $audience;
        }
        return null;
    }

    protected function jwtDecoder($token){

        $jwt_replace_dictionary = array(
            '-' => '+', '_' => '/'
        );

        try {
            $jwt = explode('.',$token)[1];
            $decoded_jwt = base64_decode(strtr($jwt, $jwt_replace_dictionary));
            $result = json_decode($decoded_jwt, true);
            return $result;
        } catch (Exception $ex){
            die('Caught exception: '.  $ex->getMessage());
        }
    }

    protected function postData($data)
    {
        try {
            $client = new Client([
                'base_uri' => 'https://vyyer.us.auth0.com/',
                'timeout' => 2.0,
            ]);

            $response = $client->request('post', '/oauth/token', [
                'headers' => ['content-type' => 'application/x-www-form-urlencoded'],
                'form_params' => $data,
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody()->getContents(), true);
            }
        } catch (Exception $ex){
            die( 'Caught exception: '.  $ex->getMessage());
        }
    }

    protected function fill_user_data(){
        $this->user['name'] = "interview_new@vyyer.com";
        $this->user['password'] = "5nt9wPAhQkMcukPV";
        $this->user['client_id'] = 'EtHf0UdEIJbwmk6kdicIfNq4lGkpZko0';
        $this->user['grant_type'] = 'password';

        return true;
    }
}
