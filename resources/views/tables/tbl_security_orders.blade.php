﻿@extends('index')

@section('content')
    <input type="hidden" id="hidnfid" /> 
    <input type="hidden" id="hidden_table_name"  value="tbl_security_orders">
 <!--Insert  Modal -->
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
                        <label for="email">id:</label>
                        <input type="number" class="form-control" id="ins_id"  name="id" required>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class=" btn btn-success" onclick="insert_tbl_security_orders()" id="updatedata" style="color:white;">insert</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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
                        <label for="email">id:</label>
                        <input type="number" class="form-control" id="id"  name="id" required>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class=" btn btn-warning" onclick="update_tbl_security_orders()" id="updatedata" style="color:white;">Update</button>
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
                id 
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
                    {{$p->id}}
                </td>


                <td>
                    <input type="hidden" id="hidData" value="{{$geojson}}" />
                    <input type="hidden" id="hidnfid" />   
                    <input type="button" class="btn btn-warning"  value="Edit" onclick="editbtn_tbl_security_orders({{$p->fid}})" />    
                    <input type="button" class="btn btn-danger" style="margin-top: 2px !important;" value="Delete" onclick="deletebtn_tbl_security_orders({{$p->fid}})" />  
                    <input type="button" class="btn btn-success" style="margin-top: 2px !important;" value="Zoom" onclick="zoombtn_tbl_security_orders({{$p->fid}})" />  
                </td>
            </tr>
    @endforeach
          
    </tbody>
</table>

@endsection
