@extends('index')

@section('content')
<input type="hidden" id="hidnfid" /> 
<input type="hidden" id="hidden_table_name"  value="tbl_area_b_demolitions">
<!-- insert modal -->
    <div id="insert_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="width:60%;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!-- <h4 class="modal-title">Marker Feature</h4> -->
                </div>
                <div class="modal-body">
                    <form >
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                            <label for="email">Entity:</label>
                            <input type="text" class="form-control" id="ins_entity" name="entity" required>
                            </div>
                            <div class="form-group">
                            <label for="email">Layer:</label>
                            <input type="text" class="form-control" id="ins_layer"  name="layer" required>
                            </div>
                            <div class="form-group">
                            <label for="email">Color:</label>
                            <input type="number" class="form-control" id="ins_color"  name="color" required>
                            </div>
                            <div class="form-group">
                            <label for="email">Linetype:</label>
                            <input type="text" class="form-control" id="ins_linetype"  name="linetype" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                            <label for="email">Elevation:</label>
                            <input type="number" class="form-control" id="ins_elevation"  name="elevation" required>
                            </div>
                            <div class="form-group">
                            <label for="email">LineWT:</label>
                            <input type="number" class="form-control" id="ins_linewt"  name="linewt" required>
                            </div>
                            <div class="form-group">
                            <label for="email">RefName:</label>
                            <input type="text" class="form-control" id="ins_refname"  name="refname" required>
                            </div>
                            <div class="form-group">
                            <label for="email">Engle:</label>
                            <input type="number" class="form-control" id="ins_angle"  name="angle" required>
                            </div>
                        </div>
                    </div>
                        
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-success" onclick="insert_tbl_area_b_demolation()" id="insert" style="color:white;">insert</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<!-- edit modal -->
    <div id="edit_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="width:60%;">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <!-- <h4 class="modal-title">Marker Feature</h4> -->
                </div>
                <div class="modal-body">
                    <form >
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
                    <button type="button" class=" btn btn-warning" onclick="update_tbl_area_b_demolitions()" id="updatedata" style="color:white;">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<style>
    /* .btn-info, .btn-warning, .btn-danger {
        border-radius: 0px;
    } */

    thead {
        background-color: #7386d5;
        color: #fff;
    }
</style>

<table class="table table-striped" id="tbl" style="width:100%;">
    <thead>
        <tr>

            <th>
                Fid
            </th>

            <th>
                Entity
            </th>

            <th>
                Layer
            </th>

            <th>
                Color
            </th>

            <th>
                 LineType
            </th>
            <th>
                Elevation
            </th>
            <th>
                LineWT
            </th>
            <th>
                RefName
            </th>
            <th>
                Angle
            </th>
            <th>
                Action
            </th>
            


        </tr>
    </thead>
    <tbody>
    @foreach ($tbldata as $p)
            <tr>
                <td>
                    {{$p->fid}}
                </td>

                <td>
                    {{$p->entity}}
                </td>

                <td>
                    {{$p->layer}}
                </td>

                <td>
                    {{$p->color}}
                </td>

                <td>
                    {{$p->linetype}}
                </td>
                <td>
                    {{$p->elevation}}
                </td>
                <td>
                    {{$p->linewt}}
                </td>
                <td>
                    {{$p->refname}}
                </td>
                <td>
                    {{$p->angle}}
                </td>
                <td>
                    <input type="hidden" id="hidData" value="{{$geojson}}" />
                    <input type="button" class="btn btn-warning"  value="Edit" onclick="editbtn_tbl_area_b_demolitions({{$p->fid}})" />    
                    <input type="button" class="btn btn-danger" style="margin-top: 2px !important;" value="Delete" onclick="deletebtn_tbl_area_b_demolitions({{$p->fid}})" /> 
                    <input type="button" class="btn btn-success" style="margin-top: 2px !important;" value="Zoom" onclick="zoombtn_tbl_area_b_demolitions({{$p->fid}})" />   
                </td>
            </tr>
    @endforeach
          
    </tbody>
</table>

@endsection
