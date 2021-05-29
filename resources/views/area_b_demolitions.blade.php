<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" />

<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>


      <link rel="stylesheet" href="{{URL::asset('/css/kn1style.css')}}">

      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
      

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
    <div class="wrapper" >
        @include('layouts.app')

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


            <div id="datamodal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width:60%;">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <!-- <h4 class="modal-title">Marker Feature</h4> -->
                        </div>
                        <div class="modal-body">
                            <form >
                            <input type="hidden" id="hidnfid" >
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                    <label for="email">Entity:</label>
                                    <input type="text" class="form-control" id="entity" name="entity" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">Layer:</label>
                                    <input type="text" class="form-control" id="layer"  name="layer" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">Color:</label>
                                    <input type="number" class="form-control" id="color"  name="color" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">Linetype:</label>
                                    <input type="text" class="form-control" id="linetype"  name="linetype" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                    <label for="email">Elevation:</label>
                                    <input type="number" class="form-control" id="elevation"  name="elevation" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">LineWT:</label>
                                    <input type="number" class="form-control" id="linewt"  name="linewt" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">RefName:</label>
                                    <input type="text" class="form-control" id="refname"  name="refname" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">Engle:</label>
                                    <input type="text" class="form-control" id="angle"  name="angle" required>
                                    </div>
                                </div>
                            </div>
                               
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class=" btn btn-success" onclick="updatedata()" id="updatedata" style="color:white;">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="map" ></div>
             </div>
                </div>
                
                <div class="col" style="margin-bottom:10px !important;">
                <div class="clearfix"></div><br />
                    <div id="tbl_Data"></div>
                </div>
            </div>
        </div>

      


                

                
                    
                
    </div>
    </body>
</html>

<script>
   
    var gm;
            var map = L.map('map').setView([31.807491554, 35.341034188], 8);
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    setTimeout(function(){ 
        // console.log(gm)
        L.geoJSON(JSON.parse(gm)).addTo(this.map);

    //     L.geoJson(gm, {
    //     style: function(feature) {
    //       return {
    //         color: '#0515B5'
    //       };
    //     },
    //     pointToLayer: function(feature, latlng) {
    //       return new L.CircleMarker(latlng, {
    //         radius: 6,
    //         fillOpacity: 0.85
    //       });
    //     },
    //     onEachFeature: function(feature, layer) {
    //         feature.bindPopup("Name: " + feature.properties.name);
    //       document.getElementById("sname").innerHTML = feature.properties.name;
    //       feature.on({
    //         click: showData
    //       });

    //     }
    //   }).addTo(map)
    }, 2000);
   
    // function showData(e) {
    //     $("#featureModel").modal("show");
    // }

    $(document).ready(function () {
        
      


        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });

        $("#tbl").DataTable();
        loadtbledata();
       
    });
           

   function loadtbledata(){
        $.ajax({
            type : "GET", 
            url : 'switch_layre/loadtbledata/',
            success:function(res){
                $("#tbl_Data").html(res);
                $("#tbl").DataTable();

                var  geojsondata=$('#hidData').val();
                gm=JSON.parse(geojsondata);

            }
        });
    }

    function deletebtn(id){
        $.ajax({
            type : "GET", 
            url : 'switch_layre/deletedata/'+id,
            success:function(res){
                var r=JSON.parse(res)
                        if(r == true){
                            toastr.success("Deleted Successfully");
                            loadtbledata();
                        }
                        else {
                            toastr.error("can't Delete ");
                        }
                        

            }
        });
    }

        function editbtn(id) {
                
                $.ajax({
                    type: "get",
                    url: "switch_layre/editdata/"+id,
                    // dataType : "json",
                    success: function (res) {
                        var r=JSON.parse(res)
                        console.log(r);
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

        function updatedata() {
            
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
                    url: "switch_layre/updatedata/"+JSON.stringify(reqdata),
                    // dataType : "json",
                    success: function (res) {
                        var r=JSON.parse(res)
                        if(r == true){
                            toastr.success("Updated Successfully");
                            $("#datamodal").modal("hide");
                            loadtbledata();
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
                            loadtbledata();
                        }
                        else {
                            toastr.error("can't Save Error");
                        }
                    }
                });   
        }

        function validate() {

            var entity = $('#entity').val();
            var layer = $('#layer').val();
            var color = $('#color').val();
            var linetype = $('#linetype').val();
            var elevation = $('#elevation').val();
            var linewt = $('#linewt').val();
            var refname = $('#refname').val();
            var angle = $('#angle').val();
            if (entity == '' || layer == '' || color == null || linetype == ''|| elevation == '' || linewt == null || refname == '' || angle == '' ) {
                toastr.error("Please Fill All the Fields! Error");
                return false;
            }else {
                return true;
            }
        }

    


  


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
