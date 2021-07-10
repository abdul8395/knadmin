@extends('index')

@section('content')
<input type="hidden" id="hidnfid" /> 
<input type="hidden" id="hidden_table_name"  value="tbl_area_b_violations">
<!-- insert modal -->
    <div id="insert_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" style="width:60%;">
            <!-- Modal content-->
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <!-- <h4 class="modal-title">Marker Feature</h4> -->
                <!-- </div> -->
                <div class="modal-body">
                    <form>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label for="email">fid_:</label>
                            <input type="number" class="form-control" id="ins_fid_" name="fid_" required>
                            </div>
                            <div class="form-group">
                            <label for="email">picture_id:</label>
                            <input type="number" class="form-control" id="ins_picture_id"  name="picture_id" required>
                            </div>
                            <div class="form-group">
                            <label for="email">categoryid:</label>
                            <input type="number" class="form-control" id="ins_categoryid"  name="categoryid" required>
                            </div>
                            <div class="form-group">
                            <label for="email">cat_eng:</label>
                            <input type="text" class="form-control" id="ins_cat_eng"  name="cat_eng" required>
                            </div>
                            <div class="form-group">
                            <label for="email">desc_arb:</label>
                            <input type="text" class="form-control" id="ins_desc_arb"  name="desc_arb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">desc_eng:</label>
                            <input type="text" class="form-control" id="ins_desc_eng"  name="desc_eng" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label for="email">desc_heb:</label>
                            <input type="text" class="form-control" id="ins_desc_heb"  name="desc_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">set_heb:</label>
                            <input type="text" class="form-control" id="ins_set_heb"  name="set_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">set_arb:</label>
                            <input type="text" class="form-control" id="ins_set_arb"  name="set_arb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">set_eng:</label>
                            <input type="text" class="form-control" id="ins_set_eng"  name="set_eng" required>
                            </div>
                            <div class="form-group">
                            <label for="email">pal_heb:</label>
                            <input type="text" class="form-control" id="ins_pal_heb"  name="pal_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">pal_arb:</label>
                            <input type="text" class="form-control" id="ins_pal_arb"  name="pal_arb" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label for="email">pal_eng:</label>
                            <input type="text" class="form-control" id="ins_pal_eng"  name="pal_eng" required>
                            </div>
                            <div class="form-group">
                            <label for="email">art_heb:</label>
                            <input type="text" class="form-control" id="ins_art_heb"  name="art_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">art_eng:</label>
                            <input type="text" class="form-control" id="ins_art_eng"  name="art_eng" required>
                            </div>
                            <div class="form-group">
                            <label for="email">art_arb:</label>
                            <input type="text" class="form-control" id="ins_art_arb"  name="art_arb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">titt_heb:</label>
                            <input type="text" class="form-control" id="ins_titt_heb"  name="titt_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">titt_eng:</label>
                            <input type="text" class="form-control" id="ins_titt_eng"  name="titt_eng" required>
                            </div>
                            
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label for="email">titt_arb:</label>
                            <input type="text" class="form-control" id="ins_titt_arb"  name="titt_arb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">artheb1:</label>
                            <input type="text" class="form-control" id="ins_artheb1"  name="artheb1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">arteng1:</label>
                            <input type="text" class="form-control" id="ins_arteng1"  name="arteng1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">artarb1:</label>
                            <input type="text" class="form-control" id="ins_artarb1"  name="artarb1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">tittheb1:</label>
                            <input type="text" class="form-control" id="ins_tittheb1"  name="tittheb1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">titteng1:</label>
                            <input type="text" class="form-control" id="ins_titteng1"  name="titteng1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">tittarb1:</label>
                            <input type="text" class="form-control" id="ins_tittarb1"  name="tittarb1" required>
                            </div>
                        </div>
                            <div class="form-group">
                            <label for="file">Select image</label>
                            <input type='file' id="ins_Data_Atachment" name="file" accept="image/*" class='btn btn-default' />
                            </div>
                    </div>
                        
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-success" onclick="insert_tbl_area_b_violations()" id="insert" style="color:white;">insert</button>
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
                <!-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <!-- <h4 class="modal-title">Marker Feature</h4> -->
                <!-- </div> -->
                <div class="modal-body">
                  
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label for="email">fid_:</label>
                            <input type="number" class="form-control" id="fid_" name="fid_" required>
                            </div>
                            <div class="form-group">
                            <label for="email">picture_id:</label>
                            <input type="number" class="form-control" id="picture_id"  name="picture_id" required>
                            </div>
                            <div class="form-group">
                            <label for="email">categoryid:</label>
                            <input type="number" class="form-control" id="categoryid"  name="categoryid" required>
                            </div>
                            <div class="form-group">
                            <label for="email">cat_eng:</label>
                            <input type="text" class="form-control" id="cat_eng"  name="cat_eng" required>
                            </div>
                            <div class="form-group">
                            <label for="email">desc_arb:</label>
                            <input type="text" class="form-control" id="desc_arb"  name="desc_arb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">desc_eng:</label>
                            <input type="text" class="form-control" id="desc_eng"  name="desc_eng" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label for="email">desc_heb:</label>
                            <input type="text" class="form-control" id="desc_heb"  name="desc_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">set_heb:</label>
                            <input type="text" class="form-control" id="set_heb"  name="set_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">set_arb:</label>
                            <input type="text" class="form-control" id="set_arb"  name="set_arb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">set_eng:</label>
                            <input type="text" class="form-control" id="set_eng"  name="set_eng" required>
                            </div>
                            <div class="form-group">
                            <label for="email">pal_heb:</label>
                            <input type="text" class="form-control" id="pal_heb"  name="pal_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">pal_arb:</label>
                            <input type="text" class="form-control" id="pal_arb"  name="pal_arb" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label for="email">pal_eng:</label>
                            <input type="text" class="form-control" id="pal_eng"  name="pal_eng" required>
                            </div>
                            <div class="form-group">
                            <label for="email">art_heb:</label>
                            <input type="text" class="form-control" id="art_heb"  name="art_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">art_eng:</label>
                            <input type="text" class="form-control" id="art_eng"  name="art_eng" required>
                            </div>
                            <div class="form-group">
                            <label for="email">art_arb:</label>
                            <input type="text" class="form-control" id="art_arb"  name="art_arb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">titt_heb:</label>
                            <input type="text" class="form-control" id="titt_heb"  name="titt_heb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">titt_eng:</label>
                            <input type="text" class="form-control" id="titt_eng"  name="titt_eng" required>
                            </div>
                            
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label for="email">titt_arb:</label>
                            <input type="text" class="form-control" id="titt_arb"  name="titt_arb" required>
                            </div>
                            <div class="form-group">
                            <label for="email">artheb1:</label>
                            <input type="text" class="form-control" id="artheb1"  name="artheb1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">arteng1:</label>
                            <input type="text" class="form-control" id="arteng1"  name="arteng1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">artarb1:</label>
                            <input type="text" class="form-control" id="artarb1"  name="artarb1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">tittheb1:</label>
                            <input type="text" class="form-control" id="tittheb1"  name="tittheb1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">titteng1:</label>
                            <input type="text" class="form-control" id="titteng1"  name="titteng1" required>
                            </div>
                            <div class="form-group">
                            <label for="email">tittarb1:</label>
                            <input type="text" class="form-control" id="tittarb1"  name="tittarb1" required>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-left: 20px !important;" id="allimgs">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-warning" onclick="update_tbl_area_b_violations()" id="updatedata" style="color:white;">Update</button>
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
                gid
            </th>
            <th>
                fid_
            </th>

            <th>
                picture_id
            </th>

            <th>
                categoryid
            </th>

            <th>
                cat_eng
            </th>

            <th>
                desc_eng
            </th>
            <th>
                set_eng
            </th>
            <th>
                pal_eng
            </th>
            <th>
                art_eng
            </th>
            <th>
                titt_eng
            </th>
            <th>
                arteng1
            </th>
            <th>
                titteng1
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
                    {{$p->gid}}
                </td>

                <td>
                    {{$p->fid_}}
                </td>

                <td>
                    {{$p->picture_id}}
                </td>

                <td>
                    {{$p->categoryid}}
                </td>

                <td>
                    {{$p->cat_eng}}
                </td>
                <td>
                    {{$p->desc_eng}}
                </td>
                <td>
                    {{$p->set_eng}}
                </td>
                <td>
                    {{$p->pal_eng}}
                </td>
                <td>
                    {{$p->art_eng}}
                </td>
                <td>
                    {{$p->titt_eng}}
                </td>
                <td>
                    {{$p->arteng1}}
                </td>
                <td>
                    {{$p->titteng1}}
                </td>
                <td>
                    <input type="hidden" id="hidData" value="{{$geojson}}" />
                    <input type="button" class="btn btn-warning"  value="Edit" onclick="editbtn_tbl_area_b_violations({{$p->gid}})" />    
                    <input type="button" class="btn btn-danger" style="margin-top: 2px !important;" value="Delete" onclick="deletebtn_tbl_area_b_violations({{$p->gid}})" /> 
                    <input type="button" class="btn btn-success" style="margin-top: 2px !important;" value="Zoom" onclick="zoombtn_tbl_area_b_violations({{$p->gid}})" />   
                </td>
            </tr>
    @endforeach
          
    </tbody>
</table>

@endsection
