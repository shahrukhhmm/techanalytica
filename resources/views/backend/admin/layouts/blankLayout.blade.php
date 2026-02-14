@isset($pageConfigs)
{{-- {!! Helper::updatePageConfig($pageConfigs) !!} --}}
@endisset


@extends('backend.admin.layouts.commonMaster')

@section('layoutContent')
<!-- Content -->
@yield('content')
<!--/ Content -->
@endsection
