<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;
use Illuminate\Support\Facades\Storage;

use VIPSoft\Unzip\Unzip;

class kn1 extends Controller
{
    // public function index(){

    //     return view('kn1.index');
    // }
    public function __construct()
    {
        $this->middleware('auth');
    }

    public  function registerpage(){
        return view('register_admin');
    } 

    public  function storeadmin(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 
            'min:8',            // must be at least 8 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',  
            'confirmed'],
        ]);
        // return $request->all();
        

        $utb = new User();
        $utb->name = $request->name;
        $utb->email = $request->email;
        $utb->password =Hash::make($request->password);
        $utb->role = 1;
        $utb->save();
        return back()->with('success', 'Admin has been Created succesfuly.');
        // return redirect()->route('/');
    } 


    public function switch_layre($name)
    {
        if ($name=='area_b_demolitions'){
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


                return view('tables.tbl_area_b_demolitions', ['geojson' => $geojson, 'tbldata' => $q1]);

        }
        elseif($name=='area_b_nature_reserve'){
                $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid,
                                'objectid', objectid,
                                'class', class,
                                'shape_leng',shape_leng ,
                                'shape_area',shape_area ))))
                        FROM (
                                SELECT fid, geom, objectid, class, shape_leng, shape_area
                                    FROM public.tbl_area_b_nature_reserve) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, geom, objectid, class, shape_leng, shape_area
                                    FROM public.tbl_area_b_nature_reserve;");


                return view('tables.tbl_area_b_nature_reserve', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='Area_AB_Combined'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                            'properties', json_build_object(
                            'fid', fid,
                            'class', class
                             ))))
                    FROM (
                            SELECT fid, geom, class
                                FROM public.tbl_area_a_and_b_combined) as tbl1;");

                $arr = json_decode(json_encode($q), true);
                $g=implode("",$arr[0]);
                $geojson=json_encode($g);

            $q1 = DB::select("SELECT fid, class, geom
                                FROM public.tbl_area_a_and_b_combined;");


            return view('tables.tbl_area_a_and_b_combined', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='Area_AB_Naturereserve'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',id,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'id', id,
                                'objectid', objectid,
                                'class', class,
                                'shape_leng',shape_leng ,
                                'shape_area',shape_area ))))
                        FROM (
                                SELECT id, geom, objectid, class, shape_leng, shape_area
                                    FROM public.tbl_area_a_area_b_naturereserve) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT id, geom, objectid, class, shape_leng, shape_area
                                    FROM public.tbl_area_a_area_b_naturereserve;");


                return view('tables.tbl_area_a_area_b_naturereserve', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='area_a_poly'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid
                                    ))))
                        FROM (
                                SELECT fid, geom
                                    FROM public.tbl_area_a_poly) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, geom
                                    FROM public.tbl_area_a_poly;");


                return view('tables.tbl_area_a_poly', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='area_b_poly'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid,
                                'areaupdt', areaupdt,
                                'area', area,
                                'shape_leng',shape_leng,
                                'shape_area',shape_area ))))
                        FROM (
                            SELECT fid, geom, areaupdt, area, shape_leng, shape_area
                                FROM public.tbl_area_b_poly LIMIT 10 OFFSET 1) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, geom, areaupdt, area, shape_leng, shape_area
                                        FROM public.tbl_area_b_poly;");

                return view('tables.tbl_area_b_poly', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='area_b_training'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid,
                                'id', id
                                        ))))
                        FROM (
                            SELECT fid, geom, id
                                FROM public.tbl_area_b_training) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, geom, id
                                        FROM public.tbl_area_b_training;");

                return view('tables.tbl_area_b_training', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='demolitions_orders'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid,
                                'objectid', objectid,
                                'id', id
                                        ))))
                        FROM (
                            SELECT fid, geom, objectid, id
                                FROM public.tbl_demolition_orders) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, geom, objectid, id
                                        FROM public.tbl_demolition_orders;");

                return view('tables.tbl_demolition_orders', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='expropriation_orders'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',id,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'id', id,
                                'reason', reason,
                                'title', title,
                                'sign_date', sign_date,
                                'remark', remark,
                                'created_us', created_us,
                                'created_da', created_da,
                                'last_edite', last_edite,
                                'last_edi_1', last_edi_1,
                                'shape_leng', shape_leng,
                                'shape_area', shape_area,
                                'd_reason',d_reason ,
                                'd_district',d_district ))))
                        FROM (
                                SELECT id, reason, title, sign_date, district, remark, created_us, created_da, last_edite, last_edi_1, shape_leng, shape_area, d_reason, d_district, geom
                                    FROM public.tbl_expropriation_orders) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT id, reason, title, sign_date, district, remark, created_us, created_da, last_edite, last_edi_1, shape_leng, shape_area, d_reason, d_district, geom
                                    FROM public.tbl_expropriation_orders;");


                return view('tables.tbl_expropriation_orders', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='expropriation_orders_AB'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',id,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'id', id,
                                'objectid', objectid,
                                'shape_leng',shape_leng ,
                                'shape_area',shape_area ))))
                        FROM (
                                SELECT id, geom, objectid, shape_leng, shape_area
                                    FROM public.tbl_expropriation_orders_ab) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT id, geom, objectid, shape_leng, shape_area
                                    FROM public.tbl_expropriation_orders_ab;");


                return view('tables.tbl_expropriation_orders_ab', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='expropriation_orders_not_AB'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',id,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'id', id
                                        ))))
                        FROM (
                            SELECT geom, id
                                FROM public.tbl_expropriation_orders_not_ab) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT geom, id
                                        FROM public.tbl_expropriation_orders_not_ab;");

                return view('tables.tbl_expropriation_orders_not_ab', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='security_orders'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid,
                                'id', id
                                        ))))
                        FROM (
                            SELECT fid, geom, id
                                FROM public.tbl_security_orders) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, geom, id
                                        FROM public.tbl_security_orders;");

                return view('tables.tbl_security_orders', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='Seizure_AB'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',id,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'id', id
                                        ))))
                        FROM (
                            SELECT geom, id
                                FROM public.tbl_seizure_ab) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT geom, id
                                        FROM public.tbl_seizure_ab;");

                return view('tables.tbl_seizure_ab', ['geojson' => $geojson, 'tbldata' => $q1]);
        }
        elseif($name=='Seizure_All'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid,
                                'from_date', from_date,
                                'to_date', to_date,
                                'ar_num', ar_num,
                                'area', area
                                    ))))
                                     FROM (
                                SELECT fid, from_date, to_date, ar_num, area, geom
                                    FROM public.tbl_seizure_all LIMIT 10 OFFSET 1) as tbl1;");

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, from_date, to_date, ar_num, area, geom
                                    FROM public.tbl_seizure_all;");
                return view('tables.tbl_seizure_all', ['geojson' => $geojson, 'tbldata' => $q1]);

        }
        elseif($name=='Settlements'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid,
                                'objectid', objectid,
                                'id', id,
                                'name_hebrew', name_hebrew,
                                'name_english', name_english,
                                'et_id', et_id,
                                'shape_leng', shape_leng,
                                'shape_area', shape_area,
                                'gis_id', gis_id,
                                'type', type,
                                'area', area,
                                'name_arabic', name_arabic
                                    ))))
                                     FROM (
                                SELECT fid, geom, objectid, id, name_hebrew, name_english, et_id, shape_leng, shape_area, gis_id, type, area, name_arabic
                                    FROM public.tbl_settlements) as tbl1;");
                                    
                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, geom, objectid, id, name_hebrew, name_english, et_id, shape_leng, shape_area, gis_id, type, area, name_arabic
                                    FROM public.tbl_settlements;");
                return view('tables.tbl_settlements', ['geojson' => $geojson, 'tbldata' => $q1]);

        }
        elseif($name=='area_b_violations'){
            $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',gid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'gid', gid,
                                'fid_', fid_,
                                'x', x,
                                'y', y,
                                'picture_id', picture_id,
                                'categoryid', categoryid,
                                'cat_eng', cat_eng,
                                'desc_arb', desc_arb,
                                'desc_eng', desc_eng,
                                'desc_heb', desc_heb,
                                'set_heb', set_heb,
                                'set_arb', set_arb,
                                'set_eng', set_eng,
                                'pal_heb', pal_heb,
                                'pal_arb', pal_arb,
                                'pal_eng', pal_eng,
                                'art_heb', art_heb,
                                'art_eng', art_eng,
                                'art_arb', art_arb,
                                'titt_heb', titt_heb,
                                'titt_eng', titt_eng,
                                'titt_arb', titt_arb,
                                'artheb1', artheb1,
                                'arteng1', arteng1,
                                'artarb1', artarb1,
                                'tittheb1', tittheb1,
                                'titteng1', titteng1,
                                'tittarb1', tittarb1
                                    ))))
                                     FROM (
                                SELECT gid, fid_, x, y, picture_id, categoryid, cat_eng, desc_arb, desc_eng, desc_heb, set_heb, 
                                    set_arb, set_eng, pal_heb, pal_arb, pal_eng, art_heb, art_eng, art_arb, titt_heb, titt_eng, 
                                    titt_arb, artheb1, arteng1, artarb1, tittheb1, titteng1, tittarb1, geom
                                    FROM public.tbl_area_b_violations) as tbl1;");
                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT gid, fid_, x, y, picture_id, categoryid, cat_eng, desc_arb, desc_eng, desc_heb, set_heb, 
                                        set_arb, set_eng, pal_heb, pal_arb, pal_eng, art_heb, art_eng, art_arb, titt_heb, titt_eng, 
                                        titt_arb, artheb1, arteng1, artarb1, tittheb1, titteng1, tittarb1, geom
                                    FROM public.tbl_area_b_violations;");
                return view('tables.tbl_area_b_violations', ['geojson' => $geojson, 'tbldata' => $q1]);

        }

    }

//tbl_area_b_demolitions.....................

    public  function insert_area_b_demolation(Request $request){
        // $object = json_decode(json_encode($data), FALSE);
        // $obj = json_decode(json_encode($data));
        // $a=json_decode($data);
        // $b= urldecode($a->geom);
         $geom=json_decode($request->data['geom']);
         $entity=$request->data['entity'];
         $layer=($request->data['layer']);
         $color=($request->data['color']);
         $linetype=($request->data['linetype']);
         $elevation=($request->data['elevation']);
         $linewt=($request->data['linewt']);
         $refname=($request->data['refname']);
         $angle=($request->data['angle']);

        //  print_r($request->data['geom']);
        // echo gettype($a);
        // echo $entity;
        // exit();

        if(empty(DB::table('tbl_area_b_demolitions')->count())){
            $fid=1;
         }else{
            $q = DB::select("select max(fid) from public.tbl_area_b_demolitions;");
            $arr = json_decode(json_encode($q), true);
            $fid=implode("",$arr[0])+1;
         }
        
        // echo $a;
        $iq="INSERT INTO public.tbl_area_b_demolitions(
            fid, entity, layer, color, linetype, elevation, linewt, refname, angle, geom)
            VALUES ($fid, '$entity', '$layer', $color, '$linetype', $elevation, $linewt, '$refname', $angle, ST_GeomFromGeoJSON('$geom'));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_area_b_demolitions($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_b_demolitions
        WHERE fid=$data;");
        // DB::table('public.tbl_area_b_demolitions')->where('fid', $data)->delete();
            return json_encode(true);
    }

    public  function editbtn_tbl_area_b_demolitions($id){
        $q = DB::select("SELECT *
                        FROM public.tbl_area_b_demolitions where fid=$id;");

         return json_encode($q);
    }
    public  function update_tbl_area_b_demolitions(Request $request){

        $geom=json_decode($request->data['upgeom']);
        //  print_r($request->data);
        // echo gettype($a);
        // echo $geom;
        // if(empty($geom)){
        //     echo "no geom";
        // }else{
        //     echo "geom";
        // }
        // exit();


        $entity=$request->data['entity'];
        $layer=($request->data['layer']);
        $color=($request->data['color']);
        $linetype=($request->data['linetype']);
        $elevation=($request->data['elevation']);
        $linewt=($request->data['linewt']);
        $refname=($request->data['refname']);
        $angle=($request->data['angle']);
        $fid=($request->data['fid']);

        if(empty($geom)){
            $q="UPDATE public.tbl_area_b_demolitions
            SET entity='$entity', layer='$layer', color=$color, linetype='$linetype', elevation=$elevation, linewt=$linewt, refname='$refname', angle='$angle'
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);

        }else{
            $q="UPDATE public.tbl_area_b_demolitions
            SET entity='$entity', layer='$layer', color=$color, linetype='$linetype', elevation=$elevation, linewt=$linewt, refname='$refname', angle='$angle', geom=ST_GeomFromGeoJSON('$geom')
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }

    }


//tbl_area_b_nature_reserve.....................
    public  function insert_tbl_area_b_nature_reserve(Request $request){
        $geom=json_decode($request->data['geom']);

        $objectid=$request->data['objectid'];
        $class=($request->data['class']);
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);


        if(empty(DB::table('tbl_area_b_nature_reserve')->count())){
            $fid=1;
         }else{
            $q = DB::select("select max(fid) from public.tbl_area_b_nature_reserve;");
            $arr = json_decode(json_encode($q), true);
            $fid=implode("",$arr[0])+1;
         }

        $iq="INSERT INTO public.tbl_area_b_nature_reserve(
                        fid, objectid, class, shape_leng, shape_area, geom)
            VALUES ($fid, $objectid, '$class', $shape_leng, $shape_area, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_area_b_nature_reserve($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_b_nature_reserve
        WHERE fid=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_area_b_nature_reserve($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_area_b_nature_reserve where fid=$id;");
         return json_encode($q);
    }

    public  function update_tbl_area_b_nature_reserve(Request $request){
        // return $request->all();
        $geom=json_decode($request->data['upgeom']);

        $objectid=$request->data['objectid'];
        $class=($request->data['class']);
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);
        $fid=($request->data['fid']);

        if(empty($geom)){
            $q="UPDATE public.tbl_area_b_nature_reserve
            SET objectid=$objectid, class='$class', shape_leng=$shape_leng, shape_area=$shape_area
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_area_b_nature_reserve
            SET objectid=$objectid, class='$class', shape_leng=$shape_leng, shape_area=$shape_area, geom=ST_GeomFromGeoJSON('$geom')
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }


//tbl_Area_AB_Combined.....................
    public  function insert_tbl_area_a_and_b_combined(Request $request){
        $geom=json_decode($request->data['geom']);

        $class=$request->data['class'];
        // echo $class;
        // exit();

        if(empty(DB::table('tbl_area_a_and_b_combined')->count())){
            $fid=1;
         }else{
            $q = DB::select("select max(fid) from public.tbl_area_a_and_b_combined;");
            $arr = json_decode(json_encode($q), true);
            $fid=implode("",$arr[0])+1;
         }

        $iq="INSERT INTO public.tbl_area_a_and_b_combined(
                        fid, class, geom)
            VALUES ($fid, '$class', ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_area_a_and_b_combined($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_a_and_b_combined
        WHERE fid=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_area_a_and_b_combined($id){
        // echo "editbtn_tbl_area_a_and_b_combined";
        // //  print_r($request->data);
        // exit();
        $eq="SELECT * FROM public.tbl_area_a_and_b_combined where fid=$id;";
        // echo $eq;
        // exit();
        $q = DB::select($eq);
        return json_encode($q);
    }

    public  function update_tbl_area_a_and_b_combined(Request $request){
        // echo "update_tbl_area_a_and_b_combined";
        //  print_r($request->data);
        // exit();
        $geom=json_decode($request->data['upgeom']);

        $class=$request->data['class'];
        $fid=($request->data['fid']);


        if(empty($geom)){
            $q="UPDATE public.tbl_area_a_and_b_combined
            SET class='$class'
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_area_a_and_b_combined
            SET class='$class', geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }

    public  function zoombtn_tbl_area_a_and_b_combined($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_area_a_and_b_combined where fid=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_area_a_area_b_naturereserve($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_area_a_area_b_naturereserve where id=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_area_a_poly($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_area_a_area_b_naturereserve where fid=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_area_b_nature_reserve($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_area_b_nature_reserve where fid=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_area_b_poly($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_area_b_poly where fid=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_area_b_violations($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_area_b_violations where fid=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_expropriation_orders_ab($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_expropriation_orders_ab where id=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_expropriation_orders_not_ab($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_expropriation_orders_not_ab where id=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_expropriation_orders($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_expropriation_orders where id=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_seizure_ab($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_seizure_ab where id=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_seizure_all($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_seizure_all where fid=$id;");          
         return json_encode($q);
    }
    public  function zoombtn_tbl_settlements($id){
        $q = DB::select("SELECT st_x(st_centroid(geom))as x,st_y(st_centroid(geom))as y from public.tbl_settlements where fid=$id;");          
         return json_encode($q);
    }

//tbl_area_a_area_b_naturereserve.....................
    public  function insert_tbl_area_a_area_b_naturereserve(Request $request){
        $geom=json_decode($request->data['geom']);

        $objectid=$request->data['objectid'];
        $class=($request->data['class']);
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);

     
        if(empty(DB::table('tbl_area_a_area_b_naturereserve')->count())){
            $id=1;
         }else{
            $q = DB::select("select max(id) from public.tbl_area_a_area_b_naturereserve;");
            $arr = json_decode(json_encode($q), true);
            $id=implode("",$arr[0])+1;
         }

        $iq="INSERT INTO public.tbl_area_a_area_b_naturereserve(
                        id, objectid, class, shape_leng, shape_area, geom)
            VALUES ($id, NULLIF('$objectid','')::integer, '$class', NULLIF('$shape_leng','')::integer, NULLIF('$shape_area','')::integer, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_area_a_area_b_naturereserve($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_a_area_b_naturereserve
        WHERE id=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_area_a_area_b_naturereserve($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_area_a_area_b_naturereserve where id=$id;");
         return json_encode($q);
    }

    public  function update_tbl_area_a_area_b_naturereserve(Request $request){
        // return $request->all();

        $geom=json_decode($request->data['upgeom']);

        $objectid=$request->data['objectid'];
        $class=($request->data['class']);
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);
        $id=($request->data['id']);

        if(empty($geom)){
            $q="UPDATE public.tbl_area_a_area_b_naturereserve
            SET objectid=NULLIF('$objectid','')::integer, class='$class', shape_leng=NULLIF('$shape_leng','')::integer, shape_area=NULLIF('$shape_area','')::integer
            WHERE id=$id;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_area_a_area_b_naturereserve
            SET objectid=NULLIF('$objectid','')::integer, class='$class', shape_leng=NULLIF('$shape_leng','')::integer, shape_area=NULLIF('$shape_area','')::integer, geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
            WHERE id=$id;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }

//tbl_area_a_poly.....................
    public  function insert_tbl_area_a_poly(Request $request){
        $geom=json_decode($request->data['geom']);

        if(empty(DB::table('tbl_area_a_poly')->count())){
            $fid=1;
         }else{
            $q = DB::select("select max(fid) from public.tbl_area_a_poly;");
            $arr = json_decode(json_encode($q), true);
            $fid=implode("",$arr[0])+1;
         }

        $iq="INSERT INTO public.tbl_area_a_poly(
                        fid, geom)
            VALUES ($fid, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_area_a_poly($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_a_poly
        WHERE fid=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_area_a_poly($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_area_a_poly where fid=$id;");
        return json_encode($q);
    }

    public  function update_tbl_area_a_poly(Request $request){
        $geom=json_decode($request->data['upgeom']);

        $fid=($request->data['fid']);

        if(empty($geom)){
            $q="UPDATE public.tbl_area_a_poly
            WHERE fid=$fid;";
            DB::update($q);
            // // echo $q;
            // // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_area_a_poly
            SET geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }


//tbl_area_b_poly.....................
    public  function insert_tbl_area_b_poly(Request $request){
        $geom=json_decode($request->data['geom']);

        $areaupdt=$request->data['areaupdt'];
        $area=($request->data['area']);
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);

        if(empty(DB::table('tbl_area_b_poly')->count())){
            $fid=1;
         }else{
            $q = DB::select("select max(fid) from public.tbl_area_b_poly;");
            $arr = json_decode(json_encode($q), true);
            $fid=implode("",$arr[0])+1;
         }

        $iq="INSERT INTO public.tbl_area_b_poly(
                        fid, areaupdt, area, shape_leng, shape_area, geom)
            VALUES ($fid, NULLIF('$areaupdt','')::integer, NULLIF('$area','')::integer, NULLIF('$shape_leng','')::integer, NULLIF('$shape_area','')::integer, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_area_b_poly($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_b_poly
        WHERE fid=$data;");
            return json_encode(true);
    }

    public  function pageno_tbl_area_b_poly($pageno){
        $offset=$pageno;
        $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                                'properties', json_build_object(
                                'fid', fid,
                                'areaupdt', areaupdt,
                                'area', area,
                                'shape_leng',shape_leng,
                                'shape_area',shape_area ))))
                        FROM (
                            SELECT fid, geom, areaupdt, area, shape_leng, shape_area
                                FROM public.tbl_area_b_poly LIMIT 10 OFFSET $offset) as tbl1;");

            $arr = json_decode(json_encode($q), true);
            $g=implode("",$arr[0]);
            $geojson=json_encode($g);
            return $geojson;
            exit();
    }
    public  function editbtn_tbl_area_b_poly($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_area_b_poly where fid=$id;");
        return json_encode($q);
    }

    public  function update_tbl_area_b_poly(Request $request){
        // return $request->all();
        $geom=json_decode($request->data['upgeom']);

        $areaupdt=$request->data['areaupdt'];
        $area=($request->data['area']);
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);
        $fid=($request->data['fid']);

        if(empty($geom)){
            $q="UPDATE public.tbl_area_b_poly
            SET areaupdt=NULLIF('$areaupdt','')::integer, area=NULLIF('$area','')::integer, shape_leng=NULLIF('$shape_area','')::integer, shape_area=NULLIF('$shape_area','')::integer
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_area_b_poly
            SET areaupdt=NULLIF('$areaupdt','')::integer, area=NULLIF('$area','')::integer, shape_leng=NULLIF('$shape_area','')::integer, shape_area=NULLIF('$shape_area','')::integer, geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }

//tbl_area_b_training.....................
    public  function insert_tbl_area_b_training(Request $request){
        $geom=json_decode($request->data['geom']);

        $id=$request->data['id'];

        if(empty(DB::table('tbl_area_b_training')->count())){
            $fid=1;
         }else{
            $q = DB::select("select max(fid) from public.tbl_area_b_training;");
            $arr = json_decode(json_encode($q), true);
            $fid=implode("",$arr[0])+1;
         }
        

        $iq="INSERT INTO public.tbl_area_b_training(
                        fid, id, geom)
            VALUES ($fid, NULLIF('$id','')::integer, ST_GeomFromGeoJSON('$geom'));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_area_b_training($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_b_training
        WHERE fid=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_area_b_training($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_area_b_training where fid=$id;");
        return json_encode($q);
    }

    public  function update_tbl_area_b_training(Request $request){
        $geom=json_decode($request->data['upgeom']);

        $id=$request->data['id'];
        $fid=($request->data['fid']);

        if(empty($geom)){
            $q="UPDATE public.tbl_area_b_training
            SET id=NULLIF('$id','')::integer
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_area_b_training
            SET id=NULLIF('$id','')::integer, geom=ST_GeomFromGeoJSON('$geom')
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }
//tbl_demolition_orders.....................
public  function insert_tbl_demolition_orders(Request $request){
    $geom=json_decode($request->data['geom']);

    $objectid=$request->data['objectid'];
    $id=($request->data['id']);

    
    if(empty(DB::table('tbl_demolition_orders')->count())){
        $fid=1;
     }else{
        $q = DB::select("select max(fid) from public.tbl_demolition_orders;");
        $arr = json_decode(json_encode($q), true);
        $fid=implode("",$arr[0])+1;
     }

    $iq="INSERT INTO public.tbl_demolition_orders(
                    fid, objectid, id, geom)
        VALUES ($fid, NULLIF('$objectid','')::integer, NULLIF('$id','')::integer, ST_GeomFromGeoJSON('$geom'));";
    // echo $iq;
    // exit();
    $q = DB::insert($iq);
        return json_encode(true);
}

public  function deletebtn_tbl_demolition_orders($data){
    // echo $data;
    // exit();
    DB::delete("DELETE FROM public.tbl_demolition_orders
    WHERE fid=$data;");
        return json_encode(true);
}

public  function editbtn_tbl_demolition_orders($id){
    $q = DB::select("SELECT *
                        FROM public.tbl_demolition_orders where fid=$id;");
     return json_encode($q);
}

public  function update_tbl_demolition_orders(Request $request){
    // return $request->all();
    $geom=json_decode($request->data['upgeom']);

    $objectid=$request->data['objectid'];
    $id=($request->data['id']);
    $fid=($request->data['fid']);

    if(empty($geom)){
        $q="UPDATE public.tbl_demolition_orders
        SET objectid=NULLIF('$objectid','')::integer, id=NULLIF('$id','')::integer
        WHERE fid=$fid;";
        DB::update($q);
        // echo $q;
        // exit();
        return json_encode(true);
    }else{
        $q="UPDATE public.tbl_demolition_orders
        SET objectid=NULLIF('$objectid','')::integer, id=NULLIF('$id','')::integer, geom=ST_GeomFromGeoJSON('$geom')
        WHERE fid=$fid;";
        DB::update($q);
        // echo $q;
        // exit();
        return json_encode(true);
    }
}



//tbl_expropriation_orders.....................
public  function insert_tbl_expropriation_orders(Request $request){
    $geom=json_decode($request->data['geom']);
    
    $reason=$request->data['reason'];
    $title=($request->data['title']);
    $sign_date=($request->data['sign_date']);
    $district=($request->data['district']);
    $remark=($request->data['remark']);
    $created_us=($request->data['created_us']);
    $created_da=($request->data['created_da']);
    $last_edite=($request->data['last_edite']);
    $last_edi_1=($request->data['last_edi_1']);
    $shape_leng=($request->data['shape_leng']);
    $shape_area=($request->data['shape_area']);
    $d_reason=($request->data['d_reason']);
    $d_district=($request->data['d_district']);

    if(empty(DB::table('tbl_expropriation_orders')->count())){
        $id=1;
     }else{
        $q = DB::select("select max(id) from public.tbl_expropriation_orders;");
        $arr = json_decode(json_encode($q), true);
        $id=implode("",$arr[0])+1;
     }

    $iq="INSERT INTO public.tbl_expropriation_orders(
                    id, reason, title, sign_date, district, 
    remark, created_us, created_da, last_edite, last_edi_1, shape_leng, shape_area, d_reason, d_district, geom)
        VALUES ($id, NULLIF('$reason','')::integer, '$title', '$sign_date', NULLIF('$district','')::integer, '$remark', '$created_us', '$created_da', '$last_edite', '$last_edi_1', NULLIF('$shape_leng','')::integer, NULLIF('$shape_area','')::integer, NULLIF('$d_reason','')::integer, NULLIF('$d_district','')::integer, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
    // echo $iq;
    // exit();
    $q = DB::insert($iq);
        return json_encode(true);
}

public  function deletebtn_tbl_expropriation_orders($data){
    // echo $data;
    // exit();
    DB::delete("DELETE FROM public.tbl_expropriation_orders
    WHERE id=$data;");
        return json_encode(true);
}

public  function editbtn_tbl_expropriation_orders($id){
    $q = DB::select("SELECT *
                        FROM public.tbl_expropriation_orders where id=$id;");
    return json_encode($q);
}

public  function update_tbl_expropriation_orders(Request $request){
    // return $request->all();
    $geom=json_decode($request->data['upgeom']);

     // Function to remove the spacial 
     function RemoveSpecialChar($str) {
        // Using str_replace() function 
        // to replace the word 
        $res = str_replace( array( '\'', '"',
        ',' , ';', '<', '>' ), ' ', $str);
        // Returning the result 
        return $res;
    }

    $reason=$request->data['reason'];
    $title=RemoveSpecialChar($request->data['title']);
    $sign_date=($request->data['sign_date']);
    $district=($request->data['district']);
    $remark=RemoveSpecialChar($request->data['remark']);
    $created_us=($request->data['created_us']);
    $created_da=($request->data['created_da']);
    $last_edite=($request->data['last_edite']);
    $last_edi_1=($request->data['last_edi_1']);
    $shape_leng=($request->data['shape_leng']);
    $shape_area=($request->data['shape_area']);
    $d_reason=RemoveSpecialChar($request->data['d_reason']);
    $d_district=RemoveSpecialChar($request->data['d_district']);
    $id=($request->data['id']);

    if(empty($geom)){
        $q="UPDATE public.tbl_expropriation_orders
        SET reason=NULLIF('$reason','')::integer, title='$title', sign_date='$sign_date', district=NULLIF('$district','')::integer, remark='$remark', created_us='$created_us', created_da='$created_da', last_edite='$last_edite', last_edi_1='$last_edi_1', 
            shape_leng=NULLIF('$shape_leng','')::integer, shape_area=NULLIF('$shape_area','')::integer, d_reason=NULLIF('$d_reason','')::integer, d_district=NULLIF('$d_district','')::integer
        WHERE id=$id;";
        DB::update($q);
        // echo $q;
        // exit();
        return json_encode(true);
    }else{
        $q="UPDATE public.tbl_expropriation_orders
        SET reason=NULLIF('$reason','')::integer, title='$title', sign_date='$sign_date', district=NULLIF('$district','')::integer, remark='$remark', created_us='$created_us', created_da='$created_da', last_edite='$last_edite', last_edi_1='$last_edi_1', 
            shape_leng=NULLIF('$shape_leng','')::integer, shape_area=NULLIF('$shape_area','')::integer, d_reason=NULLIF('$d_reason','')::integer, d_district=NULLIF('$d_district','')::integer, geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
        WHERE id=$id;";
        DB::update($q);
        // echo $q;
        // exit();
        return json_encode(true);
    }
}



//tbl_expropriation_orders_ab.....................
    public  function insert_tbl_expropriation_orders_ab(Request $request){
        $geom=json_decode($request->data['geom']);

        $objectid=$request->data['objectid'];
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);

    
        if(empty(DB::table('tbl_expropriation_orders_ab')->count())){
            $id=1;
        }else{
            $q = DB::select("select max(id) from public.tbl_expropriation_orders_ab;");
            $arr = json_decode(json_encode($q), true);
            $id=implode("",$arr[0])+1;
        }

        $iq="INSERT INTO public.tbl_expropriation_orders_ab(
                        id, objectid, shape_leng, shape_area, geom)
            VALUES ($id, NULLIF('$objectid','')::integer, NULLIF('$shape_leng','')::integer, NULLIF('$shape_area','')::integer, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_expropriation_orders_ab($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_expropriation_orders_ab
        WHERE id=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_expropriation_orders_ab($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_expropriation_orders_ab where id=$id;");
        return json_encode($q);
    }

    public  function update_tbl_expropriation_orders_ab(Request $request){
        // return $request->all();
        $geom=json_decode($request->data['upgeom']);

        $objectid=$request->data['objectid'];
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);
        $id=($request->data['id']);

        if(empty($geom)){
            $q="UPDATE public.tbl_expropriation_orders_ab
            SET objectid=NULLIF('$objectid','')::integer, shape_leng=NULLIF('$shape_area','')::integer, shape_area=NULLIF('$shape_area','')::integer
            WHERE id=$id;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_expropriation_orders_ab
            SET objectid=$objectid, shape_leng=$shape_leng, shape_area=$shape_area, geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
            WHERE id=$id;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }


//tbl_expropriation_orders_not_ab.....................
    public  function insert_tbl_expropriation_orders_not_ab(Request $request){
        $geom=json_decode($request->data['geom']);


        if(empty(DB::table('tbl_expropriation_orders_not_ab')->count())){
            $id=1;
        }else{
            $q = DB::select("select max(id) from public.tbl_expropriation_orders_not_ab;");
            $arr = json_decode(json_encode($q), true);
            $id=implode("",$arr[0])+1;
        }

        $iq="INSERT INTO public.tbl_expropriation_orders_not_ab(
                        id, geom)
            VALUES ($id, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_expropriation_orders_not_ab($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_expropriation_orders_not_ab
        WHERE id=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_expropriation_orders_not_ab($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_expropriation_orders_not_ab where id=$id;");
        return json_encode($q);
    }

    public  function update_tbl_expropriation_orders_not_ab(Request $request){
        // return $request->all();
        $geom=json_decode($request->data['upgeom']);

        $id=($request->data['id']);

        if(empty($geom)){
            $q="UPDATE public.tbl_expropriation_orders_not_ab
            SET objectid=$objectid, shape_leng=$shape_leng, shape_area=$shape_area
            WHERE id=$id;";
            DB::update($q);
            // // echo $q;
            // // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_expropriation_orders_not_ab
            SET geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
            WHERE id=$id;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }



//tbl_security_orders.....................
    public  function insert_tbl_security_orders(Request $request){
        $geom=json_decode($request->data['geom']);

        $id=$request->data['id'];


        if(empty(DB::table('tbl_security_orders')->count())){
            $fid=1;
        }else{
            $q = DB::select("select max(fid) from public.tbl_security_orders;");
            $arr = json_decode(json_encode($q), true);
            $fid=implode("",$arr[0])+1;
        }

        $iq="INSERT INTO public.tbl_security_orders(
                        fid, id, geom)
            VALUES ($fid, NULLIF('$id','')::integer, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_security_orders($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_security_orders
        WHERE fid=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_security_orders($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_security_orders where fid=$id;");
        return json_encode($q);
    }

    public  function update_tbl_security_orders(Request $request){
        // return $request->all();
        $geom=json_decode($request->data['upgeom']);

        $id=$request->data['id'];
        $fid=($request->data['fid']);

        if(empty($geom)){
            $q="UPDATE public.tbl_security_orders
            SET id=NULLIF('$id','')::integer
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_security_orders
            SET id=NULLIF('$id','')::integer, geom=ST_GeomFromGeoJSON('$geom')
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }





//tbl_seizure_ab.....................
    public  function insert_tbl_seizure_ab(Request $request){
        $geom=json_decode($request->data['geom']);


        if(empty(DB::table('tbl_seizure_ab')->count())){
            $id=1;
        }else{
            $q = DB::select("select max(id) from public.tbl_seizure_ab;");
            $arr = json_decode(json_encode($q), true);
            $id=implode("",$arr[0])+1;
        }

        $iq="INSERT INTO public.tbl_seizure_ab(
                        id, geom)
            VALUES ($id, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_seizure_ab($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_seizure_ab
        WHERE id=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_seizure_ab($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_seizure_ab where id=$id;");
        return json_encode($q);
    }

    public  function update_tbl_seizure_ab(Request $request){
        // return $request->all();
        $geom=json_decode($request->data['upgeom']);

        $id=($request->data['id']);

        if(empty($geom)){
            $q="UPDATE public.tbl_seizure_ab
            SET objectid=$objectid, shape_leng=$shape_leng, shape_area=$shape_area
            WHERE id=$id;";
            DB::update($q);
            // // echo $q;
            // // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_seizure_ab
            SET geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
            WHERE id=$id;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }

    
//tbl_seizure_all.....................
public  function insert_tbl_seizure_all(Request $request){
    $geom=json_decode($request->data['geom']);

    $from_date=$request->data['from_date'];
    $to_date=($request->data['to_date']);
    $ar_num=($request->data['ar_num']);
    $area=($request->data['area']);

    if(empty(DB::table('tbl_seizure_all')->count())){
        $fid=1;
    }else{
        $q = DB::select("select max(fid) from public.tbl_seizure_all;");
        $arr = json_decode(json_encode($q), true);
        $fid=implode("",$arr[0])+1;
    }

    $iq="INSERT INTO public.tbl_seizure_all(
                    fid, from_date, to_date, ar_num, area, geom)
        VALUES ($fid, '$from_date', '$to_date', '$ar_num', NULLIF('$area','')::integer, ST_Multi(ST_GeomFromGeoJSON('$geom')));";
    // echo $iq;
    // exit();
    $q = DB::insert($iq);
        return json_encode(true);
}

public  function deletebtn_tbl_seizure_all($data){
    // echo $data;
    // exit();
    DB::delete("DELETE FROM public.tbl_seizure_all
    WHERE fid=$data;");
        return json_encode(true);
}

public  function editbtn_tbl_seizure_all($id){
    $q = DB::select("SELECT *
                        FROM public.tbl_seizure_all where fid=$id;");
    return json_encode($q);
}

public  function update_tbl_seizure_all(Request $request){
    // return $request->all();
    $geom=json_decode($request->data['upgeom']);

    $from_date=$request->data['from_date'];
    $to_date=($request->data['to_date']);
    $ar_num=($request->data['ar_num']);
    $area=($request->data['area']);
    $fid=($request->data['fid']);

    if(empty($geom)){
        $q="UPDATE public.tbl_seizure_all
        SET from_date='$from_date', to_date='$to_date', ar_num='$ar_num', area=NULLIF('$area','')::integer
        WHERE fid=$fid;";
        DB::update($q);
        // echo $q;
        // exit();
        return json_encode(true);
    }else{
        $q="UPDATE public.tbl_seizure_all
        SET from_date='$from_date', to_date='$to_date', ar_num='$ar_num', area=NULLIF('$area','')::integer, geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
        WHERE fid=$fid;";
        DB::update($q);
        // echo $q;
        // exit();
        return json_encode(true);
    }
}
public  function pageno_tbl_seizure_all($pageno){
    $offset=$pageno;
    $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',fid,'geometry',ST_AsGeoJSON(geom)::json,
                'properties', json_build_object(
                'fid', fid,
                'from_date', from_date,
                'to_date', to_date,
                'ar_num', ar_num,
                'area', area
                    ))))
                    FROM (
                SELECT fid, from_date, to_date, ar_num, area, geom
                FROM public.tbl_seizure_all LIMIT 10 OFFSET $offset) as tbl1;");

        $arr = json_decode(json_encode($q), true);
        $g=implode("",$arr[0]);
        $geojson=json_encode($g);
        return $geojson;
        exit();
}


//tbl_settlements.....................
    public  function insert_tbl_settlements(Request $request){
        $geom=json_decode($request->data['geom']);
        
        $objectid=$request->data['objectid'];
        $id=($request->data['id']);
        $name_hebrew=($request->data['name_hebrew']);
        $name_english=($request->data['name_english']);
        $et_id=($request->data['et_id']);
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);
        $gis_id=($request->data['gis_id']);
        $type=($request->data['type']);
        $area=($request->data['area']);
        $name_arabic=($request->data['name_arabic']);

        if(empty(DB::table('tbl_settlements')->count())){
            $fid=1;
        }else{
            $q = DB::select("select max(fid) from public.tbl_settlements;");
            $arr = json_decode(json_encode($q), true);
            $fid=implode("",$arr[0])+1;
        }

        $iq="INSERT INTO public.tbl_settlements(
                        fid, objectid, id, name_hebrew, name_english, et_id, shape_leng, shape_area, gis_id, type, area, name_arabic, geom)
            VALUES ($fid, NULLIF('$objectid','')::integer, NULLIF('$id','')::integer, '$name_hebrew', '$name_english', NULLIF('$et_id','')::integer, NULLIF('$shape_leng','')::integer, NULLIF('$shape_area','')::integer, NULLIF('$gis_id','')::integer, '$type', NULLIF('$area','')::integer, '$name_arabic', ST_Multi(ST_GeomFromGeoJSON('$geom')));";
        // echo $iq;
        // exit();
        $q = DB::insert($iq);
            return json_encode(true);
    }

    public  function deletebtn_tbl_settlements($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_settlements
        WHERE fid=$data;");
            return json_encode(true);
    }

    public  function editbtn_tbl_settlements($fid){
        $q = DB::select("SELECT *
                            FROM public.tbl_settlements where fid=$fid;");
        return json_encode($q);
    }

    public  function update_tbl_settlements(Request $request){
        // return $request->all();

        // Function to remove the spacial 
        function RemoveSpecialChar($str) {
            // Using str_replace() function 
            // to replace the word 
            $res = str_replace( array( '\'', '"',
            ',' , ';', '<', '>' ), ' ', $str);
            // Returning the result 
            return $res;
        }

        $geom=json_decode($request->data['upgeom']);

        $objectid=$request->data['objectid'];
        $id=($request->data['id']);
        $name_hebrew=RemoveSpecialChar($request->data['name_hebrew']);
        $name_english=($request->data['name_english']);
        $et_id=($request->data['et_id']);
        $shape_leng=($request->data['shape_leng']);
        $shape_area=($request->data['shape_area']);
        $gis_id=($request->data['gis_id']);
        $type=($request->data['type']);
        $area=($request->data['area']);
        $name_arabic=($request->data['name_arabic']);
        $fid=($request->data['fid']);


        if(empty($geom)){
            $q="UPDATE public.tbl_settlements
            SET objectid=NULLIF('$objectid','')::integer, id=NULLIF('$id','')::integer, name_hebrew='$name_hebrew', name_english='$name_english', et_id=NULLIF('$et_id','')::integer, shape_leng=NULLIF('$shape_leng','')::integer, shape_area=NULLIF('$shape_area','')::integer, gis_id=NULLIF('$gis_id','')::integer, type='$type', area=NULLIF('$area','')::integer, name_arabic='$name_arabic'
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }else{
            $q="UPDATE public.tbl_settlements
             SET objectid=NULLIF('$objectid','')::integer, id=NULLIF('$id','')::integer, name_hebrew='$name_hebrew', name_english='$name_english', et_id=NULLIF('$et_id','')::integer, shape_leng=NULLIF('$shape_leng','')::integer, shape_area=NULLIF('$shape_area','')::integer, gis_id=NULLIF('$gis_id','')::integer, type='$type', area=NULLIF('$area','')::integer, name_arabic='$name_arabic', geom=ST_Multi(ST_GeomFromGeoJSON('$geom'))
            WHERE fid=$fid;";
            DB::update($q);
            // echo $q;
            // exit();
            return json_encode(true);
        }
    }




//tbl_area_b_violations.....................
public  function insert_tbl_area_b_violations(Request $request){
//   return $request->all();
//     exit();
    $picture_id=$request['picture_id'];
    

    if(empty($picture_id)){
        $pq = DB::select("select max(picture_id) from public.tbl_area_b_violations;");
        $arr = json_decode(json_encode($pq), true);
        $picture_id=implode("",$arr[0])+1;
    }

    $ins_uploadFile_arr=$request['ins_uploadFile'];
    for($i=0; $i<count($ins_uploadFile_arr); $i++){
        $fileName = $ins_uploadFile_arr[$i]->getClientOriginalName(); 
        
        $url="/var/www/html/kn/assets/img/SettlerViolation_Pictures/$picture_id/";
        if(!$url){
            mkdir("/var/www/html/kn/assets/img/SettlerViolation_Pictures/$picture_id/", 0755);
        }
        $filePath = $ins_uploadFile_arr[$i]->move($url, $fileName);
    }


    $geom=json_decode($request['geom']);

    $geom1 = json_decode($geom, true);
    $x=$geom1['coordinates'][0];
    $y=$geom1['coordinates'][1];

    $fid_=$request['fid_'];
    $categoryid=$request['categoryid'];
    $cat_eng=$request['cat_eng'];
    $desc_arb=($request['desc_arb']);
    $desc_eng=($request['desc_eng']);
    $desc_heb=($request['desc_heb']);
    $set_heb=($request['set_heb']);
    $set_arb=($request['set_arb']);
    $set_eng=($request['set_eng']);
    $pal_heb=($request['pal_heb']);
    $pal_arb=($request['pal_arb']);
    $pal_eng=($request['pal_eng']);
    $art_heb=($request['art_heb']);
    $art_eng=($request['art_eng']);
    $art_arb=($request['art_arb']);
    $titt_heb=($request['titt_heb']);
    $titt_eng=($request['titt_eng']);
    $titt_arb=($request['titt_arb']);
    $artheb1=($request['artheb1']);
    $arteng1=($request['arteng1']);
    $artarb1=($request['artarb1']);
    $tittheb1=($request['tittheb1']);
    $titteng1=($request['titteng1']);
    $tittarb1=($request['tittarb1']);

    // if(empty($fid_)){
    //     $fid_=0;
    // }
    // if(empty($picture_id)){
    //     $picture_id=0;
    // }
    // if(empty($categoryid)){
    //     $categoryid=0;
    // }

    if(empty(DB::table('tbl_area_b_violations')->count())){
        $gid=1;
    }else{
        $q = DB::select("select max(gid) from public.tbl_area_b_violations;");
        $arr = json_decode(json_encode($q), true);
        $gid=implode("",$arr[0])+1;
    }

    $iq="INSERT INTO public.tbl_area_b_violations(
                    gid, fid_, x, y, picture_id, categoryid, cat_eng, desc_arb, desc_eng, desc_heb, set_heb, set_arb, set_eng, pal_heb, pal_arb, pal_eng, art_heb, art_eng, art_arb, titt_heb, titt_eng, titt_arb, artheb1, arteng1, artarb1, tittheb1, titteng1, tittarb1, geom)
        VALUES ($gid, NULLIF('$fid_','')::integer, $x, $y, NULLIF('$picture_id','')::integer, NULLIF('$categoryid','')::integer, '$cat_eng', '$desc_arb', '$desc_eng', '$desc_heb', '$set_heb', '$set_arb', '$set_eng', '$pal_heb', '$pal_arb', '$pal_eng', '$art_heb', '$art_eng', '$art_arb', '$titt_heb', '$titt_eng', '$titt_arb', '$artheb1', '$arteng1', '$artarb1', '$tittheb1', '$titteng1', '$tittarb1', ST_GeomFromGeoJSON('$geom'));";
    //    echo $iq;
    //    exit();
   $q = DB::insert($iq);
        return json_encode(true);
}

public  function deletebtn_tbl_area_b_violations($data){
    // echo $data;
    // exit();
    DB::delete("DELETE FROM public.tbl_area_b_violations
    WHERE gid=$data;");
        return json_encode(true);
}

public  function editbtn_tbl_area_b_violations($gid){
    $q = DB::select("SELECT * FROM public.tbl_area_b_violations where gid=$gid;");

    $pidq = DB::select("select picture_id from public.tbl_area_b_violations where gid=$gid;");
    $arr = json_decode(json_encode($pidq), true);
    $picture_id=implode("",$arr[0]);

    $imagenames= array();
    $durl="/var/www/html/kn/assets/img/SettlerViolation_Pictures/$picture_id/";
    if(!$durl){
        return response()->json(['data' => $q, 'imagenames' => $imagenames]);
    }else{
        if ($handle = opendir("/var/www/html/kn/assets/img/SettlerViolation_Pictures/$picture_id/")) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $imagenames[]= $entry;
                    // if($entry=='bda1.PNG'){
                    //     unlink('./uploads/imgs/'.$entry);
                    // }
                }
            }
            closedir($handle);
        }
    }

    return response()->json(['data' => $q, 'imagenames' => $imagenames]);

    // return json_encode($q);
}



    

public  function update_tbl_area_b_violations(Request $request){
    // return $request->all();
    // exit();
    $gid=$request['gid'];
    $picture_id=$request['picture_id'];

    $imgarr=$request['imgnamesarr'];

    // for imgs remove
    $imgnamesarr=explode(",",$imgarr);
    // print_r($imgnamesarr);
    $c=sizeof($imgnamesarr);
    // echo $c;
    //print_r($imgnamesarr);
    if ($handle = opendir("/var/www/html/kn/assets/img/SettlerViolation_Pictures/$picture_id/")) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                for($i=0; $i<$c; $i++){
                    if($entry==$imgnamesarr[$i]){
                        unlink("/var/www/html/kn/assets/img/SettlerViolation_Pictures/$picture_id/$entry");
                    }
                }
            }
        }
        closedir($handle);
    }
    // for imgs uploads
    $uploadsfilesarray=$request['update_uploadFile'];
    // echo gettype($uploadsfilesarray);
    if(isset($uploadsfilesarray)){
        $update_uploadFile_arr=$uploadsfilesarray;
        for($i=0; $i<sizeof($update_uploadFile_arr); $i++){
            $fileName = $update_uploadFile_arr[$i]->getClientOriginalName(); 
            $url="/var/www/html/kn/assets/img/SettlerViolation_Pictures/$picture_id/";
            if(!$url){
                mkdir("/var/www/html/kn/assets/img/SettlerViolation_Pictures/$picture_id/", 0755);
            }
            $filePath = $update_uploadFile_arr[$i]->move($url, $fileName);
        }
    }

    $geom = json_decode($request['upgeom'], true);
     $geom1 = json_decode($geom, true);
     $x=$geom1['coordinates'][0];
     $y=$geom1['coordinates'][1];
     
        // Function to remove the spacial 
        function RemoveSpecialChar($str) {
            // Using str_replace() function 
            // to replace the word 
            $res = str_replace( array( '\'', '"',
            ',' , ';', '<', '>' ), ' ', $str);
            // Returning the result 
            return $res;
        }


    $fid_=$request['fid_'];
    $categoryid=$request['categoryid'];
    $cat_eng= RemoveSpecialChar($request['cat_eng']);
    $desc_arb=RemoveSpecialChar($request['desc_arb']);
    $desc_eng=RemoveSpecialChar($request['desc_eng']);
    $desc_heb=RemoveSpecialChar($request['desc_heb']);
    $set_heb=RemoveSpecialChar($request['set_heb']);
    $set_arb=RemoveSpecialChar($request['set_arb']);
    $set_eng=RemoveSpecialChar($request['set_eng']);
    $pal_heb=RemoveSpecialChar($request['pal_heb']);
    $pal_arb=RemoveSpecialChar($request['pal_arb']);
    $pal_eng=RemoveSpecialChar($request['pal_eng']);
    $art_heb=RemoveSpecialChar($request['art_heb']);
    $art_eng=RemoveSpecialChar($request['art_eng']);
    $art_arb=RemoveSpecialChar($request['art_arb']);
    $titt_heb=RemoveSpecialChar($request['titt_heb']);
    $titt_eng=RemoveSpecialChar($request['titt_eng']);
    $titt_arb=RemoveSpecialChar($request['titt_arb']);
    $artheb1=RemoveSpecialChar($request['artheb1']);
    $arteng1=RemoveSpecialChar($request['arteng1']);
    $artarb1=RemoveSpecialChar($request['artarb1']);
    $tittheb1=RemoveSpecialChar($request['tittheb1']);
    $titteng1=RemoveSpecialChar($request['titteng1']);
    $tittarb1=RemoveSpecialChar($request['tittarb1']);
   

    if(empty($geom)){
        $q="UPDATE public.tbl_area_b_violations
        SET fid_=$fid_, picture_id=$picture_id, categoryid=$categoryid, cat_eng='$cat_eng', desc_arb='$desc_arb', desc_eng='$desc_eng', desc_heb='$desc_heb', set_heb='$set_heb', set_arb='$set_arb', set_eng='$set_eng', pal_heb='$pal_heb', pal_arb='$pal_arb', pal_eng='$pal_eng', art_heb='$art_heb', art_eng='$art_eng', art_arb='$art_arb', titt_heb='$titt_heb', titt_eng='$titt_eng', titt_arb='$titt_arb', artheb1='$artheb1', arteng1='$arteng1', artarb1='$artarb1', tittheb1='$tittheb1', titteng1='$titteng1', tittarb1='$tittarb1'
        WHERE gid=$gid;";
        DB::update($q);
        // echo $q;
        // exit();
        return json_encode(true);
    }else{
        $q="UPDATE public.tbl_area_b_violations
        SET fid_=$fid_, x=$x, y=$y, picture_id=$picture_id, categoryid=$categoryid, cat_eng='$cat_eng', desc_arb='$desc_arb', desc_eng='$desc_eng', desc_heb='$desc_heb', set_heb='$set_heb', set_arb='$set_arb', set_eng='$set_eng', pal_heb='$pal_heb', pal_arb='$pal_arb', pal_eng='$pal_eng', art_heb='$art_heb', art_eng='$art_eng', art_arb='$art_arb', titt_heb='$titt_heb', titt_eng='$titt_eng', titt_arb='$titt_arb', artheb1='$artheb1', arteng1='$arteng1', artarb1='$artarb1', tittheb1='$tittheb1', titteng1='$titteng1', tittarb1='$tittarb1', geom=ST_GeomFromGeoJSON('$geom')
        WHERE gid=$gid;";
        DB::update($q);
        // echo $q;
        // exit();
        return json_encode(true);
    }
}
// public  function pageno_tbl_area_b_violations($pageno){
//     $offset=$pageno;
//     $q = DB::select("SELECT json_build_object('type', 'FeatureCollection','crs',  json_build_object('type','name', 'properties', json_build_object('name', 'EPSG:4326'  )),'features', json_agg(json_build_object('type','Feature','id',gid,'geometry',ST_AsGeoJSON(geom)::json,
//                             'properties', json_build_object(
//                             'gid', gid,
//                             'fid_', fid_,
//                             'x', x,
//                             'y', y,
//                             'picture_id', picture_id,
//                             'categoryid', categoryid,
//                             'cat_eng', cat_eng,
//                             'desc_arb', desc_arb,
//                             'desc_eng', desc_eng,
//                             'desc_heb', desc_heb,
//                             'set_heb', set_heb,
//                             'set_arb', set_arb,
//                             'set_eng', set_eng,
//                             'pal_heb', pal_heb,
//                             'pal_arb', pal_arb,
//                             'pal_eng', pal_eng,
//                             'art_heb', art_heb,
//                             'art_eng', art_eng,
//                             'art_arb', art_arb,
//                             'titt_heb', titt_heb,
//                             'titt_eng', titt_eng,
//                             'titt_arb', titt_arb,
//                             'artheb1', artheb1,
//                             'arteng1', arteng1,
//                             'artarb1', artarb1,
//                             'tittheb1', tittheb1,
//                             'titteng1', titteng1,
//                             'tittarb1', tittarb1
//                                 ))))
//                                 FROM (
//                             SELECT gid, fid_, x, y, picture_id, categoryid, cat_eng, desc_arb, desc_eng, desc_heb, set_heb, 
//                                 set_arb, set_eng, pal_heb, pal_arb, pal_eng, art_heb, art_eng, art_arb, titt_heb, titt_eng, 
//                                 titt_arb, artheb1, arteng1, artarb1, tittheb1, titteng1, tittarb1, geom
//                                 FROM public.tbl_area_b_violations LIMIT 10 OFFSET $offset) as tbl1;");

//         $arr = json_decode(json_encode($q), true);
//         $g=implode("",$arr[0]);
//         $geojson=json_encode($g);
//         return $geojson;
//         exit();
// }












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








    public  function shaperead(Request $request){
        // print_r($request->all());
        $tbl_name=$request->tablename;

        $fileName = $request->file->getClientOriginalName();
        $fname=basename($fileName,".zip");
        // $filePath = $request->file->move(public_path('shapefiles'), $fileName);
        $shpfilename;
        if(isset($request->file)){
            $unzipper  = new Unzip();
            $filePath = $request->file->move(public_path('uploads/shapefiles'), $fileName);
            // $file = $request->file->store('public/'.$fname); //store file in storage/app/zip
            $filenames = $unzipper->extract(public_path('uploads/shapefiles/'.$fileName),public_path('uploads/shapefiles/'.$fname));

            $fdir=public_path('uploads/shapefiles/'.$fname.'/');
                $scan_arr = scandir($fdir);
                $files_arr = array_diff($scan_arr, array('.','..') );
                // echo "<pre>"; print_r( $files_arr ); echo "</pre>";
                // Get each files of our directory with line break
                foreach ($files_arr as $file) {
                    //Get the file path
                    $file_path = 'uploads/shapefiles/'.$fname.'/'.$file; //storage_path('app/public/'.$fname.'/'.$file);
                    // Get the file extension
                    $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);
                    if ($file_ext=="shp" || $file_ext=="png" || $file_ext=="JPG" || $file_ext=="PNG") {
                        $shpfilename=$file;
                    }
                }
                // echo $shpfilename;
                // exit();
            // dd($filenames); //show file names
        }
        // echo $shpfilename;
        try {
            // Open Shapefile
            $shppath=public_path('uploads\shapefiles\\'.$fname.'\\'.$shpfilename);
            // echo $shppath; C:\xampp\htdocs\KN_admin\public\uploads\shapefiles\tbl_area_b_demolitions\tbl_area_b_demolitions.shp
            // $shppath=storage_path('app\public'.'\\'.$fname.'\\'.$shpfilename);
            // echo $shppath;
            // exit();
            $Shapefile = new ShapefileReader($shppath);
            $this->shp($tbl_name,$Shapefile);
            // Read all the records
            // while ($Geometry = $Shapefile->fetchRecord()) {
            //     // Skip the record if marked as "deleted"
            //     if ($Geometry->isDeleted()) {
            //         continue;
            //     }

            //      // Print Geometry as an Array
            //     // print_r($Geometry->getArray());

            //     // // Print Geometry as WKT
            //     // print_r($Geometry->getWKT());
            //     $geom=$Geometry->getWKT();
            //     // // Print Geometry as GeoJSON
            //     // print_r($Geometry->getGeoJSON());

            //     // // Print DBF data
            //     // print_r($Geometry->getDataArray());
            //     $data=$Geometry->getDataArray();

            // }

        } catch (ShapefileException $e) {
            // Print detailed error information
            echo "Error Type: " . $e->getErrorType()
                . "\nMessage: " . $e->getMessage()
                . "\nDetails: " . $e->getDetails();
        }
    }
    // Read all the records
    public function shp($tbl_name,$Shapefile){

        if($tbl_name == 'area_b_demolitions'){
            $q="INSERT INTO public.tbl_area_b_demolitions(
                fid, entity, layer, color, linetype, elevation, linewt, refname, angle, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    $q.="(";
                    $q.=$data['FID'].", ". "'".$data['ENTITY']."'" .", "."'".$data['LAYER']."'".", ".$data['COLOR'].", "."'".$data['LINETYPE']."'".", ".$data['ELEVATION'].", ".$data['LINEWT'].", "."'".$data['REFNAME']."'".", ".$data['ANGLE'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(false);
            }
        }elseif($tbl_name == 'area_b_nature_reserve'){
            $q="INSERT INTO public.tbl_area_b_nature_reserve(
                fid, objectid, class, shape_leng, shape_area, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ". "'".$data['OBJECTID']."'" .", "."'".$data['CLASS']."'".", ".$data['SHAPE_LENG'].", "."'".$data['SHAPE_AREA']."'".", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'Area_AB_Combined'){
            $q="INSERT INTO public.tbl_area_a_and_b_combined(
                fid, class, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", "."'".$data['CLASS']."'".", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'Area_AB_Naturereserve'){
            $q="INSERT INTO public.tbl_area_a_area_b_naturereserve(
                id, objectid, class, shape_leng, shape_area, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['ID'].", ". "'".$data['OBJECTID']."'" .", "."'".$data['CLASS']."'".", ".$data['SHAPE_LENG'].", "."'".$data['SHAPE_AREA']."'".", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'area_a_poly'){
            $q="INSERT INTO public.tbl_area_a_poly(
                fid, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'area_b_poly'){
            $q="INSERT INTO public.tbl_area_b_poly(
                fid, areaupdt, area, shape_leng, shape_area, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ". "'".$data['AREAUPDT']."'" .", "."'".$data['AREA']."'".", ".$data['SHAPE_LENG'].", "."'".$data['SHAPE_AREA']."'".", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'area_b_training'){
            $q="INSERT INTO public.tbl_area_b_training(
                fid, id, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ".$data['ID'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'demolitions_orders'){
            $q="INSERT INTO public.tbl_demolition_orders(
                fid, objectid, id, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ". "'".$data['OBJECTID']."'" .", ".$data['ID'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'expropriation_orders'){
            $q="INSERT INTO public.tbl_expropriation_orders(
                id, reason, title, sign_date, district, remark, created_us, created_da, last_edite, last_edi_1, shape_leng, shape_area, d_reason, d_district, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ". "'".$data['REASON']."'" .", "."'".$data['TITLE']."'".", ".$data['SIGN_DATE'].", "."'".$data['DISTRICT']."'".", "."'".$data['REMARK']."'".", "."'".$data['CREATED_US']."'".", "."'".$data['CREATED_DA']."'".", "."'".$data['LAST_EDITE']."'".", "."'".$data['LAST_EDI_1']."'".", "."'".$data['SHAPE_LENG']."'".", "."'".$data['SHAPE_AREA']."'".", "."'".$data['D_REASON']."'".", "."'".$data['D_DISTRICT']."'".", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'expropriation_orders_AB'){
            $q="INSERT INTO public.tbl_expropriation_orders_ab(
                id, objectid, shape_leng, shape_area, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['ID'].", ". "'".$data['OBJECTID']."'" .", ".$data['SHAPE_LENG'].", "."'".$data['SHAPE_AREA']."'".", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'expropriation_orders_not_AB'){
            $q="INSERT INTO public.tbl_expropriation_orders_not_ab(
                fid, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'security_orders'){
            $q="INSERT INTO public.tbl_security_orders(
                fid, id, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ".$data['ID'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'Seizure_AB'){
            $q="INSERT INTO public.tbl_seizure_ab(
                fid, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['ID'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'Seizure_All'){
            $q="INSERT INTO public.tbl_seizure_all(
               fid, from_date, to_date, ar_num, area, 'הערות', 'הערו_1', 'פונקצ', 'שימוש', 'תקף', geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ". "'".$data['FORM_DATE']."'" .", "."'".$data['TO_DATE']."'".", ".$data['AR_NUM'].", "."'".$data['AREA']."'".", ".$data['תקף'].", ".$data['שימוש'].", ".$data['פונקצ'].", ".$data['הערו_1'].", ".$data['הערות'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }elseif($tbl_name == 'settlements'){
            $q="INSERT INTO public.tbl_settlements(
               fid, objectid, id, name_hebrew, name_english, et_id, shape_leng, shape_area, gis_id, type, area, name_arabic, geom)
                VALUES";
            while ($Geometry = $Shapefile->fetchRecord()) {
                    // Skip the record if marked as "deleted"
                    if ($Geometry->isDeleted()) {
                        continue;
                    }
                    $geom=$Geometry->getWKT();
                    $data=$Geometry->getDataArray();
                    // print_r($data);
                    // exit();
                    $q.="(";
                    $q.=$data['FID'].", ". "'".$data['OBJECTID']."'" .", "."'".$data['ID']."'".", ".$data['NAME_HEBREW'].", "."'".$data['NAME_ENGLISH']."'".", ".$data['ET_ID'].", ".$data['SHAPE_LENG'].", ".$data['SHAPE_AREA'].", ".$data['GIS_ID'].", ".$data['TYPE'].", ".$data['AREA'].", ".$data['NAME_ARABIC'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                    $q.="), ";
            }
            // $fq = rtrim($q, ',');
            $qf= rtrim($q, " ,");
            // echo $qf;
            // exit();
            $pgq=DB::insert($qf);
            if($pgq){
                echo json_encode(true);
                exit();
            }
            else{
                echo json_encode(pg_result_error($pgq));
            }
        }
        else{
            echo json_encode(false);
        }


    }


}
