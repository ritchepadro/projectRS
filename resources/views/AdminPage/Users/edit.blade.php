@extends('AdminPage.Users.userMaster')
@section('users')
@include('layouts.phLocations')
<style>

/* Upload Button - Input Field */
.fileContainer {
    overflow: hidden;
    position: relative;
    background: linear-gradient(40deg, #fc8621, #f9e0ae);
    color: white;
    padding: 9px;
    border: none;
    width: 100%;
    border-radius: 50px;
}
.fileContainer:hover {
    background: linear-gradient(40deg, #fc8621, #f9e0ae);
}
.fileContainer [type=file] {
    cursor: inherit;
    display: block;
    font-size: 999px;
    filter: alpha(opacity=0);
    min-height: 100%;
    min-width: 100%;
    opacity: 0;
    position: absolute;
    right: 0;
    text-align: right;
    top: 0;
}
</style>


<link href="{{ asset('css/croppie.css') }}" rel="stylesheet" />
<script type="text/javascript" src="{{ asset('js/croppie.js') }}" defer></script>
@include('Layouts.cropImageModal')

<form method="POST" action="{{route('users.update', $user->id)}}" enctype="multipart/form-data">
    @METHOD('PUT')
    @csrf

    <div class="row">
        <div class="col-sm-6">
            <div class="DivTemplate">
                <p class="DivHeaderText center-align">USER DETAILS</p>
                <div class="hr"></div>
                <div class="form-row mb-4 mt-2">
                    <div class="form-group col-md-12">
                        <label>Username</label>
                        <input type="text"class="form-control" name="username" required value="{{$user->username}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lastName" onkeypress="return /[a-z ]/i.test(event.key)" required value="{{$user->lastName}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="firstName" onkeypress="return /[a-z ]/i.test(event.key)" required value="{{$user->firstName}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Middle Name</label>
                        <input type="text" class="form-control" name="middleName" onkeypress="return /[a-z ]/i.test(event.key)" value="{{$user->middleName}}">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Address</label>
                        <input type="text" class="form-control" name="address" value="{{$user->address}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Province</label>
                        <select name="province" id="province" class="form-control">
                            <option value="">Select...</option>
                            @foreach ($provinces as $province)
                                <option value="{{$province}}">
                                    {{$province}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>City</label>
                        <select name="city" id="city" class="form-control">
                            <option value="">Select...</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}">
                                    {{$city}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Birth Date</label>
                        <input type="date" class="form-control" name="birthDate" value="{{$user->birthDate}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Contact Number</label>
                        <input type="number" pattern="/^-?\d+\.?\d*$/" class="form-control" onKeyPress="if(this.value.length==11) return false;" name="number" value="{{$user->number}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{$user->email}}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="DivTemplate mb-2">
                <p class="DivHeaderText center-align">USER PHOTO</p>
                <div class="hr"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="p-3 ">
                            <div class="d-flex justify-content-center">
                                <img id='photoDisplay' class='mx-auto' src='{{ $user->picture!=null ? asset('images/UserPhoto/'.$user->picture) : asset('images/defaultpic.jpg') }}' style='border: 3px solid #0996c1; height: 145px; width: 145px; background-size: cover; border-radius: 50%; margin-bottom: 15px'>
                            </div>
                            <button type="button" class="fileContainer mx-auto d-block" style="width: 45%">
                                Upload Photo
                                <input type="file" name="user_photo" id="user_photo">
                            </button>
                            <input type="hidden" id='photoSaving' name="picture"  class='form-control'>
                        </div>
                    </div>
                </div>
            </div>
                <button type="submit" class="save-button mt-1" style="width:100%;">Save</button>
                <button type="button" class="back-button float-right mt-1" style="width:100%;" onclick="window.location='{{route('users.index')}}'">Back</button>
        </div>
    </div>
</form>

<script>
$(document).ready(function(){
    //Crop image
    $image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                width:200,
                height:200,
                type:'square' //circle
                },
                boundary:{
                width:300,
                height:300
                }
            });

            $('#user_photo').on('change', function(){
                var reader = new FileReader();
                reader.onload = function (event) {
                    $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
                }
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').modal('show');
            });

            $('.crop_image').click(function(event){
                $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
                }).then(function(response){
                $('#photoDisplay').attr('src', response);
                $("#photoSaving").val(response);
                $('#uploadimageModal').modal('hide');
                })
            });
            
    

    $(function () {
            $("#user_photo").change(function () {
                readURL(this);
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    //alert(e.target.result);
                    $('#Photo').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

    // load Dropdown value
    
    $('#province option[value={{$user->province}}]').attr('selected','selected');
    $('#city option[value={{$user->city}}]').attr('selected','selected');
    

});
</script>
@endsection