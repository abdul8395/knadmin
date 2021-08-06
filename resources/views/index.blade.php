<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kn Admin</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />
{{--        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />--}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.css"/>

        



      <link rel="stylesheet" href="{{URL::asset('/css/kn1style.css')}}">

      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

  <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
{{--  <link rel="stylesheet" href="{{URL::asset('draw/leaflet.draw.css')}}"/>--}}




        <!-- Styles -->
        <style>
            #map {height: 430px; }
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
<body >
<input type="hidden" id="hidngeom" >
<input type="hidden" id="hidnupdatedgeom" >
<div class="wrapper" >

    @include('sidebarlayres')
    <!-- Page Content  -->
    <div id="content">
        <div class="row">
            <div class="col">
                <div id="map" >
                    <div id="shpfileuploadmodal" class="modal">
                        <div class="modal-dialog modal-dialog-centered modal-lg ">
                            <div id='form' class="modal-content col-md-12 col-md-offset-6 ">
                            <form method="POST" action="" enctype="multipart/form-data" id="myForm">

                                <div class="modal-header">
                                <h4 class="modal-title">Choose Table Name for Shape File Insertion</h4>
                                <button type="button" id="close_btn" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body" >
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <select id="tablename" class="form-control" name="tablename">
                                                <option style="color:red" selected disabled>--Select Table Name--</option>
                                                <option value="area_b_nature_reserve">Area B Nature Reserve</option>
                                                <option value="area_b_demolitions">Area B Demolitions</option>
                                                <option value="Area_AB_Combined">Area A&B Combined</option>
                                                <option value="Area_AB_Naturereserve">Area A&B Naturereserve</option>
                                                <option value="area_a_poly">Area A Poly</option>
                                                <option value="area_b_poly">Area B Poly</option>
                                                <option value="area_b_training">Area B Tranining</option>
                                                <option value="demolitions_orders">Demolitions Orders</option>
                                                <option value="expropriation_orders">Expropriation Orders</option>
                                                <option value="expropriation_orders_AB">Expropriation Orders AB</option>
                                                <option value="expropriation_orders_not_AB">Expropriation Orders Not AB</option>
                                                <option value="security_orders">Security Orders</option>
                                                <option value="Seizure_AB">Seizure AB</option>
                                                <option value="Seizure_All">Seizure All</option>
                                                <option value="settlements">Settlements</option>
                                                <option value="area_b_violations">area_b_violations</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="choose">
                                        <div class="col-md-4">
                                        <input type="file" name="file" id="shp" class="" accept=".zip" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="exl_btn" class="modal-footer">
                                    <button id="btnsave" type="submit" class="btn btn-success pull-right">Save</button>
                                </div>

                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" style="margin-bottom:10px !important;">
            <div class="clearfix"></div><br />
            
                @yield('content')

        </div>
    </div>
</div>
</body>
</html>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Turf.js/0.0.124/turf.min.js"></script>
<!-- {{--<script src="{{URL::asset('draw/leaflet.draw-custom.js')}}"></script>--}} -->
<script src="https://cdn.jsdelivr.net/npm/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<script src="{{URL::asset('shapefilelib/shp.js')}}"></script>
<script src="{{URL::asset('shapefilelib/leaflet.shpfile.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
      



<script>
   var tbl_name;
   var geojsonfromhiddenfld;
   var dtable
   var feature_id
   

            var map = L.map('map').setView([31.807491554, 35.341034188], 8);
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

       var drawnItems = L.featureGroup().addTo(map);
        var drawControl = new L.Control.Draw({
            position: 'topleft',
            draw: {
                circle: false,
                rectangle: false,
                polyline: false,
                polygon: true,
                marker: true,
                circlemarker: false

            },
            edit: {featureGroup: drawnItems, edit: true}
        }).addTo(map);


        map.on('draw:created', function (e) {

            var type = e.layerType;
            var layer = e.layer;
            drawnItems.addLayer(layer);
            // console.log(type);
            var json_data= layer.toGeoJSON();
                data=json_data.geometry;
            // console.log(data);
             var gm= JSON.stringify(data)
            $("#hidngeom").val(gm);
            if(tbl_name=='tbl_area_b_demolitions'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_area_b_nature_reserve'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_area_a_and_b_combined'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_area_a_area_b_naturereserve'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_area_a_poly'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_area_b_poly'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_area_b_training'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_demolition_orders'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_expropriation_orders'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_expropriation_orders_ab'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_expropriation_orders_not_ab'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_security_orders'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_seizure_ab'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_seizure_all'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_settlements'){
                $("#insert_modal").modal("show");
            }
            else if(tbl_name=='tbl_area_b_violations'){
                $("#insert_modal").modal("show");
            }





        });

        map.on('draw:edited', function (e) {
            var layers = e.layers;
            var json_data= layers.toGeoJSON();
            // console.log(json_data);
                data=json_data;
                // console.log(data);
                var updated_geom=data.features[0].geometry;
                var id=data.features[0].id
                // alert(id);
                // console.log(updated_geom);
            if(tbl_name=='tbl_area_b_demolitions'){
                editgeom_tbl_area_b_demolitions(id, updated_geom)
            }
            else if(tbl_name=='tbl_area_b_nature_reserve'){
                editgeom_tbl_area_b_nature_reserve(id, updated_geom)
            }
            else if(tbl_name=='tbl_area_a_and_b_combined'){
                editgeom_tbl_area_a_and_b_combined(id, updated_geom)
            }
            else if(tbl_name=='tbl_area_a_area_b_naturereserve'){
                editgeom_tbl_area_a_area_b_naturereserve(id, updated_geom)
            }
            else if(tbl_name=='tbl_area_a_poly'){
                editgeom_tbl_area_a_poly(id, updated_geom)
            }
            else if(tbl_name=='tbl_area_b_poly'){
                editgeom_tbl_area_b_poly(id, updated_geom)
            }
            else if(tbl_name=='tbl_area_b_training'){
                editgeom_tbl_area_b_training(id, updated_geom)
            }
            else if(tbl_name=='tbl_demolition_orders'){
                editgeom_tbl_demolition_orders(id, updated_geom)
            }
            else if(tbl_name=='tbl_expropriation_orders'){
                editgeom_tbl_expropriation_orders(id, updated_geom)
            }
            else if(tbl_name=='tbl_expropriation_orders_ab'){
                editgeom_tbl_expropriation_orders_ab(id, updated_geom)
            }
            else if(tbl_name=='tbl_expropriation_orders_not_ab'){
                editgeom_tbl_expropriation_orders_not_ab(id, updated_geom)
            }
            else if(tbl_name=='tbl_security_orders'){
                editgeom_tbl_security_orders(id, updated_geom)
            }
            else if(tbl_name=='tbl_seizure_ab'){
                editgeom_tbl_seizure_ab(id, updated_geom)
            }
            else if(tbl_name=='tbl_seizure_all'){
                editgeom_tbl_seizure_all(id, updated_geom)
            }
            else if(tbl_name=='tbl_settlements'){
                editgeom_tbl_settlements(id, updated_geom)
            }
            else if(tbl_name=='tbl_area_b_violations'){
                editgeom_tbl_area_b_violations(id, updated_geom)
            }




        });
    function loadgeojsontomap(){
        //L.geoJSON(JSON.parse(geojsonfromhiddenfld)).addTo(this.map);
            // console.log(geojsonfromhiddenfld);
            var result_set=JSON.parse(geojsonfromhiddenfld);
            if(result_set.features[0].geometry.type=='MultiPolygon'){
                for(var j=0;j<result_set.features.length;j++) {
                    result_set.features[j].geometry.coordinates.forEach(function (shapeCoords, i) {
                        var polygon = {type: "Polygon", coordinates: shapeCoords};
                        polygon.properties={}
                        polygon.properties.id=result_set.features[j].id

                        L.geoJson(polygon, {
                            id:result_set.features[j].id,
                            onEachFeature: function (feature, layer) {
                                layer.on('click', function (e) {
                            //   layer.options = layer.options||{};
                                layer.feature.properties.id=layer.feature.geometry.properties.id
                                layer.feature.id=layer.feature.geometry.properties.id
                                drawnItems.addLayer(layer);
                                // layer.editing.enable();
                                // console.log(layer.toGeoJSON());
                                feature_id=layer.toGeoJSON();
                                dtable.search(feature_id.id).draw();  
                                });
                            }
                        }).addTo(this.map);
                    })
                }
            }else {
                L.geoJSON(result_set, {
                    onEachFeature: function (feature, layer) {
                        layer.on('click', function (e) {
                            drawnItems.addLayer(layer);

                            // console.log(layer.toGeoJSON());
                            feature_id=layer.toGeoJSON();
                            dtable.search(feature_id.id).draw();    
                            // alert(feature_id)
                            // var tbl= '<table class="table_draw" id="tbl_Info"></table>' +
                            //     '<table><tr><td></td><td></td><td></td><td></table>';
                            // layer.bindPopup(tbl, {
                            //     minWidth : 300
                            // });
                        });
                    }
                }).addTo(this.map);
            }
    }
    setTimeout(function(){
        loadgeojsontomap()
    }, 2000);



    $(document).ready(function () {
        $("#close_btn").on("click", function () {
                $("#shpfileuploadmodal").hide();
            });

        var  geojsondata=$('#hidData').val();
        // alert(geojsondata);
        // console.log(geojsondata);
        if(geojsondata==undefined || geojsondata==''){
        // console.log('no geojson');
        geojsonfromhiddenfld=JSON.stringify({"type": "FeatureCollection","features": [{"type": "Feature","properties": {},"geometry": {"type": "LineString","coordinates": [[74.35265175998211,31.54150020733578],[74.35264639556408,31.541506493680046]]}}]})
        }else{
            geojsonfromhiddenfld=JSON.parse(geojsondata);
        }
        // console.log(geojsonfromhiddenfld)

         tbl_name=$('#hidden_table_name').val();


        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        dtable = $('#tbl').DataTable( {
        "lengthMenu": [[2, 5, 10], [2, 5, 10]],
        "targets": 'no-sort',
        "bSort": false,
        } );

        
        
    });

   

    $('#tbl').on( 'page.dt', function () {
    var info = dtable.page.info();
        if(tbl_name=='tbl_area_b_poly'){
            $.ajax({
                type: "get",
                url: "switch_layre/pageno_tbl_area_b_poly/"+info.page,
                success: function (res) {
                     // setTimeout(function(){
                    // }, 2000);
                        geojsonfromhiddenfld=JSON.parse(res)
                        loadgeojsontomap()
                }
            });
        }
        else if(tbl_name=='tbl_seizure_all'){
            $.ajax({
                type: "get",
                url: "switch_layre/pageno_tbl_seizure_all/"+info.page,
                success: function (res) {
                     // setTimeout(function(){
                    // }, 2000);
                        geojsonfromhiddenfld=JSON.parse(res)
                        loadgeojsontomap()
                }
            });
        }
        // else if(tbl_name=='tbl_area_b_violations'){
        //     $.ajax({
        //         type: "get",
        //         url: "switch_layre/pageno_tbl_area_b_violations/"+info.page,
        //         success: function (res) {
        //              // setTimeout(function(){
        //             // }, 2000);
        //                 geojsonfromhiddenfld=JSON.parse(res)
        //                 loadgeojsontomap()
        //         }
        //     });
        // }
    // alert(info.page)
    // $('#pageInfo').html( 'Showing page: '+info.page+' of '+info.pages );
    } );

    function zoombtn_tbl_area_b_demolitions(fid){
       gj= JSON.parse(geojsonfromhiddenfld)
        for(var i=0;i<gj.features.length;i++){if(gj.features[i].properties.fid==fid){map.setView([gj.features[i].geometry.coordinates[1],gj.features[i].geometry.coordinates[0]],17)}}
        // console.log(fid)
        // console.log(geojsonfromhiddenfld)
        
    }
    function zoombtn_tbl_area_b_training(fid){
       gj= JSON.parse(geojsonfromhiddenfld)
        for(var i=0;i<gj.features.length;i++){if(gj.features[i].properties.fid==fid){map.setView([gj.features[i].geometry.coordinates[1],gj.features[i].geometry.coordinates[0]],17)}}
    }
    function zoombtn_tbl_demolition_orders(fid){
       gj= JSON.parse(geojsonfromhiddenfld)
        for(var i=0;i<gj.features.length;i++){if(gj.features[i].properties.fid==fid){map.setView([gj.features[i].geometry.coordinates[1],gj.features[i].geometry.coordinates[0]],17)}}
    }
    function zoombtn_tbl_security_orders(fid){
       gj= JSON.parse(geojsonfromhiddenfld)
        for(var i=0;i<gj.features.length;i++){if(gj.features[i].properties.fid==fid){map.setView([gj.features[i].geometry.coordinates[1],gj.features[i].geometry.coordinates[0]],17)}}
    }
    function zoombtn_tbl_area_b_violations(gid){
       gj= JSON.parse(geojsonfromhiddenfld)
       console.log(gj)
        for(var i=0;i<gj.features.length;i++){if(gj.features[i].properties.gid==gid){map.setView([gj.features[i].geometry.coordinates[1],gj.features[i].geometry.coordinates[0]],17)}
        // console.log(map.setView([gj.features[i].geometry.coordinates[1],gj.features[i].geometry.coordinates[0]],17))
        }
    }
    function zoombtn_tbl_area_a_and_b_combined(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_area_a_and_b_combined/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],15)
                }
            });
    }
    function zoombtn_tbl_area_a_area_b_naturereserve(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_area_a_area_b_naturereserve/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }
    function zoombtn_tbl_area_a_poly(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_area_a_poly/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }
    function zoombtn_tbl_area_b_nature_reserve(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_area_b_nature_reserve/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }
    function zoombtn_tbl_area_b_poly(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_area_b_poly/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }

    function zoombtn_tbl_expropriation_orders_ab(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_expropriation_orders_ab/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }
    function zoombtn_tbl_expropriation_orders_not_ab(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_expropriation_orders_not_ab/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }
    function zoombtn_tbl_expropriation_orders(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_expropriation_orders/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }
    function zoombtn_tbl_seizure_ab(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_seizure_ab/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }
    function zoombtn_tbl_seizure_all(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_seizure_all/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }
    function zoombtn_tbl_settlements(fid){
        $.ajax({
                type: "get",
                url: "switch_layre/zoombtn_tbl_settlements/"+fid,
                success: function (res) {
                    var r=JSON.parse(res)
                    map.setView([r[0].y,r[0].x],16)
                }
            });
    }

    // table tbl_area_b_demolitions insert/update/delete

        function insert_tbl_area_b_demolation() {
            var hgeom=$('#hidngeom').val()

            var reqdata={
                entity:$('#ins_entity').val(),
                layer:$('#ins_layer').val(),
                color:$('#ins_color').val(),
                linetype:$('#ins_linetype').val(),
                elevation:$('#ins_elevation').val(),
                linewt:$('#ins_linewt').val(),
                refname:$('#ins_refname').val(),
                angle:$('#ins_angle').val(),
                geom:JSON.stringify(hgeom)
            };
            $.ajax({
                type: "post",
                url: "switch_layre/insert_area_b_demolation",
                // dataType : "json",
                data:{data:reqdata},
                success: function (res) {
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("inserted Successfully");
                        $("#insert_modal").modal("hide");
                        $('#hidngeom').val('');
                    }
                    else {
                        toastr.error("can't insert Error");
                    }
                }
            });
        }

        function editgeom_tbl_area_b_demolitions(id,updatedgeom) {
            // console.log(id)
            // console.log(updatedgeom)
            var hiddengeom=JSON.stringify(updatedgeom)

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_area_b_demolitions/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#entity').val(r[0].entity)
                        $('#layer').val(r[0].layer)
                        $('#color').val(r[0].color)
                        $('#linetype').val(r[0].linetype)
                        $('#elevation').val(r[0].elevation)
                        $('#linewt').val(r[0].linewt)
                        $('#refname').val(r[0].refname)
                        $('#angle').val(r[0].angle)
                        $('#hidnfid').val(r[0].fid);
                        $('#hidnupdatedgeom').val(hiddengeom);
                        $("#edit_modal").modal("show");
                }
            });
        }

        function deletebtn_tbl_area_b_demolitions(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_area_b_demolitions/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
        function editbtn_tbl_area_b_demolitions(id) {
            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_area_b_demolitions/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                    $('#entity').val(r[0].entity)
                    $('#layer').val(r[0].layer)
                    $('#color').val(r[0].color)
                    $('#linetype').val(r[0].linetype)
                    $('#elevation').val(r[0].elevation)
                    $('#linewt').val(r[0].linewt)
                    $('#refname').val(r[0].refname)
                    $('#angle').val(r[0].angle)
                    $('#hidnfid').val(r[0].fid);
                    $("#edit_modal").modal("show");
                }
            });
        }

        function update_tbl_area_b_demolitions() {
            var hidnupdatedgeom=$('#hidnupdatedgeom').val()

            var reqdata={
                entity:$('#entity').val(),
                layer:$('#layer').val(),
                color:$('#color').val(),
                linetype:$('#linetype').val(),
                elevation:$('#elevation').val(),
                linewt:$('#linewt').val(),
                refname:$('#refname').val(),
                angle:$('#angle').val(),
                fid:$('#hidnfid').val(),
                upgeom:JSON.stringify(hidnupdatedgeom)

            };
            $.ajax({
                type: "post",
                url: "switch_layre/update_tbl_area_b_demolitions",
                data:{data:reqdata},
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Updated Successfully");
                        $("#edit_modal").modal("hide");
                        $('#hidnupdatedgeom').val('')
                        location.reload();
                    }
                    else {
                        toastr.error("can't Update Error");
                    }
                }
            });
        }
// table tbl_area_b_nature_reserve add/update/delete
    function insert_tbl_area_b_nature_reserve() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            objectid:$('#ins_objectid').val(),
            class:$('#ins_class').val(),
            shape_leng:$('#ins_shape_leng').val(),
            shape_area:$('#ins_shape_area').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_area_b_nature_reserve",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_area_b_nature_reserve(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)

        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_b_nature_reserve/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                    $('#objectid').val(r[0].objectid)
                    $('#class').val(r[0].class)
                    $('#shape_leng').val(r[0].shape_leng)
                    $('#shape_area').val(r[0].shape_area)
                    $('#hidnfid').val(r[0].fid);
                    $('#hidnupdatedgeom').val(hiddengeom);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_area_b_nature_reserve(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_area_b_nature_reserve/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
    function editbtn_tbl_area_b_nature_reserve(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_area_b_nature_reserve/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#objectid').val(r[0].objectid)
                        $('#class').val(r[0].class)
                        $('#shape_leng').val(r[0].shape_leng)
                        $('#shape_area').val(r[0].shape_area)
                        $('#hidnfid').val(r[0].fid);
                        $("#edit_modal").modal("show");
                }
            });
    }

    function update_tbl_area_b_nature_reserve() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            objectid:$('#objectid').val(),
            class:$('#class').val(),
            shape_leng:$('#shape_leng').val(),
            shape_area:$('#shape_area').val(),
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_area_b_nature_reserve",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }

// table tbl_area_a_and_b_combined
    function insert_tbl_area_a_and_b_combined() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            class:$('#ins_class').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_area_a_and_b_combined",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_area_a_and_b_combined(id,updatedgeom) {
        var hiddengeom=JSON.stringify(updatedgeom)
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_a_and_b_combined/"+id,
            // dataType : "json",
            success: function (res) {
                // console.log(res)
                var r=JSON.parse(res)
                $('#class').val(r[0].class)
                $('#hidnfid').val(r[0].fid);
                $('#hidnupdatedgeom').val(hiddengeom);
                $("#edit_modal").modal("show");
            }
        });
    }
    function deletebtn_tbl_area_a_and_b_combined(id){
        $.ajax({
            type : "GET",
            url : 'switch_layre/deletebtn_tbl_area_a_and_b_combined/'+id,
            success:function(res){
                var r=JSON.parse(res)
                        if(r == true){
                            toastr.success("Deleted Successfully");
                            location.reload();
                        }
                        else {
                            toastr.error("can't Delete ");
                        }


            }
        });
    }
    function editbtn_tbl_area_a_and_b_combined(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_area_a_and_b_combined/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#class').val(r[0].class)
                        $('#hidnfid').val(r[0].fid);
                        $("#edit_modal").modal("show");
                }
            });
    }
    function update_tbl_area_a_and_b_combined() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            class:$('#class').val(),
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_area_a_and_b_combined",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    location.reload();

                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }

// table tbl_area_a_area_b_naturereserve insert/update/delete
    function insert_tbl_area_a_area_b_naturereserve() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            objectid:$('#ins_objectid').val(),
            class:$('#ins_class').val(),
            shape_leng:$('#ins_shape_leng').val(),
            shape_area:$('#ins_shape_area').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_area_a_area_b_naturereserve",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_area_a_area_b_naturereserve(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_a_area_b_naturereserve/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                $('#objectid').val(r[0].objectid)
                $('#class').val(r[0].class)
                $('#shape_leng').val(r[0].shape_leng)
                $('#shape_area').val(r[0].shape_area)
                $('#hidnfid').val(r[0].id);
                $('#hidnupdatedgeom').val(hiddengeom);
                $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_area_a_area_b_naturereserve(id){
        $.ajax({
            type : "GET",
            url : 'switch_layre/deletebtn_tbl_area_a_area_b_naturereserve/'+id,
            success:function(res){
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Deleted Successfully");
                    location.reload();
                }
                else {
                    toastr.error("can't Delete ");
                }
            }
        });
    }
    function editbtn_tbl_area_a_area_b_naturereserve(id) {
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_a_area_b_naturereserve/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                $('#objectid').val(r[0].objectid)
                $('#class').val(r[0].class)
                $('#shape_leng').val(r[0].shape_leng)
                $('#shape_area').val(r[0].shape_area)
                $('#hidnfid').val(r[0].id);
                $("#edit_modal").modal("show");
            }
        });
    }

    function update_tbl_area_a_area_b_naturereserve() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            objectid:$('#objectid').val(),
            class:$('#class').val(),
            shape_leng:$('#shape_leng').val(),
            shape_area:$('#shape_area').val(),
            id:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_area_a_area_b_naturereserve",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }
// table tbl_area_a_poly
    function insert_tbl_area_a_poly() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_area_a_poly",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_area_a_poly(id,updatedgeom) {
        var hiddengeom=JSON.stringify(updatedgeom)
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_a_poly/"+id,
            // dataType : "json",
            success: function (res) {
                // console.log(res)
                var r=JSON.parse(res)
                $('#hidnfid').val(r[0].fid);
                $('#hidnupdatedgeom').val(hiddengeom);
                $("#edit_modal").modal("show");
            }
        });
    }
    function deletebtn_tbl_area_a_poly(id){
        $.ajax({
            type : "GET",
            url : 'switch_layre/deletebtn_tbl_area_a_poly/'+id,
            success:function(res){
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Deleted Successfully");
                    location.reload();
                }
                else {
                    toastr.error("can't Delete ");
                }
            }
        });
    }
    function editbtn_tbl_area_a_poly(id) {
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_a_poly/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                $('#hidnfid').val(r[0].fid);
                $("#edit_modal").modal("show");
            }
        });
    }
    function update_tbl_area_a_poly() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_area_a_poly",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    location.reload();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }

// table tbl_area_b_poly insert/update/delete
    function insert_tbl_area_b_poly() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            areaupdt:$('#ins_areaupdt').val(),
            area:$('#ins_area').val(),
            shape_leng:$('#ins_shape_leng').val(),
            shape_area:$('#ins_shape_area').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_area_b_poly",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_area_b_poly(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_b_poly/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                $('#areaupdt').val(r[0].areaupdt)
                $('#area').val(r[0].class)
                $('#shape_leng').val(r[0].shape_leng)
                $('#shape_area').val(r[0].shape_area)
                $('#hidnfid').val(r[0].fid);
                $('#hidnupdatedgeom').val(hiddengeom);
                $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_area_b_poly(id){
        $.ajax({
            type : "GET",
            url : 'switch_layre/deletebtn_tbl_area_b_poly/'+id,
            success:function(res){
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Deleted Successfully");
                    location.reload();
                }
                else {
                    toastr.error("can't Delete ");
                }
            }
        });
    }
    function editbtn_tbl_area_b_poly(id) {
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_b_poly/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                $('#areaupdt').val(r[0].objectid)
                $('#area').val(r[0].class)
                $('#shape_leng').val(r[0].shape_leng)
                $('#shape_area').val(r[0].shape_area)
                $('#hidnfid').val(r[0].fid);
                $("#edit_modal").modal("show");
            }
        });
    }

    function update_tbl_area_b_poly() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            areaupdt:$('#areaupdt').val(),
            area:$('#area').val(),
            shape_leng:$('#shape_leng').val(),
            shape_area:$('#shape_area').val(),
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_area_b_poly",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }
// table tbl_area_b_training add/update/delete
    function insert_tbl_area_b_training() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            id:$('#ins_id').val(),
            fid:$('#hidnfid').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_area_b_training",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_area_b_training(id,updatedgeom) {
        var hiddengeom=JSON.stringify(updatedgeom)
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_b_training/"+id,
            // dataType : "json",
            success: function (res) {
                // console.log(res)
                var r=JSON.parse(res)
                $('#id').val(r[0].id)
                $('#hidnfid').val(r[0].fid);
                $('#hidnupdatedgeom').val(hiddengeom);
                $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_area_b_training(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_area_b_training/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
    }
    function editbtn_tbl_area_b_training(id) {
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_b_training/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                    $('#id').val(r[0].id)
                    $('#hidnfid').val(r[0].fid);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function update_tbl_area_b_training() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            id:$('#id').val(),
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_area_b_training",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    location.reload();

                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }

// table tbl_demolition_orders insert/update/delete
    function insert_tbl_demolition_orders() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            objectid:$('#ins_objectid').val(),
            id:$('#ins_id').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_demolition_orders",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_demolition_orders(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_demolition_orders/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                $('#objectid').val(r[0].objectid)
                $('#id').val(r[0].id)
                $('#hidnfid').val(r[0].fid);
                $('#hidnupdatedgeom').val(hiddengeom);
                $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_demolition_orders(id){
        $.ajax({
            type : "GET",
            url : 'switch_layre/deletebtn_tbl_demolition_orders/'+id,
            success:function(res){
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Deleted Successfully");
                    location.reload();
                }
                else {
                    toastr.error("can't Delete ");
                }
            }
        });
    }
    function editbtn_tbl_demolition_orders(id) {
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_demolition_orders/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                $('#objectid').val(r[0].objectid)
                $('#id').val(r[0].id)
                $('#hidnfid').val(r[0].id);
                $("#edit_modal").modal("show");
            }
        });
    }

    function update_tbl_demolition_orders() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            objectid:$('#objectid').val(),
            id:$('#id').val(),
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_demolition_orders",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }



// table tbl_expropriation_orders insert/update/delete

    function insert_tbl_expropriation_orders() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            reason:$('#ins_reason').val(),
            title:$('#ins_title').val(),
            sign_date:$('#ins_sign_date').val(),
            district:$('#ins_district').val(),
            remark:$('#ins_remark').val(),
            created_us:$('#ins_created_us').val(),
            created_da:$('#ins_created_da').val(),
            last_edite:$('#ins_last_edite').val(),
            last_edi_1:$('#ins_last_edi_1').val(),
            shape_leng:$('#ins_shape_leng').val(),
            shape_area:$('#ins_shape_area').val(),
            d_reason:$('#ins_d_reason').val(),
            d_district:$('#ins_d_district').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_expropriation_orders",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_expropriation_orders(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_expropriation_orders/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                $('#reason').val(r[0].reason)
                $('#title').val(r[0].title)
                $('#district').val(r[0].district)
                $('#remark').val(r[0].remark)
                $('#created_us').val(r[0].created_us)
                $('#created_da').val(r[0].created_da)
                $('#last_edite').val(r[0].last_edite)
                $('#last_edi_1').val(r[0].last_edi_1)
                $('#shape_leng').val(r[0].shape_leng)
                $('#shape_area').val(r[0].shape_area)
                $('#d_reason').val(r[0].d_reason)
                $('#d_district').val(r[0].d_district)
                $('#hidnfid').val(r[0].id);
                $('#hidnupdatedgeom').val(hiddengeom);
                $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_expropriation_orders(id){
        $.ajax({
            type : "GET",
            url : 'switch_layre/deletebtn_tbl_expropriation_orders/'+id,
            success:function(res){
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Deleted Successfully");
                    location.reload();
                }
                else {
                    toastr.error("can't Delete ");
                }
            }
        });
    }
    function editbtn_tbl_expropriation_orders(id) {
        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_expropriation_orders/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                $('#reason').val(r[0].reason)
                $('#title').val(r[0].title)
                $('#district').val(r[0].district)
                $('#remark').val(r[0].remark)
                $('#created_us').val(r[0].created_us)
                $('#created_da').val(r[0].created_da)
                $('#last_edite').val(r[0].last_edite)
                $('#last_edi_1').val(r[0].last_edi_1)
                $('#shape_leng').val(r[0].shape_leng)
                $('#shape_area').val(r[0].shape_area)
                $('#d_reason').val(r[0].d_reason)
                $('#d_district').val(r[0].d_district)
                $('#hidnfid').val(r[0].id);
                $("#edit_modal").modal("show");
            }
        });
    }

    function update_tbl_expropriation_orders() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            reason:$('#reason').val(),
            title:$('#title').val(),
            sign_date:$('#sign_date').val(),
            district:$('#district').val(),
            remark:$('#remark').val(),
            created_us:$('#created_us').val(),
            created_da:$('#created_da').val(),
            last_edite:$('#last_edite').val(),
            last_edi_1:$('#last_edi_1').val(),
            shape_leng:$('#shape_leng').val(),
            shape_area:$('#shape_area').val(),
            d_reason:$('#d_reason').val(),
            d_district:$('#d_district').val(),
            id:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_expropriation_orders",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }




// table tbl_expropriation_orders_ab add/update/delete
    function insert_tbl_expropriation_orders_ab() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            objectid:$('#ins_objectid').val(),
            shape_leng:$('#ins_shape_leng').val(),
            shape_area:$('#ins_shape_area').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_expropriation_orders_ab",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_expropriation_orders_ab(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)

        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_expropriation_orders_ab/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                    $('#objectid').val(r[0].objectid)
                    $('#shape_leng').val(r[0].shape_leng)
                    $('#shape_area').val(r[0].shape_area)
                    $('#hidnfid').val(r[0].id);
                    $('#hidnupdatedgeom').val(hiddengeom);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_expropriation_orders_ab(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_expropriation_orders_ab/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
    function editbtn_tbl_expropriation_orders_ab(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_expropriation_orders_ab/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#objectid').val(r[0].objectid)
                        $('#shape_leng').val(r[0].shape_leng)
                        $('#shape_area').val(r[0].shape_area)
                        $('#hidnfid').val(r[0].id);
                        $("#edit_modal").modal("show");
                }
            });
    }

    function update_tbl_expropriation_orders_ab() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            objectid:$('#objectid').val(),
            shape_leng:$('#shape_leng').val(),
            shape_area:$('#shape_area').val(),
            id:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_expropriation_orders_ab",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }


// table tbl_expropriation_orders_not_ab add/update/delete
    function insert_tbl_expropriation_orders_not_ab() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_expropriation_orders_not_ab",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_expropriation_orders_not_ab(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)

        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_expropriation_orders_not_ab/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                    $('#hidnfid').val(r[0].id);
                    $('#hidnupdatedgeom').val(hiddengeom);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_expropriation_orders_not_ab(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_expropriation_orders_not_ab/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
    function editbtn_tbl_expropriation_orders_not_ab(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_expropriation_orders_not_ab/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#hidnfid').val(r[0].id);
                        $("#edit_modal").modal("show");
                }
            });
    }

    function update_tbl_expropriation_orders_not_ab() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            id:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_expropriation_orders_not_ab",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }



// table tbl_security_orders add/update/delete
function insert_tbl_security_orders() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            id:$('#ins_id').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_security_orders",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_security_orders(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)

        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_security_orders/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                    $('#id').val(r[0].id)
                    $('#hidnfid').val(r[0].fid);
                    $('#hidnupdatedgeom').val(hiddengeom);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_security_orders(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_security_orders/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
    function editbtn_tbl_security_orders(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_security_orders/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#id').val(r[0].id)
                        $('#hidnfid').val(r[0].fid);
                        $("#edit_modal").modal("show");
                }
            });
    }

    function update_tbl_security_orders() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            id:$('#id').val(),
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_security_orders",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }


// table tbl_seizure_ab add/update/delete
function insert_tbl_seizure_ab() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_seizure_ab",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_seizure_ab(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)

        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_seizure_ab/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                    $('#hidnfid').val(r[0].id);
                    $('#hidnupdatedgeom').val(hiddengeom);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_seizure_ab(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_seizure_ab/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
    function editbtn_tbl_seizure_ab(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_seizure_ab/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#hidnfid').val(r[0].id);
                        $("#edit_modal").modal("show");
                }
            });
    }

    function update_tbl_seizure_ab() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            id:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_seizure_ab",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }
 


// table tbl_seizure_all add/update/delete
    function insert_tbl_seizure_all() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            from_date:$('#ins_from_date').val(),
            to_date:$('#ins_to_date').val(),
            ar_num:$('#ins_ar_num').val(),
            area:$('#ins_area').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_seizure_all",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_seizure_all(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)

        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_seizure_all/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                    $('#from_date').val(r[0].from_date)
                    $('#to_date').val(r[0].to_date)
                    $('#ar_num').val(r[0].ar_num)
                    $('#area').val(r[0].area)
                    $('#hidnfid').val(r[0].fid);
                    $('#hidnupdatedgeom').val(hiddengeom);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_seizure_all(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_seizure_all/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
    function editbtn_tbl_seizure_all(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_seizure_all/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#from_date').val(r[0].from_date)
                        $('#to_date').val(r[0].to_date)
                        $('#ar_num').val(r[0].ar_num)
                        $('#area').val(r[0].area)
                        $('#hidnfid').val(r[0].fid);
                        $("#edit_modal").modal("show");
                }
            });
    }

    function update_tbl_seizure_all() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            from_date:$('#ins_from_date').val(),
            to_date:$('#ins_to_date').val(),
            ar_num:$('#ins_ar_num').val(),
            area:$('#ins_area').val(),
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_seizure_all",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }

// table tbl_settlements add/update/delete
    function insert_tbl_settlements() {
        var hgeom=$('#hidngeom').val()
        var reqdata={
            objectid:$('#ins_objectid').val(),
            id:$('#ins_id').val(),
            name_hebrew:$('#ins_name_hebrew').val(),
            name_english:$('#ins_name_english').val(),
            et_id:$('#ins_et_id').val(),
            shape_leng:$('#ins_shape_leng').val(),
            shape_area:$('#ins_shape_area').val(),
            gis_id:$('#ins_gis_id').val(),
            type:$('#ins_type').val(),
            area:$('#ins_area').val(),
            name_arabic:$('#ins_name_arabic').val(),
            geom:JSON.stringify(hgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_settlements",
            // dataType : "json",
            data:{data:reqdata},
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }

    function editgeom_tbl_settlements(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)

        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_settlements/"+id,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                // console.log(r);
                // alert(r[0].entity)
                    $('#objectid').val(r[0].objectid)
                    $('#id').val(r[0].id)
                    $('#name_hebrew').val(r[0].name_hebrew)
                    $('#name_english').val(r[0].name_english)
                    $('#et_id').val(r[0].et_id)
                    $('#shape_leng').val(r[0].shape_leng)
                    $('#shape_area').val(r[0].shape_area)
                    $('#gis_id').val(r[0].gis_id)
                    $('#type').val(r[0].type)
                    $('#area').val(r[0].area)
                    $('#name_arabic').val(r[0].name_arabic)
                    $('#hidnfid').val(r[0].fid);
                    $('#hidnupdatedgeom').val(hiddengeom);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_settlements(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_settlements/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
    function editbtn_tbl_settlements(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_settlements/"+id,
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                        $('#objectid').val(r[0].objectid)
                        $('#id').val(r[0].id)
                        $('#name_hebrew').val(r[0].name_hebrew)
                        $('#name_english').val(r[0].name_english)
                        $('#et_id').val(r[0].et_id)
                        $('#shape_leng').val(r[0].shape_leng)
                        $('#shape_area').val(r[0].shape_area)
                        $('#gis_id').val(r[0].gis_id)
                        $('#type').val(r[0].type)
                        $('#area').val(r[0].area)
                        $('#name_arabic').val(r[0].name_arabic)
                        $('#hidnfid').val(r[0].fid);
                        $("#edit_modal").modal("show");
                }
            });
    }

    function update_tbl_settlements() {
        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        var reqdata={
            objectid:$('#objectid').val(),
            id:$('#id').val(),
            name_hebrew:$('#name_hebrew').val(),
            name_english:$('#name_english').val(),
            et_id:parseInt($('#et_id').val()),
            shape_leng:parseInt($('#shape_leng').val()),
            shape_area:parseInt($('#shape_area').val()),
            gis_id:parseInt($('#gis_id').val()),
            type:$('#type').val(),
            area:parseInt($('#area').val()),
            name_arabic:$('#name_arabic').val(),
            fid:$('#hidnfid').val(),
            upgeom:JSON.stringify(hidnupdatedgeom)
        };
        $.ajax({
            type: "post",
            url: "switch_layre/update_tbl_settlements",
            data:{data:reqdata},
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }



// table tbl_area_b_violations add/update/delete
function insert_tbl_area_b_violations() {

        var hgeom=$('#hidngeom').val()

        var formData = new FormData();
        // var Attachment = $('#ins_Data_Atachment')[0].files[0];
        // console.log(Attachment)
         // Read selected files

        var totalfiles = document.getElementById('ins_uploadFile').files.length;
        for (var index = 0; index < totalfiles; index++) {
            formData.append("ins_uploadFile[]", document.getElementById('ins_uploadFile').files[index]);
        }

        // formData.append("image", Attachment);

        formData.append("fid_", $('#ins_fid_').val());
        formData.append("picture_id", $('#ins_picture_id').val());
        formData.append("categoryid", $('#ins_categoryid').val());
        formData.append("cat_eng", $('#ins_cat_eng').val());
        formData.append("desc_arb", $('#ins_desc_arb').val());
        formData.append("desc_eng", $('#ins_desc_eng').val());
        formData.append("desc_heb", $('#ins_desc_heb').val());
        formData.append("set_heb", $('#ins_set_heb').val());
        formData.append("set_arb", $('#ins_set_arb').val());
        formData.append("set_eng", $('#ins_set_eng').val());
        formData.append("pal_heb", $('#ins_pal_heb').val());
        formData.append("pal_eng", $('#ins_pal_eng').val());
        formData.append("pal_arb", $('#ins_pal_arb').val());
        formData.append("art_heb", $('#ins_art_heb').val());
        formData.append("art_eng", $('#ins_art_eng').val());
        formData.append("art_arb", $('#ins_art_arb').val());
        formData.append("titt_heb", $('#ins_titt_heb').val());
        formData.append("titt_eng", $('#ins_titt_eng').val());
        formData.append("titt_arb", $('#ins_titt_arb').val());
        formData.append("artheb1", $('#ins_artheb1').val());
        formData.append("arteng1", $('#ins_arteng1').val());
        formData.append("artarb1", $('#ins_artarb1').val());
        formData.append("tittheb1", $('#ins_tittheb1').val());
        formData.append("titteng1", $('#ins_titteng1').val());
        formData.append("tittarb1", $('#ins_tittarb1').val());

        formData.append("geom", JSON.stringify(hgeom));


     
        $.ajax({
            type: "post",
            url: "switch_layre/insert_tbl_area_b_violations",
            // dataType : "json",
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("inserted Successfully");
                    $("#insert_modal").modal("hide");
                    $('#hidngeom').val('');
                    location.reload();
                }
                else {
                    toastr.error("can't insert Error");
                }
            }
        });
    }
    // style="margin: 5px;"
    $("ins_uploadFile").change(function(){
        $('#ins_imgPreview').html("");
        var total_file=document.getElementById("ins_uploadFile").files.length;
        for(var i=0;i<total_file;i++)
        {
        $('#ins_imgPreview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
        }
    });
    $("uploadFile").change(function(){
        $('#imgPreview').html("");
        var total_file=document.getElementById("uploadFile").files.length;
        for(var i=0;i<total_file;i++)
        {
        $('#imgPreview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
        }
    });
    function editgeom_tbl_area_b_violations(id,updatedgeom) {
        // console.log(id)
        // console.log(updatedgeom)
        var hiddengeom=JSON.stringify(updatedgeom)

        $.ajax({
            type: "get",
            url: "switch_layre/editbtn_tbl_area_b_violations/"+id,
            // dataType : "json",
            success: function (res) {
                var picture_id= res.data[0].picture_id
                    console.log(res)
                    $('#fid_').val(res.data[0].fid_)
                    $('#picture_id').val(res.data[0].picture_id)
                    $('#categoryid').val(res.data[0].categoryid)
                    $('#cat_eng').val(res.data[0].cat_eng)
                    $('#desc_arb').val(res.data[0].desc_arb)
                    $('#desc_eng').val(res.data[0].desc_eng)
                    $('#desc_heb').val(res.data[0].desc_heb)
                    $('#set_heb').val(res.data[0].set_heb)
                    $('#set_arb').val(res.data[0].set_arb)
                    $('#set_eng').val(res.data[0].set_eng)
                    $('#pal_heb').val(res.data[0].pal_heb)
                    $('#pal_arb').val(res.data[0].pal_arb);
                    $('#pal_eng').val(res.data[0].pal_eng);
                    // encodeURIComponent($('#pal_eng').val(r[0].pal_eng).replace(/\'/g, "''"));
                    $('#art_heb').val(res.data[0].art_heb);
                    $('#art_eng').val(res.data[0].art_eng);
                    $('#art_arb').val(res.data[0].art_arb);
                    $('#titt_heb').val(res.data[0].titt_heb);
                    $('#titt_eng').val(res.data[0].titt_eng);
                    $('#titt_arb').val(res.data[0].titt_arb);
                    $('#artheb1').val(res.data[0].artheb1);
                    $('#arteng1').val(res.data[0].arteng1);
                    $('#artarb1').val(res.data[0].artarb1);
                    $('#tittheb1').val(res.data[0].tittheb1);
                    $('#titteng1').val(res.data[0].titteng1);
                    $('#tittarb1').val(res.data[0].tittarb1);
                    $('#hidnfid').val(res.data[0].gid);
                    $('#hidnupdatedgeom').val(hiddengeom);
                    var str='';
                    for(var i=0; i<res.imagenames.length; i++){
                        str=str+
                        '<div class="column imgcontainer">'+
                            '<img  class="thumbimg" src="http://3.17.36.216/assets/img/SettlerViolation_Pictures/'+picture_id+'/'+res.imagenames[i]+'"><br>'+
                            '<input type="checkbox" class="imgchkbox" name="img_chkbox" value="'+res.imagenames[i]+'">'+
                            // '<a href="#" class="btn btn-danger btn-sm" onclick="removeimg('+"'"+res.imagenames[i]+"'"+','+res.data[0].picture_id+')">Remove</a>'+
                        '</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'
                    }
                    $('#allimgs').html(str);
                    $("#edit_modal").modal("show");
            }
        });
    }

    function deletebtn_tbl_area_b_violations(id){
            $.ajax({
                type : "GET",
                url : 'switch_layre/deletebtn_tbl_area_b_violations/'+id,
                success:function(res){
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Deleted Successfully");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Delete ");
                    }
                }
            });
        }
    function editbtn_tbl_area_b_violations(id) {

            $.ajax({
                type: "get",
                url: "switch_layre/editbtn_tbl_area_b_violations/"+id,
                // dataType : "json",
                success: function (res) {
                    var picture_id= res.data[0].picture_id
                    console.log(res);
                    // console.log(res.imagenames[0]);
                    // var r=JSON.parse(res)
                    // console.log(r);
                    // alert(r[0].entity)
                    $('#fid_').val(res.data[0].fid_)
                    $('#picture_id').val(res.data[0].picture_id)
                    $('#categoryid').val(res.data[0].categoryid)
                    $('#cat_eng').val(res.data[0].cat_eng)
                    $('#desc_arb').val(res.data[0].desc_arb)
                    $('#desc_eng').val(res.data[0].desc_eng)
                    $('#desc_heb').val(res.data[0].desc_heb)
                    $('#set_heb').val(res.data[0].set_heb)
                    $('#set_arb').val(res.data[0].set_arb)
                    $('#set_eng').val(res.data[0].set_eng)
                    $('#pal_heb').val(res.data[0].pal_heb)
                    $('#pal_arb').val(res.data[0].pal_arb);
                    $('#pal_eng').val(res.data[0].pal_eng);
                    // encodeURIComponent($('#pal_eng').val(r[0].pal_eng).replace(/\'/g, "''"));
                    $('#art_heb').val(res.data[0].art_heb);
                    $('#art_eng').val(res.data[0].art_eng);
                    $('#art_arb').val(res.data[0].art_arb);
                    $('#titt_heb').val(res.data[0].titt_heb);
                    $('#titt_eng').val(res.data[0].titt_eng);
                    $('#titt_arb').val(res.data[0].titt_arb);
                    $('#artheb1').val(res.data[0].artheb1);
                    $('#arteng1').val(res.data[0].arteng1);
                    $('#artarb1').val(res.data[0].artarb1);
                    $('#tittheb1').val(res.data[0].tittheb1);
                    $('#titteng1').val(res.data[0].titteng1);
                    $('#tittarb1').val(res.data[0].tittarb1);
                    $('#hidnfid').val(res.data[0].gid);
                    var str='';
                    for(var i=0; i<res.imagenames.length; i++){
                        str=str+
                        '<div class="column imgcontainer">'+
                            '<img  class="thumbimg" src="http://3.17.36.216/assets/img/SettlerViolation_Pictures/'+picture_id+'/'+res.imagenames[i]+'"><br>'+
                            '<input type="checkbox" class="imgchkbox" name="img_chkbox" value="'+res.imagenames[i]+'">'+
                            // '<a href="#" class="btn btn-danger btn-sm" onclick="removeimg('+"'"+res.imagenames[i]+"'"+','+res.data[0].picture_id+')">Remove</a>'+
                        '</div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'
                    }
                    $('#allimgs').html(str);
                    $("#edit_modal").modal("show");
                }
            });
    }
    // function removeimg(imgname,pid){
    //     $.ajax({
    //       type: "post",
    //       url: "switch_layre/removeimg_tbl_area_b_violations",
    //       data:{imgname:imgname,
    //             pid:pid},
    //       success: function (res) {
    //           console.log("image deleted")
    //       }
    //     });
    // }

    function update_tbl_area_b_violations() {
        var formData = new FormData();
        // for img remove
        var imgnamesarr = [];
        $.each($("input[name='img_chkbox']:checked"), function(){            
            imgnamesarr.push($(this).val());
        });
        
        console.log(imgnamesarr);
        // for img upload
        var totalfiles = document.getElementById('update_uploadFile').files.length;
        for (var index = 0; index < totalfiles; index++) {
            formData.append("update_uploadFile[]", document.getElementById('update_uploadFile').files[index]);
        }


        var hidnupdatedgeom=$('#hidnupdatedgeom').val()
        

        formData.append("imgnamesarr", imgnamesarr);

        formData.append("fid_", $('#fid_').val());
        formData.append("picture_id", $('#picture_id').val());
        formData.append("categoryid", $('#categoryid').val());
        formData.append("cat_eng", $('#cat_eng').val());
        formData.append("desc_arb", $('#desc_arb').val());
        formData.append("desc_eng", $('#desc_eng').val());
        formData.append("desc_heb", $('#desc_heb').val());
        formData.append("set_heb", $('#set_heb').val());
        formData.append("set_arb", $('#set_arb').val());
        formData.append("set_eng", $('#set_eng').val());
        formData.append("pal_heb", $('#pal_heb').val());
        formData.append("pal_eng", $('#pal_eng').val());
        formData.append("pal_arb", $('#pal_arb').val());
        formData.append("art_heb", $('#art_heb').val());
        formData.append("art_eng", $('#art_eng').val());
        formData.append("art_arb", $('#art_arb').val());
        formData.append("titt_heb", $('#titt_heb').val());
        formData.append("titt_eng", $('#titt_eng').val());
        formData.append("titt_arb", $('#titt_arb').val());
        formData.append("artheb1", $('#artheb1').val());
        formData.append("arteng1", $('#arteng1').val());
        formData.append("artarb1", $('#artarb1').val());
        formData.append("tittheb1", $('#tittheb1').val());
        formData.append("titteng1", $('#titteng1').val());
        formData.append("tittarb1", $('#tittarb1').val());

        formData.append("gid", $('#hidnfid').val());
        formData.append("upgeom", JSON.stringify(hidnupdatedgeom));

        // var reqdata={
        //     fid_:$('#fid_').val(),
        //     picture_id:$('#picture_id').val(),
        //     categoryid:$('#categoryid').val(),
        //     cat_eng:$('#cat_eng').val(),
        //     desc_arb:$('#desc_arb').val(),
        //     desc_eng:$('#desc_eng').val(),
        //     desc_heb:$('#desc_heb').val(),
        //     set_heb:$('#set_heb').val(),
        //     set_arb:$('#set_arb').val(),
        //     set_eng:$('#set_eng').val(),
        //     pal_heb:$('#pal_heb').val(),
        //     pal_eng:$('#pal_eng').val(),
        //     pal_arb:$('#pal_arb').val(),
        //     art_heb:$('#art_heb').val(),
        //     art_eng:$('#art_eng').val(),
        //     art_arb:$('#art_arb').val(),
        //     titt_heb:$('#titt_heb').val(),
        //     titt_eng:$('#titt_eng').val(),
        //     titt_arb:$('#titt_arb').val(),
        //     artheb1:$('#artheb1').val(),
        //     arteng1:$('#arteng1').val(),
        //     artarb1:$('#artarb1').val(),
        //     tittheb1:$('#tittheb1').val(),
        //     titteng1:$('#titteng1').val(),
        //     tittarb1:$('#tittarb1').val(),
            
        //     gid:$('#hidnfid').val(),
        //     upgeom:JSON.stringify(hidnupdatedgeom)
        // };
        $.ajax({
            type: "POST",
            url: "switch_layre/update_tbl_area_b_violations",
            data: formData,
            processData: false,
            contentType: false,
            // dataType : "json",
            success: function (res) {
                var r=JSON.parse(res)
                if(r == true){
                    toastr.success("Updated Successfully");
                    $("#edit_modal").modal("hide");
                    $('#hidnupdatedgeom').val();
                    location.reload();
                }
                else {
                    toastr.error("can't Update Error");
                }
            }
        });
    }


























        function savedata() {
                var reqdata={
                    entity:$('#entity').val(),
                    layer:$('#layer').val(),
                    color:$('#color').val(),
                    linetype:$('#linetype').val(),
                    elevation:$('#elevation').val(),
                    linewt:$('#linewt').val(),
                    refname:$('#refname').val(),
                    angle:$('#angle').val(),
                    fid:$('#hidnfid').val()
                };
                $.ajax({
                    type: "get",
                    url: "switch_layre/savedata/'"+JSON.stringify(reqdata),
                    // dataType : "json",
                    success: function (res) {
                        var r=JSON.parse(res)
                        if(r == true){
                            toastr.success("Saved Successfully");
                            $("#datamodal").modal("hide");
                            location.reload();
                        }
                        else {
                            toastr.error("can't Save Error");
                        }
                    }
                });
        }

        // function validate() {

        //     var entity = $('#entity').val();
        //     var layer = $('#layer').val();
        //     var color = $('#color').val();
        //     var linetype = $('#linetype').val();
        //     var elevation = $('#elevation').val();
        //     var linewt = $('#linewt').val();
        //     var refname = $('#refname').val();
        //     var angle = $('#angle').val();
        //     if (entity == '' || layer == '' || color == null || linetype == ''|| elevation == '' || linewt == null || refname == '' || angle == '' ) {
        //         toastr.error("Please Fill All the Fields! Error");
        //         return false;
        //     }else {
        //         return true;
        //     }
        // }



        function addShapefile(file){

        var reader = new FileReader();
        reader.readAsArrayBuffer(file);
        reader.onload = function (event) {
            var data = reader.result;
            myLayers[file.name] = new L.Shapefile(data);
            var mp_array=[];
            setTimeout(function(){
                var pToMultiP=myLayers[file.name].toGeoJSON();
                for(var i=0;i<pToMultiP.features.length;i++){
                    if(pToMultiP.features[i].geometry.coordinates.length==3) {
                        pToMultiP.features[i].geometry.coordinates.pop();
                    }
                    mp_array.push(pToMultiP.features[i].geometry.coordinates)

                }

                var mp_geoJson={
                    "TYPE": "MultiPoint",
                    "coordinates": mp_array
                }
                var mp_str=JSON.stringify(mp_geoJson);
                // $("#kmlf").val(mp_str);

            },3000)

            map.addLayer(myLayers[file.name]);

                    setTimeout(function(){
                        map.fitBounds(myLayers[file.name].getBounds());

                    },300)
                }
            }


    $("#shpupbtn").on('click',function(){
    $("#myForm").trigger("reset");
    $("#shpfileuploadmodal").show();
    });
        $("#myForm").on('submit', function(e){
            e.preventDefault();
            var tablename= $("#tablename").val();
            if(tablename)
            {
                $("#shpfileuploadmodal").hide();
                var formData = new FormData(this);
                formData.append('action', 'savadata');
                // console.log(formData)
                $.ajax({
                    type: 'POST',
                    url: '/shaperead',
                    data:formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(res){
                        console.log(res);
                        var r=JSON.parse(res)
                            if(r == true){
                                toastr.success("Shape File Records inserted into Specified Table Successfully");
                                location.reload();
                            }
                            else {
                                toastr.error("Erorr!: "+r);
                            }
                    },
                    // complete: function(){
                    // alert("Data uploaded successfully.");
                    // },
                    error: function (jqXHR, textStatus, errorThrown) {
                        toastr.error("Erorr!: Schema mismatch/duplicate key value violates unique constraint");
                    }
                });
                // $("#myForm").trigger("reset");
            }
            else
            {
                toastr.error("First select Table Name then Press Save Button:  Error!");
            }
        });


    toastr.options = {
  "closeButton": true,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-bottom-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "4000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

</script>
