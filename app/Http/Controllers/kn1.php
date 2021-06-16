<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Illuminate\Http\Request;


use Shapefile\Shapefile;
use Shapefile\ShapefileException;
use Shapefile\ShapefileReader;

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
                                FROM public.tbl_area_b_poly) as tbl1;");

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
                                    FROM public.tbl_seizure_all) as tbl1;");
                                   

                    $arr = json_decode(json_encode($q), true);
                    $g=implode("",$arr[0]);
                    $geojson=json_encode($g);

                $q1 = DB::select("SELECT fid, from_date, to_date, ar_num, area, geom
                                    FROM public.tbl_seizure_all;");
                                    

             
                return view('tables.tbl_seizure_all', ['geojson' => $geojson, 'tbldata' => $q1]);
               
        }
        
    }

//tbl_area_b_demolitions.....................
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
    public  function update_tbl_area_b_demolitions($data){
        $a=json_decode($data);

        // if($a->entity==''){
        //     $entity='null';
        // }else{
        //     $entity=$a->entity;
        // }
        
        $q="UPDATE public.tbl_area_b_demolitions
        SET entity='$a->entity', layer='$a->layer', color=$a->color, linetype='$a->linetype', elevation=$a->elevation, linewt=$a->linewt, refname='$a->refname', angle='$a->angle'
        WHERE fid=$a->fid;";
                DB::update($q);
        // echo $q;
        return json_encode(true);  
    }


//tbl_area_b_nature_reserve.....................
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
    public  function updat_tbl_area_b_nature_reserve($data){
        $a=json_decode($data);

        $q="UPDATE public.tbl_area_b_nature_reserve
        SET objectid=$a->objectid, class='$a->class', shape_leng='$a->shape_leng', shape_area='$a->shape_area'
        WHERE fid=$a->fid;";
                DB::update($q);
        // echo $q;
        return json_encode(true);  
    }

     
//tbl_Area_AB_Combined.....................
    public  function deletebtn_tbl_area_a_and_b_combined($data){
        // echo $data;
        // exit();
        DB::delete("DELETE FROM public.tbl_area_a_and_b_combined
        WHERE fid=$data;");
            return json_encode(true);
    } 

    public  function editbtn_tbl_area_a_and_b_combined($id){
        $q = DB::select("SELECT *
                            FROM public.tbl_area_a_and_b_combined where fid=$id;");
        return json_encode($q);  
    }
    public  function updat_tbl_area_a_and_b_combined($data){
        $a=json_decode($data);

        $q="UPDATE public.tbl_area_a_and_b_combined
        SET class='$a->class'
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

        }
        else{
            echo json_encode(false);
        } 
        

    }


}
