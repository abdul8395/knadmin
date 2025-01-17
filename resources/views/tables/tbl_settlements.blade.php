﻿@extends('index')

@section('content')
<input type="hidden" id="hidnfid" /> 
<input type="hidden" id="hidden_table_name"  value="tbl_settlements">
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
                    <form id="modalform">
                    <div class="row">
                    <div class="col">
                            <div class="form-group">
                            <label for="email">objectid:</label>
                            <input type="number" class="form-control" id="ins_objectid" name="objectid" required>
                            </div>
                            <div class="form-group">
                            <label for="email">id:</label>
                            <input type="number" class="form-control" id="ins_id"  name="id" required>
                            </div>
                            <div class="form-group">
                            <label for="email">name_hebrew:</label>
                            <input type="text" class="form-control" id="ins_name_hebrew"  name="name_hebrew" required>
                            </div>
                            <div class="form-group">
                            <label for="email">name_english:</label>
                            <input type="text" class="form-control" id="ins_name_english"  name="name_english" required>
                            </div>
                            <div class="form-group">
                            <label for="email">et_id:</label>
                            <input type="number" class="form-control" id="ins_et_id"  name="et_id" required>
                            </div>
                            <div class="form-group">
                            <label for="email">shape_leng:</label>
                            <input type="number" class="form-control" id="ins_shape_leng"  name="shape_leng" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                            <label for="email">shape_area:</label>
                            <input type="number" class="form-control" id="ins_shape_area"  name="shape_area" required>
                            </div>
                            <div class="form-group">
                            <label for="email">gis_id:</label>
                            <input type="number" class="form-control" id="ins_gis_id"  name="gis_id" required>
                            </div>
                            <div class="form-group">
                            <label for="email">type:</label>
                            <input type="text" class="form-control" id="ins_type"  name="type" required>
                            </div>
                            <div class="form-group">
                            <label for="email">area:</label>
                            <input type="number" class="form-control" id="ins_area"  name="area" required>
                            </div>
                            <div class="form-group">
                            <label for="email">name_arabic:</label>
                            <input type="text" class="form-control" id="ins_name_arabic"  name="name_arabic" required>
                            </div>
                        </div>
                    </div>
                        
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class=" btn btn-success" onclick="insert_tbl_settlements()" id="insert" style="color:white;">insert</button>
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
                    <form id="modalform">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                            <label for="email">objectid:</label>
                            <input type="number" class="form-control" id="objectid" name="objectid" required>
                            </div>
                            <div class="form-group">
                            <label for="email">id:</label>
                            <input type="number" class="form-control" id="id"  name="id" required>
                            </div>
                            <div class="form-group">
                            <label for="email">name_hebrew:</label>
                            <input type="text" class="form-control" id="name_hebrew"  name="name_hebrew" required>
                            </div>
                            <div class="form-group">
                            <label for="email">name_english:</label>
                            <input type="text" class="form-control" id="name_english"  name="name_english" required>
                            </div>
                            <div class="form-group">
                            <label for="email">et_id:</label>
                            <input type="number" class="form-control" id="et_id"  name="et_id" required>
                            </div>
                            <div class="form-group">
                            <label for="email">shape_leng:</label>
                            <input type="number" class="form-control" id="shape_leng"  name="shape_leng" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                            <label for="email">shape_area:</label>
                            <input type="number" class="form-control" id="shape_area"  name="shape_area" required>
                            </div>
                            <div class="form-group">
                            <label for="email">gis_id:</label>
                            <input type="number" class="form-control" id="gis_id"  name="gis_id" required>
                            </div>
                            <div class="form-group">
                            <label for="email">type:</label>
                            <input type="text" class="form-control" id="type"  name="type" required>
                            </div>
                            <div class="form-group">
                            <label for="email">area:</label>
                            <input type="number" class="form-control" id="area"  name="area" required>
                            </div>
                            <div class="form-group">
                            <label for="email">name_arabic:</label>
                            <input type="text" class="form-control" id="name_arabic"  name="name_arabic" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class=" btn btn-warning" onclick="update_tbl_settlements()" id="updatedata" style="color:white;">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    </form>
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
                objectid
            </th>

            <th>
                id
            </th>

            <th>
                name_hebrew
            </th>

            <th>
                name_english
            </th>
            <th>
                et_id
            </th>
            <th>
                shape_leng
            </th>
            <th>
                shape_area
            </th>
            <th>
                gis_id
            </th>
            <th>
                type
            </th>
            <th>
                area
            </th>
            <th>
                name_arabic
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
                    {{$p->objectid}}
                </td>

                <td>
                    {{$p->id}}
                </td>

                <td>
                    {{$p->name_hebrew}}
                </td>

                <td>
                    {{$p->name_english}}
                </td>
                <td>
                    {{$p->et_id}}
                </td>
                <td>
                    {{$p->shape_leng}}
                </td>
                <td>
                    {{$p->shape_area}}
                </td>
                <td>
                    {{$p->gis_id}}
                </td>
                <td>
                    {{$p->type}}
                </td>
                <td>
                    {{$p->area}}
                </td>
                <td>
                    {{$p->name_arabic}}
                </td>
                <td>
                    <input type="hidden" id="hidData" value="{{$geojson}}" />
                    <input type="button" class="btn btn-warning"  value="Edit" onclick="editbtn_tbl_settlements({{$p->fid}})" />    
                    <input type="button" class="btn btn-danger" style="margin-top: 2px !important;" value="Delete" onclick="deletebtn_tbl_settlements({{$p->fid}})" /> 
                    <input type="button" class="btn btn-success" style="margin-top: 2px !important;" value="Zoom" onclick="zoombtn_tbl_settlements({{$p->fid}})" />   
                </td>
            </tr>
    @endforeach
          
    </tbody>
</table>

@endsection
