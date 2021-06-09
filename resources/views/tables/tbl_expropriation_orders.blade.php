@extends('index')

@section('content')

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
                                    <label for="email">id:</label>
                                    <input type="text" class="form-control" id="id" name="id" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">reason:</label>
                                    <input type="text" class="form-control" id="reason"  name="reason" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">title:</label>
                                    <input type="text" class="form-control" id="title"  name="title" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">sign_date:</label>
                                    <input type="text" class="form-control" id="sign_date"  name="sign_date" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">remark:</label>
                                    <input type="text" class="form-control" id="remark"  name="remark" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">created_us:</label>
                                    <input type="text" class="form-control" id="created_us"  name="created_us" required>
                                    </div>
                                   
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                    <label for="email">created_da:</label>
                                    <input type="number" class="form-control" id="created_da"  name="created_da" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">last_edite:</label>
                                    <input type="number" class="form-control" id="last_edite"  name="last_edite" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">last_edi_1:</label>
                                    <input type="number" class="form-control" id="last_edi_1"  name="last_edi_1" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">shape_leng:</label>
                                    <input type="number" class="form-control" id="shape_leng"  name="shape_leng" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">shape_area:</label>
                                    <input type="number" class="form-control" id="shape_area"  name="shape_area" required>
                                    </div>
                                    <div class="form-group">
                                    <label for="email">d_reason:</label>
                                    <input type="number" class="form-control" id="d_reason"  name="d_reason" required>
                                    </div>
                                   
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                    <label for="email">d_district:</label>
                                    <input type="number" class="form-control" id="d_district"  name="d_district" required>
                                    </div>
                                </div>
                                
                            </div>
                               
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class=" btn btn-warning" onclick="updat_tbl_expropriation_orders()" id="updatedata" style="color:white;">Update</button>
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
                id 
            </th>

            <th>
                reason
            </th>

            <th>
                title
            </th>

            <th>
                sign_date
            </th>

            <th>
                district
            </th>
            <th>
            remark
            </th>
            <th>
            created_us
            </th>
            <th>
            created_da
            </th>
            <th>
            last_edite
            </th>
            <th>
            last_edi_1
            </th>
            <th>
            shape_leng
            </th>
            <th>
            shape_area
            </th>
            <th>
            d_reason
            </th>
            <th>
            d_district
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
                    {{$p->id}}
                </td>

                <td>
                    {{$p->reason}}
                </td>

                <td>
                    {{$p->title}}
                </td>

                <td>
                    {{$p->sign_date}}
                </td>
                <td>
                    {{$p->district}}
                </td>
                <td>
                    {{$p->remark}}
                </td>
                <td>
                    {{$p->created_us}}
                </td>
                <td>
                    {{$p->created_da}}
                </td>
                <td>
                    {{$p->last_edite}}
                </td>
                <td>
                    {{$p->last_edi_1}}
                </td>
                <td>
                    {{$p->shape_leng}}
                </td>
                <td>
                    {{$p->shape_area}}
                </td>
                <td>
                    {{$p->d_reason}}
                </td>
                <td>
                    {{$p->d_district}}
                </td>
                <td>
                    <input type="hidden" id="hidData" value="{{$geojson}}" />
                    <input type="hidden" id="hidnfid" />   
                    <input type="button" class="btn btn-warning"  value="Edit" onclick="editbtn_tbl_expropriation_orders({{$p->id}})" />    
                    <input type="button" class="btn btn-danger" style="margin-top: 2px !important;" value="Delete" onclick="deletebtn_tbl_expropriation_orders({{$p->id}})" />    
                </td>
            </tr>
    @endforeach
          
    </tbody>
</table>

@endsection
