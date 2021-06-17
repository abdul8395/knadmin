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




      <link rel="stylesheet" href="{{URL::asset('/css/kn1style.css')}}">

      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  
  <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="{{URL::asset('draw/leaflet.draw.css')}}"/>

  
      

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
    <div class="wrapper" >
        @include('sidebarlayres')

        <!-- Page Content  -->
        <div id="content">

            <div class="row">
                <div class="col">
      <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid"> -->
<!-- 
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button> -->

                    <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                        </ul>
                    </div> -->
                <!-- </div>
            </nav> -->
            <!-- <hr style="margin-top 0px !important; height:10px;border-width:0;color:gray;background-color:#7386D5;"> -->


            
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
                                        <!-- <div class="form-group row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Data Name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="des" name="des" placeholder="Data Discription" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="crs" name="crs" placeholder="CRS:4326" required>
                                            </div>
                                        </div> -->
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
                                        <!-- <button id="close_btn"  class="btn btn-danger pull-right">Cancel</button> -->
                                        <!--                <button class="btn btn-danger btnCancel">Cancel</button>-->
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

      


                

                
                    
                
    </div>
    </body>
</html>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<script src="{{URL::asset('draw/leaflet.draw-custom.js')}}"></script>
<script src="{{URL::asset('shapefilelib/shp.js')}}"></script>
<script src="{{URL::asset('shapefilelib/leaflet.shpfile.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
      


<script>
   var geom
    var gm;
            var map = L.map('map').setView([31.807491554, 35.341034188], 8);
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

       var drawnItems = L.featureGroup().addTo(map);
        redliningDrawControl = new L.Control.Draw({
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
            $("#insert_area_b_demo_modal").modal("show");
            
            
        });

        map.on('draw:edited', function (e) {
            var layers = e.layers;
            var json_data= layers.toGeoJSON();
                    data=json_data;
                    var updated_geom=data.features[0].geometry;
                    var id=data.features[0].id
                    // console.log(updated_geom);
                    editgeom_tbl_area_b_demolitions(id, updated_geom)
        });

    setTimeout(function(){ 
        // console.log(gm)
        //L.geoJSON(JSON.parse(gm)).addTo(this.map);

        L.geoJSON(JSON.parse(gm), {
                onEachFeature: function (feature, layer) {
                    layer.on('click', function (e) {
                        drawnItems.addLayer(layer);
                        // var tbl= '<table class="table_draw" id="tbl_Info"></table>' +
                        //     '<table><tr><td></td><td></td><td></td><td></table>';
                        // layer.bindPopup(tbl, {
                        //     minWidth : 300
                        // });
                    });
                }
            }).addTo(this.map);
    }, 2000);


    $(document).ready(function () {
        $("#close_btn").on("click", function () {
                $("#shpfileuploadmodal").hide();
            });
        
        var  geojsondata=$('#hidData').val();
                gm=JSON.parse(geojsondata);


        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $('#tbl').DataTable( {
        "lengthMenu": [[2, 10, 25, -1], [2, 10, 25, "All"]]
        } );
    });
           


        function insert_area_b_demolation() {
            var hgeom=$('#hidngeom').val()
            // console.log(hgeom)
            // var hg=JSON.stringify(hgeom)
            // console.log(hg)
            //var g = encodeURIComponent(hgeom);
           // console.log(g)
            
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
                        $("#datamodal").modal("hide");
                        location.reload();
                    }
                    else {
                        toastr.error("can't insert Error");
                    }
                }
            });   
        }
       
        function editgeom_tbl_area_b_demolitions(id,updatedgeom) {
                console.log(id)
                console.log(updatedgeom)
                var hg=JSON.stringify(updatedgeom)

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
                            $('#hidnupdatedgeom').val(hg);
                            $("#datamodal").modal("show");
                    }
                });   
        }
// table tbl_area_b_nature_reserve update/delete
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
                            $("#datamodal").modal("show");
                    }
                });   
        }

        function updat_tbl_area_b_nature_reserve() {
            
                var reqdata={
                    objectid:$('#objectid').val(),
                    class:$('#class').val(),
                    shape_leng:$('#shape_leng').val(),
                    shape_area:$('#shape_area').val(),
                    fid:$('#hidnfid').val()
                };
                $.ajax({
                    type: "get",
                    url: "switch_layre/updat_tbl_area_b_nature_reserve/"+JSON.stringify(reqdata),
                    // dataType : "json",
                    success: function (res) {
                        var r=JSON.parse(res)
                        if(r == true){
                            toastr.success("Updated Successfully");
                            $("#datamodal").modal("hide");
                        }
                        else {
                            toastr.error("can't Update Error");
                        }
                    }
                });   
        }

// table tbl_area_b_demolitions update/delete

        
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
                            $("#datamodal").modal("show");
                    }
                });   
        }

        function update_tbl_area_b_demolitions() {
            var upg=$('#hidnupdatedgeom').val()

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
                upgeom:JSON.stringify(upg)
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
                        $("#datamodal").modal("hide");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Update Error");
                    }
                }
            });   
        }

// table tbl_area_a_and_b_combined
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
                            $("#datamodal").modal("show");
                    }
                });   
        }

        function updat_tbl_area_a_and_b_combined() {
        //    var a= $("#hidnfid").val();
        //     alert(a);
            var reqdata={
                class:$('#class').val(),
                fid:$('#hidnfid').val()
            };
            $.ajax({
                type: "get",
                url: "switch_layre/updat_tbl_area_a_and_b_combined/"+JSON.stringify(reqdata),
                // dataType : "json",
                success: function (res) {
                    var r=JSON.parse(res)
                    if(r == true){
                        toastr.success("Updated Successfully");
                        $("#datamodal").modal("hide");
                        location.reload();
                    }
                    else {
                        toastr.error("can't Update Error");
                    }
                }
            });   
        }

// table tbl_area_a_area_b_nature_reserve update/delete
function deletebtn_tbl_area_a_area_b_nature_reserve(id){
                $.ajax({
                    type : "GET", 
                    url : 'switch_layre/deletebtn_tbl_area_a_area_b_nature_reserve/'+id,
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
        function editbtn_tbl_area_a_area_b_nature_reserve(id) {
            
                $.ajax({
                    type: "get",
                    url: "switch_layre/editbtn_tbl_area_a_area_b_nature_reserve/"+id,
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
                            $("#datamodal").modal("show");
                    }
                });   
        }

        function updat_tbl_area_a_area_b_nature_reserve() {
            
                var reqdata={
                    objectid:$('#objectid').val(),
                    class:$('#class').val(),
                    shape_leng:$('#shape_leng').val(),
                    shape_area:$('#shape_area').val(),
                    fid:$('#hidnfid').val()
                };
                $.ajax({
                    type: "get",
                    url: "switch_layre/updat_tbl_area_a_area_b_nature_reserve/"+JSON.stringify(reqdata),
                    // dataType : "json",
                    success: function (res) {
                        var r=JSON.parse(res)
                        if(r == true){
                            toastr.success("Updated Successfully");
                            $("#datamodal").modal("hide");
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
