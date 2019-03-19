<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Client;
use DB;



class ClientController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;
        $fields = ['idcliente as id', DB::raw('CONCAT(cliente," - ",ruc) as text') , 'contacto', 'telefono', 'correo'];
        $clients = $this->find($search,$fields);

        return $clients;
    }

    public function form(Request $request){

        $search = $request->search;
        $fields = ['idcliente as id', 'cliente as primer_nombre' , 'ncomercial as segundo_nombre', 'direccion as direccion', 'ruc as numero_documento','telefono','celular','correo'];
        $clients = $this->find($search,$fields);

        return view('clients.index',compact('clients'));
    }

    public function list(Request $request){

        $search = $request->search;
        $fields = ['idcliente as id', 'cliente as primer_nombre' , 'ncomercial as segundo_nombre', 'direccion as direccion', 'ruc as numero_documento','telefono','celular','correo'];
        $clients = $this->find($search,$fields);
        return $clients;

    }



    public function find($search, $fields){
        if($search) {
            return Client::where('cliente', 'like', "%$search%")
                ->limit(10)
                ->orWhere('ruc', 'like', "%$search%")
                ->orWhere('dni', 'like', "%$search%")
                ->select($fields)->get();
        }
        return Client::limit(10)->select($fields)->get();
    }


    public function findPeople( Request $request ){

        $numero_documento = $request->numero_documento;
        $size = (int) strlen($numero_documento);
        $type = "";

        switch ($size) {
            case 8:
                $url = "https://api.reniec.cloud/dni/".$numero_documento;
                $type = "N";
                break;
            case 11:
                $url = "https://api.sunat.cloud/ruc/".$numero_documento;
                $type = "J";
                break;
            default:
                $people = [];
                break;
        }

        if(isset($url)){
            $people = $this->convert($this->options($url),$type);
        }
        return response()->json($people);
    }



    public function options($url){
        $options = array(
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => "GET",
        );

        $handle = curl_init();
        curl_setopt_array($handle, ($options));
        $response = curl_exec($handle);
        $people=json_decode($response,true);

        return $people;
    }

    public function convert($people,$type){

        // var_dump($people);
        // var_dump($type);
        if($type == "N"){
         $numero_documento = $people["dni"];
         $primer_nombre = $people["nombres"];
         $segundo_nombre = $people["apellido_paterno"]." ".$people["apellido_materno"];
         $direccion = "";
         $telefono = "";
         $celular = "";
         $correo = "";
        }else{
            if ($type == "J"){
                $numero_documento = $people["ruc"];
                $primer_nombre = $people["razon_social"];
                $segundo_nombre = $people["nombre_comercial"];
                $address = explode("-",$people["domicilio_fiscal"]);
                $length = sizeof($address);
                $direccion = $address[$length - 2]." " .$address[$length - 1];
                $telefono = "";
                $celular = "";
                $correo = "";
            }
        }

        $people_convert = array('numero_documento'=>$numero_documento, 'primer_nombre'=>$primer_nombre, 'segundo_nombre'=>$segundo_nombre, 'direccion' => $direccion, 'telefono' => $telefono, 'celular' => $celular, 'correo' => $correo);

         return $people_convert;
    }

    public function create(Request $request) {


        $this->validate($request, [
            'numero_documento'   => 'required',
            'primer_nombre' => 'required',
            'segundo_nombre' => 'required',
            'direccion' => 'required',
        ]);

        $client = Client::where('ruc', $request->numero_documento)->orWhere('dni', $request->numero_documento)->first();
        // var_dump($client);
        // exit;
        if ($client->ruc == $request->numero_documento){
            return response()->json(['message' => "Ya existe un cliente con el número de documento ingresado "], 400);

        }

        $user = session('user');

        $size = (int) strlen($request->numero_documento);
        $documento = $size == 11 ? "ruc": $size == 8 ? "dni": false;

        if(empty($documento)){
            return response()->json(['message' => "Número de documento no valido"], 400);
        }
        $maxIdClient = DB::select("(select max(`idcliente` * 1) as cli from clientes)")[0]->cli + 1;

        Client::create([
            "idcliente" => $maxIdClient,
            "idvendedor" => $user["idpersonal"],
            "fecha" => date("Y-m-d"),
            "cliente" => $request->primer_nombre,
            "ncomercial" => $request->segundo_nombre,
            "ruc" => $request->numero_documento,
            "direccion" => $request->direccion,
            "telefono" => $request->telefono,
            "celular" => $request->celular,
            "correo" => $request->correo
        ]);


        return response()->json(['message' => "Cliente creado"], 200);
    }



}
