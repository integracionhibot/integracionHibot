<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HibotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = $request;
        $getContent = $request->getContent();
        $array = (array)json_decode($getContent);
        $conversations = $array['conversations'][0];
        $contact = $conversations->contacts[0];
        $phone = $contact->account;
        $fields = $contact->fields;
        $name = '';
        $email = '';
        $countFields = count((array)$fields);        
        /** si existen datos del contacto */
        if ($countFields > 0) {
            foreach ((array)$fields as $key => $value) {
                if ($key == 'name'){
                    $name = $fields->name;
                }

                if ($key == 'email'){
                    $email = $fields->email;
                }  
            }
        }
        /** cuando no se tiene ninguna dato del contacto */
        if ($name == '' && $email == ''){
            $name = 'Interesado - 1';
            $email = 'interesado1@gmail.com';
        }
        $arrayHuspot = array(
            'properties'=>array(
                array( 
                    'property' => 'email',
                    'value' => $email
                ),
                array(
                    'property' => 'firstname',
                    'value' => $name
                ),
                array(
                    'property' => 'phone',
                    'value' => $phone
                )
            )
        );
        $post_json = json_encode($arrayHuspot);
        $endpoint = "https://api.hubapi.com/contacts/v1/contact/?hapikey=d06ffa2b-c3fa-46e2-b966-41aebc111b1d";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json );
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }   
}
