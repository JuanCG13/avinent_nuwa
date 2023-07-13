<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function getMaterials(Request $request)
    {
       
        $data = DB::select("SELECT 
        
        idGrupMaterial, 
        grupMaterial,
                    (SELECT
                          CONCAT('[', 
                            GROUP_CONCAT(
                                JSON_OBJECT(
                                   'idMaterial', idMaterial
                                   ,'material', material
                                   ,'idColorDefecte', idColorDefecte
                                   ,'minDents', minDents
                                   ,'maxDents', maxDents
                                   )
                                ),
                            ']') 
                        FROM tMaterials WHERE idGrupMaterial = tGrupMaterials.idGrupMaterial AND idIdioma = tGrupMaterials.idIdioma) as materials
                    FROM tGrupMaterials WHERE idIdioma='SPA';
             ");
       dd($data);

    }   

    public function getGrupTipusArticle(Request $request)
    {
       
        $data = DB::select("SELECT * FROM tGrupTipusArticle WHERE IdIdioma='SPA'");
        return $data;

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


}
