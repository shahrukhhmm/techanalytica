@php
  $containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ $containerFooter }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
      <div class="text-body">

      </div>
      <div class="d-none d-lg-inline-block">
        CopyWright © {{ date('Y') }}, made with ❤️ by DEVELOPER
      </div>
    </div>
</footer>
<!--/ Footer-->
