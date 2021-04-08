@extends('AdminPage.masterAdmin')
@section('content2')


<style>

    .swal2-modal{
        margin-left:42% !important;
        margin-top:14% !important;
    }

</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <button type="button" id="sidebarCollapse" class="btn btn-primaryToggle">
        <i class="fa fa-bars"></i>
        <span class="sr-only">Toggle Menu</span>
    </button>
    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars"></i>
    </button>

    <h4 class="ml-2 mt-2">BOOKINGS</h4>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        {{-- <ul class="nav navbar-nav ml-auto">
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('booking.index') }}">All Bookings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('booking.viewToday') }}">Toda's Booking</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('booking.viewCheckedIn') }}">Checked-in</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('booking.viewHistory') }}">Checked-out</a>
        </li>
        </ul> --}}
    </div>
</div>
</nav>
<div class="container" style="margin-top:-20px;">
        <form class="form-horizontal" id="searchForm" method="POST" action="{{route('booking.searchAvailableRooms')}}">
            @csrf
            <div class="DivTemplate" id="searchDiv">
                <p class="DivHeaderText center-align">SEARCH AVAILABLE ROOM</p>
                <div class="hr"></div>
                    <div class="row mt-2 pb-2">
                        <div class="col-sm-6">
                            <label>Check-in date:</label>
                            <input id="datetimepicker3" class="form-control thisDate" type="text" name="checkinDate" autocomplete="off">
                        </div>
                        <div class="col-sm-6">
                            <label>Check-out date:</label>
                            <input id="datetimepicker4" class="form-control thisDate" type="text" name="checkoutDate" autocomplete="off">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <label>Number of guest:</label>
                            <input type="number" id="numberOfGuest" class="form-control" name="numberOfGuest" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <button class="save-button float-left" type="button" onclick="searchEffect()">Search</button>
                            <button class="back-button float-right" type="button" onclick="window.location='{{ route('booking.index') }}'">Cancel</button>
                        </div>
                    </div>
                </div>
        </form>
</div>

<script>
    $(document).ready(function(){
        
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        $('#datetimepicker3').datetimepicker({
            minDate: today, //today is minimum date
            format:'M j,Y g:i A',
        });

        $('#datetimepicker4').datetimepicker({
            minDate: today, //today is minimum date
            format:'M j,Y g:i A',
        });

        $('#datetimepicker3').change(function(){
            datePicker4($(this).val());
        });

    });

    function datePicker4(thisVal){
        var today = new Date(thisVal);
        $('#datetimepicker4').val("");
        $('#datetimepicker4').datetimepicker({
            minDate: today, //today is minimum date
            format:'M j,Y g:i A',
        });
    }

    function searchEffect(){

      if($('#datetimepicker3').val() == ""){
            Swal.fire('Check-in date is Required.');
      }else if($('#datetimepicker4').val() == ""){
            Swal.fire('Check-out date is Required.');
      }else if($('#numberOfGuest').val() == ""){
            Swal.fire('Number of guest is Required.');
      }else{
          $('#searchDiv').hide();
        let timerInterval
        Swal.fire({
            title: 'Search Available Room...',
            html: 'Searching <b></b> .',
            timer: 2000,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                timerInterval = setInterval(() => {
                const content = Swal.getContent()
                if (content) {
                    const b = content.querySelector('b')
                    if (b) {
                    b.textContent = Swal.getTimerLeft()
                    }
                }
                }, 100)
            },
            willClose: () => {
                clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            $('#searchForm').submit();
        });
      }
        
    }
</script>

@endsection