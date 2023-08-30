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

        $data = DB::select("SELECT * FROM tColors WHERE idIdiomaISO='".$request->lang."' AND actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getColorsMaterial(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tColorsMaterial WHERE idIdiomaISO='".$request->lang."' AND actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getIncisal(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tMMIncisal WHERE idIdiomaISO='".$request->lang."' AND actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getPosicions(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tPosicions WHERE idIdiomaISO='".$request->lang."'");
        return $data;

    }

    public function getSistemaFitxers(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tSistemaFitxers WHERE idIdiomaISO='".$request->lang."' AND actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getZonesPulides(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tZonesPulides WHERE idIdiomaISO='".$request->lang."' AND actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getAngulacions(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tAngulacions WHERE idIdiomaISO='".$request->lang."' AND actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getTipusImplants(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tTipusImplants WHERE actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getMarques(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tMarcaImplants WHERE actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getAnalegs(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tAnalegs WHERE idIdiomaISO='".$request->lang."'");
        return $data;

    }

    public function getMaterials(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tMaterials WHERE idIdiomaISO='".$request->lang."' AND actiu = 1 ORDER BY ordre");
        return $data;
    }

    public function getMaterialsTipusArticle(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tMaterialTipusArticle WHERE actiu = 1 ORDER BY ordre");
        return $data;

    }

    public function getTipusArticle(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tTipusArticle WHERE idIdiomaISO='".$request->lang."' AND actiu = 1");
        return $data;

    }

    public function getTipusArticle2(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tTipusArticle2 WHERE actiu = 1 ORDER BY ordre");
        return $data;

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
              FROM tGrupMaterials WHERE idIdiomaISO='".$request->lang."';
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
                FROM tTipusArticle WHERE idGrupTipusArticle = tGrupTipusArticle.idGrupTipusArticle AND idIdioma = tGrupTipusArticle.idIdioma AND tTipusArticle.actiu = 1),
            '$') AS tipusArticles
              FROM tGrupTipusArticle WHERE idIdiomaISO='".$request->lang."';
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
