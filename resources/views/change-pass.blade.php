@extends('layout')
@section('main-content')
<form action="{{ route('detail.do-change', ['id' => Auth::id()]) }}" method="POST">
    @csrf
    <div class="card m-b-30">
        <div class="card-body">
            <div class="row">
                <div class="col-4 form-group">
                    <label>Mật khẩu cũ <span style="color: red">*</span></label>
                    <input type="password" name="old_pass" id="old_pass" class="form-control" required placeholder="Nhập mật khẩu cũ"/>
                    <span toggle="#old_pass" class="fa fa-eye old_pass eyes"></span>
                </div>
                <div class="col-4 form-group">
                    <label>Mật khẩu mới <span style="color: red">*</span></label>
                    <input type="password" name="new_pass" id="new_pass" class="form-control" minlength="6" maxlength="20" placeholder="Nhập mật khẩu mới"/>
                    <span toggle="#new_pass" class="fa fa-eye new_pass eyes"></span>
                </div>
                <div class="col-4 form-group">
                    <label>Xác nhận mật khẩu mới <span style="color: red">*</span></label>
                    <input type="password" name="confirm_pass" id="confirm_pass" class="form-control" minlength="6" maxlength="20" placeholder="Nhập xác nhận mật khẩu mới"/>
                    <span toggle="#confirm_pass" class="fa fa-eye confirm_pass eyes"></span>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-2" style="margin-left: auto">
                    <button type="submit" class="btn btn-primary waves-effect waves-light btn-block">
                        Lưu
                    </button>
                </div>
                <div class="col-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary waves-effect waves-light btn-block">Hủy</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('page-css')
<style>
    .eyes {
        float: right;
        margin-top: -24px;
        padding-right: 8px;
        opacity: 0.8;
    }
</style>
@endsection

@section('page-js')
<script src="{{ asset('plugins/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('plugins/alertify/js/alertify.js') }}"></script>
<script src="{{ asset('assets/pages/alertify-init.js') }}"></script>
@endsection

@section('page-custom-js')
<script type="text/javascript">
    $(document).ready(function() {
        @if (session('status'))
            @if (session('status') == 'success')
                alertify.success("{!! session('message') !!}");
            @else
                alertify.error("{!! session('message') !!}");
            @endif
        @endif
        $('form').parsley();
        $(".old_pass").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".new_pass").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".confirm_pass").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $('#confirm_pass').keyup(function() {
            if ($('#new_pass').val() == $('#confirm_pass').val()) {
                $('#confirm_pass').css('border-color', '#69d069');
                $('#confirm_pass')[0].setCustomValidity('');
            } else {
                $('#confirm_pass')[0].setCustomValidity("Password Don't Match");
                $('#confirm_pass').css('border-color', '#f58787');
            }
        });
    });
</script>
@endsection