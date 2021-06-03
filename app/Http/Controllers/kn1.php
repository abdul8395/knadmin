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
            
        }elseif($name=='area_b_nature_reserve'){
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
    public  function update_tbl_area_b_demolitions($data){
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
        // echo "shaperead controller";
        $fileName = $request->file->getClientOriginalName();
        $fname=basename($fileName,".zip"); 
        // $filePath = $request->file->move(public_path('shapefiles'), $fileName);
        $shpfilename;
        if(isset($request->file)){
            $unzipper  = new Unzip();
            $file = $request->file->store('public/'.$fname); //store file in storage/app/zip
            $filenames = $unzipper->extract(storage_path('app/'.$file),storage_path('app/public/'.$fname));
            
            $fdir=storage_path('app/public/'.$fname.'/');
                $scan_arr = scandir($fdir);
                $files_arr = array_diff($scan_arr, array('.','..') );
                // echo "<pre>"; print_r( $files_arr ); echo "</pre>";
                // Get each files of our directory with line break
                foreach ($files_arr as $file) {
                    //Get the file path
                    $file_path = 'app/public/'.$fname.'/'.$file; //storage_path('app/public/'.$fname.'/'.$file);
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
            $shppath='C:\xampp\htdocs\KN_admin\storage\app\public\\'.$fname.'\\'.$shpfilename;
            // $shppath=storage_path('app\public'.'\\'.$fname.'\\'.$shpfilename);
            // echo $shppath;
            // exit();
            $Shapefile = new ShapefileReader($shppath);
            $this->shp($Shapefile);
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
    public function shp($Shapefile){
        $q="INSERT INTO public.tbl_area_b_demolitions(
            fid, entity, layer, color, linetype, elevation, linewt, refname, angle, geom)
            VALUES";
        while ($Geometry = $Shapefile->fetchRecord()) {
                // Skip the record if marked as "deleted"
                if ($Geometry->isDeleted()) {
                    continue;
                }
                
                // Print Geometry as an Array
                // print_r($Geometry->getArray());
                
                // // Print Geometry as WKT
                // print_r($Geometry->getWKT());
            $geom=$Geometry->getWKT();
                //    print_r($geom);
                // // Print Geometry as GeoJSON
                // print_r($Geometry->getGeoJSON());
                
                // // Print DBF data
                // print_r($Geometry->getDataArray());
                $data=$Geometry->getDataArray();
                // print_r($data);
                $q.="(";
                $q.=$data['FID'].", ". "'".$data['ENTITY']."'" .", "."'".$data['LAYER']."'".", ".$data['COLOR'].", "."'".$data['LINETYPE']."'".", ".$data['ELEVATION'].", ".$data['LINEWT'].", "."'".$data['REFNAME']."'".", ".$data['ANGLE'].", ".\DB::raw("ST_GeomFromText('$geom',4326)");
                $q.="), ";
            

                // ('Point','palestine_bbh_makor',84,'Continuous',0,25,null,0),

        }
        // $fq = rtrim($q, ',');
        $qf= rtrim($q, " ,");
        // echo $qf;
        $pgq=DB::insert($qf);
        if($pgq){
            echo json_encode(true);
        }else{
            echo json_encode("Error!...Schema not match");
            }
    }


}
