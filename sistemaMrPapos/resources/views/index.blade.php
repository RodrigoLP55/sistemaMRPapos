@extends('layouts.main', ['activePage' => 'dashboard', 'titlePage' => __('Principal')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      ESPACIO PARA
    </div>    
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush