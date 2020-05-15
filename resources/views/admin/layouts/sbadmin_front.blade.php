<!DOCTYPE html>
<html lang="es">
  <head>
    @include('admin.layouts.sections.metas')
    <title>{{ env('APP_NAME') }} @yield('title')</title>
    @include('admin.layouts.sections.styles')
    @yield('styles')
    <script>
      var direction = "{{ env('APP_URL') }}";
    </script>
  </head>
  <body class="bg-gradient-primary">
    <!-- Page Container -->
    <div class="container">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            @yield('page-image')
            <div class="col-lg-7">
              <div class="p-5">
                @include('admin.layouts.sections.alerts')
                <div class="text-center">
                  @yield('panel-heading')
                </div>
                @yield('content')
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('admin.layouts.sections.scripts')
    @yield('scripts')
  </body>
</html>
