@extends('layouts.admin.app')

@section('title', translate('Update Organization'))

@section('content')
    <div class="content container-fluid">

        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/store.png')}}" alt="{{ translate('organization') }}">
            <h2 class="page-header-title">{{translate('Update Organization')}}</h2>
        </div>

        <div class="card card-body">
            <form action="{{route('admin.organization.update', $user->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Organization Name')}}</label>
                            <input type="text" name="org_name" class="form-control" value="{{ $organization->org_name }}"
                                    placeholder="{{translate('Organization Name')}}" required>
                        </div>
                    </div>
 
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('email')}}
                                <small class="text-muted">({{translate('optional')}})</small></label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                    placeholder="{{translate('Ex : ex@example.com')}}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <label class="input-label" for="exampleFormControlInput1">{{translate('Password')}}</label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" class="js-toggle-password form-control form-control input-field"
                                    placeholder="{{translate('8 digit password')}}" minlength="8"
                                    data-hs-toggle-password-options='{
                                        "target": "#changePassTarget",
                                        "defaultClass": "tio-hidden-outlined",
                                        "showClass": "tio-visible-outlined",
                                        "classChangeTarget": "#changePassIcon"
                                        }'>
                            <div id="changePassTarget" class="input-group-append">
                                <a class="input-group-text" href="javascript:">
                                    <i id="changePassIcon" class="tio-visible-outlined"></i>
                                </a>
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Address')}}</label>
                            <input type="text" name="address" class="form-control" value="{{ $organization->address }}"
                                    placeholder="{{translate('Address')}}" required>
                        </div>
                    </div>



                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <label class="text-dark mb-0">{{translate('Organization Image')}}</label>
                                <small class="text-danger"> *( {{translate('ratio 1:1')}} )</small>
                            </div>

                            <div class="custom-file">
                                <input type="file" name="image" id="customFileEg1" class="custom-file-input d-none"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" onchange="loadFileImage(event)">
                                <label class="custom-file-label"
                                        for="customFileEg1">{{translate('choose')}} {{translate('file')}}</label>
                            </div>

                            <div class="text-center mt-3">
                                <img class="border rounded-10 w-200" id="viewer1"
                                        src="{{$user['image_fullpath']}}"
                                     alt="{{ translate('identification_image') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <label class="text-dark mb-0">{{translate('Logo')}}</label>
                                <small class="text-danger"> *( {{translate('ratio 1:1')}} )</small>
                            </div>

                            <div class="custom-file">
                                <input type="file" name="logo" id="customFileEg2" class="custom-file-input d-none"
                                        accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" onchange="loadFileLogo(event)"
                                       alt="{{ translate('logo') }}">
                                <label class="custom-file-label" for="customFileEg2">{{translate('choose')}} {{translate('file')}}</label>
                            </div>
                            <div class="text-center mt-3">
                                <img class="border rounded-10 w-200" id="viewer2"
                                        src="{{$organization['logo_fullpath']}}"
                                     alt="{{ translate('logo') }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('submit')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        "use strict";

        var loadFileImage = function(event) {
            var image = document.getElementById('viewer1');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        var loadFileLogo = function(event) {
            var image2 = document.getElementById('viewer2');
            image2.src = URL.createObjectURL(event.target.files[0]);
        };

        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identification_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-4',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/admin/img/400x400/img2.jpg')}}',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>

@endpush
