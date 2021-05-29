<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Illuminate\Http\Request;

class kn1 extends Controller
{
    // public function index(){
     
    //     return view('kn1.index');
    // } 


    public function switch_layre($name)
    {
        if ($name=='area_b_demolitions'){  
            return view('area_b_demolitions');    
            
        }elseif($name=='area_b_naturereserve'){
            return view('kn1');
        } 
    }

    public function loadtbledata(){
       
        $q = DB::select("SELECT json_build_object(
                                'type', 'FeatureCollection',
                                'crs',  json_build_object(
                                    'type',      'name', 
                                    'properties', json_build_object(
                                        'name', 'EPSG:4326'  
                                    )
                                ), 
                                'features', json_agg(
                                    json_build_object(
                                        'type',       'Feature',
                                        'id',         fid, -- the GeoJson spec includes an 'id' field, but it is optional, replace {id} with your id field
                                        'geometry',   ST_AsGeoJSON(geom)::json,
                                        'properties', json_build_object(
                                        'fid', fid,
                                            'entity', entity,
                                            'layer', layer,
                                            'color',color ,
                                            'linetype',linetype,
                                            'elevation', elevation,
                                            'linewt',linewt,
                                            'refname',refname,
                                            'angle',angle
                                            
                                        )
                                    )
                                )
                            )
                            FROM (
                            SELECT fid, entity, layer, color, linetype, elevation, linewt, refname, angle,geom
                                FROM public.tbl_area_b_demolitions) as tbl1;");
                                $arr = json_decode(json_encode($q), true);
                                $g=implode("",$arr[0]);
                                $geojson=json_encode($g);

    $q1 = DB::select("SELECT fid, entity, layer, color, linetype, elevation, linewt, refname, angle, geom
    FROM public.tbl_area_b_demolitions;");

                                
    return view('LoadtableData', ['geojson' => $geojson, 'tbldata' => $q1]);
    }

    public  function deletedata($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_b_demolitions
        WHERE fid=$data;");
        // DB::table('public.tbl_area_b_demolitions')->where('fid', $data)->delete();
            return json_encode(true);
    } 
 
    public  function editdata($id){
        $q = DB::select("SELECT fid, entity, layer, color, linetype, elevation, linewt, refname, angle, geom
        FROM public.tbl_area_b_demolitions where fid=$id;");

         return json_encode($q);  
    }
    public  function updatedata($data){
        $a=json_decode($data);

        // if($a->entity==''){
        //     $entity='null';
        // }else{
        //     $entity=$a->entity;
        // }
        // if($a->layer==''){
        //     $layer='null';
        // }else{
        //     $layer=$a->layer;
        // }
        // if($a->color==''){
           
        // }else{
        //     $color=$a->color;
        // }
        // if($a->linetype==''){
        //     $linetype='null';
        // }else{
        //     $linetype=$a->linetype;
        // }
        // if($a->elevation==''){
        //     $elevation='null';
        // }else{
        //     $elevation=$a->elevation;
        // }
        // if($a->linewt==''){
        //     $linewt=null;
        // }else{
        //     $linewt=$a->linewt;
        // }
        // if($a->layer==''){
        //     $layer='null';
        // }else{
        //     $layer=$a->layer;
        // }
        // if($a->layer==''){
        //     $layer='null';
        // }else{
        //     $layer=$a->layer;
        // }
        
$q="UPDATE public.tbl_area_b_demolitions
SET entity='$a->entity', layer='$a->layer', color=$a->color, linetype='$a->linetype', elevation=$a->elevation, linewt=$a->linewt, refname='$a->refname', angle='$a->angle'
WHERE fid=$a->fid;";
        DB::update($q);
// echo $q;
        return json_encode(true);  
    }
    public  function savedata($data){
        $a=json_decode($data);
        $q = DB::select("select max(fid) from public.tbl_area_b_demolitions;");
        $arr = json_decode(json_encode($q), true);
        $fid=implode("",$arr[0])+1;
        // echo $a;
        $q = DB::insert("INSERT INTO public.tbl_area_b_demolitions(
            fid, entity, layer, color, linetype, elevation, linewt, refname, angle)
            VALUES ($fid, '$a->entity', '$a->entity', '$a->layer', $a->color, '$a->linetype', '$a->elevation', $a->linewt, '$a->refname', '$a->angle');");
            return json_encode(true);  
    }
}
