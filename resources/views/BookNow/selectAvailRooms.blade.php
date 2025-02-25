@extends('BookNow.bookNowMaster')
@section('content')
<style>
    .save-button {
    background-color: #4cbb17;
    border: none;
    color: white;
    padding: 9px;
    font-size: 16px;
    cursor: pointer;
    width: 120px;
    font-weight: 500;
    letter-spacing: 0.5px;
    border-radius: 3px;
    }
    .save-button:hover{
        background-color: #00a86b;
    }
    
    .DivHeaderText{
        font-weight: 500;
        color: #676767;
    }

    .thead-bg{
    color: #fc8621;
    background-color: #ffffff;
    text-align: center;
    }
    table.dataDisplayer td {
        font-weight:bold;
        letter-spacing: 0.5px;
        font-size: 13px;
        color: rgb(30,30,30, 0.9);
        text-align: center;
    }
    .th-border{
        border: 1px solid #ebebeb !important;
        font-weight: 600 !important;
        letter-spacing: 1px !important;
    }
    .td-border{
        border: 1px solid #ebebeb !important;
    }
    tbody.tbody-bg{
        background-color: #ffffff;
        text-align: center;
    }
    .back-button {
    background-color: #f05e23;
    border: none;
    color: white;
    padding: 9px; 
    font-size: 16px;
    cursor: pointer;
    width: 120px;
    font-weight: 500;
    letter-spacing: 0.5px;
    border-radius: 3px;
    float: right;
    }
    .back-button:hover{
        background-color: #fc8621 !important;
    }  
</style>


<div class="container-fluid" style="padding-left: 150px;padding-right: 150px">
        <div class="row">
            <div class="col-sm-9"  style="margin-top: 50px; ">
            <div style="background: whitesmoke;  border-radius: 10px;" class="mt-4">
                    <div class="form-row px-3 pt-3">
                        <div class="form-group col-sm-12">
                            <span class="DivHeaderText center-align">Available Rooms From {{date_format(\Carbon\Carbon::parse($dateID),"M j,Y g:i A")}} to {{date_format(\Carbon\Carbon::parse($dateOD),"M j,Y g:i A")}} </span>
                            <div style=" border: 1px solid #fc8621 !important; margin-top: 5px"></div>
                        </div>
                    </div>
            <form class="form-horizontal" method="POST" action="{{ route('bookingHome.createBookingHome')}}" id="BookForm">
                @csrf
                <input type="hidden" name="checkIN" value="{{$dateID}}">
                <input type="hidden" name="checkOUT" value="{{$dateOD}}">
                    <div class="table-responsive mt-1 px-3">
                        <table id="TblSorter" class="table dataDisplayer table-hover" style="width:100%">
                            <thead class="thead-bg">
                                <tr>
                                    <th class="th-sm th-border">Room #</th>
                                    <th class="th-sm th-border">Room Name</th>
                                    <th class="th-sm th-border">Room Price</th>
                                    <th class="th-sm th-border" width="100px">Capacity</th>
                                    <th class="th-sm th-border" width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tbody-bg">
                                @foreach($roomListData as $data)
                                    <tr class="data font-weight-bold">
                                        <input type="hidden" class="roomId" value="{{$data->id}}">
                                        <td class="td-border">
                                            {{$data->roomNumber}}
                                        </td>
                                        <td class="td-border">
                                            {{$data->roomType}}
                                        </td>
                                        <td class="td-border">
                                            ₱{{$data->price}} By {{$data->roomRate}} Hours
                                        </td>
                                        <td class="td-border">
                                            {{$data->capacity}}
                                        </td>
                                        <td class="td-border">
                                            <input type="checkbox" onchange="roomCheck(this)">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="form-row px-3 pt-3">
                        <div class="form-group col-sm-12">
                            <button class="save-button" style="width:100%;" type="button" onclick="submitForm()">Next</button>
                            <button class="back-button mt-2" style="width:100%;" type="button" onclick="window.location='{{ route('bookingHome.create') }}'">Search Again</button>
                        </div>
                    </div>  
            </div>
            </div>
            <div class="col-sm" style="margin-top: 200px; margin-left: 57px; color: whitesmoke">
                <p class="p-0 m-0" style="font-size: 65px; font-weight: 700; text-shadow: 2px 2px rgb(46, 46, 46);">PLEASE SELECT</p>
                <p class="m-0 p-0" style="font-size: 32px; font-weight: 700; text-shadow: 2px 2px rgb(46, 46, 46);">YOUR DESIRED ROOMS</p>
                {{-- <h3>lorem ipsum dolor</h3> --}}
            </div>
            </form>
        </div>
    </div>
        
<script>
    $(document).ready(function(){
        $('#TblSorter').DataTable({
            "bPaginate": false
        });
    });
    
    roomsCount = 0;
    
    function roomCheck(thisBtn){
        var roomId = $(thisBtn).closest("tr").find('.roomId');
    
        if ($(thisBtn).is(':checked')) {
            roomsCount++;
                roomId.attr('name', 'rooms['+roomsCount+'][roomId]');
        } else {
            roomsCount--;
                roomId.removeAttr('name');
        }
    }
    
    function submitForm(){
        if(roomsCount != 0){
            $('#BookForm').submit();
        }else{
            Swal.fire('Please Select Room First.');
        }
        
    }
    </script>
@endsection
