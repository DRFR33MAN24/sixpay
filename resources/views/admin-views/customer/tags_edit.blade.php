@extends('layouts.admin.app')

@section('title', translate('Update Tag'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/rating.png')}}" alt="{{ translate('tag') }}">
            <h2 class="page-header-title">{{translate('Update Tag')}}</h2>
        </div>

        <div class="card card-body">
            <form action="{{route('admin.customer.update-tag',[$tag['id']])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Tag Name')}}</label>
                            <input type="text" name="name" class="form-control" value="{{ $tag['name']??'' }}"
                                    placeholder="{{translate('Tag Name')}}" required>
                        </div>
                    </div>





                </div>



                <div class="d-flex gap-3 justify-content-end">
                    <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('update')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>

    <script>
        "use strict";

        let loadFile = function(event) {
            let image = document.getElementById('viewer');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-2',
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
