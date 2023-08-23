<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    public function getColors(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tColors WHERE IdIdioma='SPA'");
        return $data;

    }

    public function getIncisal(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tMMIncisal WHERE IdIdioma='SPA'");
        return $data;

    }

    public function getPosicions(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tPosicions WHERE IdIdioma='SPA'");
        return $data;

    }

    public function getSistemaFitxers(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tSistemaFitxers WHERE IdIdioma='SPA'");
        return $data;

    }

    public function getZonesPulides(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tZonesPulides WHERE IdIdioma='SPA'");
        return $data;

    }

    public function getAngulacions(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tAngulacions WHERE IdIdioma='SPA'");
        return $data;

    }

    public function getTipusImplants(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tTipusImplants ORDER BY ordre");
        return $data;

    }

    public function getMarques(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tMarcaImplants ORDER BY ordre");
        return $data;

    }

    public function getMaterials(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tMaterials WHERE IdIdioma='SPA'");
        return response()->json($data);
    }

    public function getTipusArticle(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tTipusArticle");
        return json_encode($data);

    }

    public function getGrupsMaterials(Request $request)
    {
       
        $data = DB::select("SELECT 
        idGrupMaterial, 
        grupMaterial,
        JSON_EXTRACT(
            (SELECT JSON_ARRAYAGG(
                            JSON_OBJECT(
                            'idMaterial', idMaterial,
                            'material', material,
                            'idColorDefecte', idColorDefecte,
                            'minDents', minDents,
                            'maxDents', maxDents
                            )
                        )
                FROM tMaterials WHERE idGrupMaterial = tGrupMaterials.idGrupMaterial AND idIdioma = tGrupMaterials.idIdioma),
            '$') AS materials
              FROM tGrupMaterials WHERE idIdioma='SPA';
               ");
       return $this->result_as_json($data);

    }   

    public function getGrupTipusArticle(Request $request)
    {
       
        $data = DB::select("SELECT 
        idGrupTipusArticle, 
        grupTipusArticle,
        JSON_EXTRACT(
            (SELECT JSON_ARRAYAGG(
                            JSON_OBJECT(
                            'idTipusArticle', idTipusArticle,
                            'tipusArticle', tipusArticle
                            )
                        )
                FROM tTipusArticle WHERE idGrupTipusArticle = tGrupTipusArticle.idGrupTipusArticle AND idIdioma = tGrupTipusArticle.idIdioma),
            '$') AS tipusArticles
              FROM tGrupTipusArticle WHERE idIdioma='SPA';
         ");
       return $this->result_as_json($data);


    }

    public function getShippingAddresses(Request $request, User $user)
    {
        if($user->id == Auth::User()->id) {
         $data = DB::Select("SELECT * FROM tAdreces WHERE idClientX3='".$user->idClientX3."'");
         return $data;
        } 

    }

    public function getImpersonationUsers(Request $request)
    {
        
        if (Auth::User()->isAdmin) {
            $data = User::where('id','<>',Auth::User()->id)
            ->get();
         return $data;
        } 
        
        if (Auth::User()->tipusUsuari == 1) {
            $data = User::where('current_team_id', '=', Auth::User()->current_team_id)
            ->Where('id','<>',Auth::User()->id)
            ->get();
         return $data;
        }

        return null;

  

    }

    private function isJson($string) {
        json_decode($string, true);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    
    private function result_as_json($result, $array_columns = null){
        $json = array();
        foreach($result as $res) {
            $item = array();
            if($array_columns != null){
                foreach ( $array_columns as $key) {
                    $item[$key] = isJson($res[$key])?json_decode($res[$key], true):$res[$key];
                }
            }
            else {
                foreach ($res as $key => $value) {
                    $item[$key] = $this->isJson($value)?json_decode($value, true):$value;
                }
            }
            array_push($json, $item);
        }
        return json_encode($json);
    }


}
