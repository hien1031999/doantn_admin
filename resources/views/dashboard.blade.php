@extends('layout')
@section('main-content')
<p>Xin chào {{ Auth::user()->ten }}</p>
@endsection

@section('page-css')
<style>
</style>
@endsection

@section('page-js')
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
    });
</script>
@endsection