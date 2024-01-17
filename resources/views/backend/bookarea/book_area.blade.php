@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Add Team</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Team</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <form id="myForm" action="{{route('book.area.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{$book->id}}">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Short Title</h6>
                                </div>
                                <div class="form-group col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="short_title" id="short_title" value="{{$book->short_title}}"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Main Title</h6>
                                </div>
                                <div class="form-group col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="main_title" id="main_title" value="{{$book->main_title}}"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Short Description</h6>
                                </div>
                                <div class="form-group col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="short_desc" id="short_desc" value="{{$book->short_desc}}"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Link Url</h6>
                                </div>
                                <div class="form-group col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="link_url" id="link_url" value="{{$book->link_url}}"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Link Url</h6>
                                </div>
                                <div class="form-group col-sm-9 text-secondary">
                                    <input type="file" class="form-control" name="image" id="formFile" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0"></h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <img id="previewImage" src="{{asset($book->image)}}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                </div>
                            </div>
                            
                        </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#formFile').on('change', function(e){
                $('#previewImage').attr('src', URL.createObjectURL(e.target.files[0]));
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    name: {
                        required : true,
                    }, 
                    position: {
                        required : true,
                    }, 
                    facebook: {
                        required : true,
                    },
                    
                },
                messages :{
                    name: {
                        required : 'Name field is required',
                    }, 
                    position: {
                        required : 'Position field is required',
                    }, 
                    facebook: {
                        required : 'Facebook field is required',
                    },
                     
    
                },
                errorElement : 'span', 
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });
        
    </script>
@endsection