
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
                    <input type="hidden" id="hidfid" />   
                    <input type="button" class="btn btn-warning"  value="Edit" onclick="editbtn({{$p->fid}})" />    
                    <input type="button" class="btn btn-danger" style="margin-top: 2px !important;" value="Delete" onclick="deletebtn({{$p->fid}})" />    
                </td>
            </tr>
    @endforeach
          
    </tbody>
</table>
