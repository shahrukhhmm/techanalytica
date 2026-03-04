@isset($pageConfigs)
    {{-- {!! Helper::updatePageConfig($pageConfigs) !!} --}}
@endisset


@extends('backend.vendor.layouts.commonMaster')

@section('layoutContent')
    <!-- Content -->
    @yield('content')
    <!--/ Content -->
@endsection
