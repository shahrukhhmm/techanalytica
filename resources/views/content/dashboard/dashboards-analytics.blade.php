@extends('layouts/contentNavbarLayout')

@section('title', 'Analytics Dashboard')

@section('vendor-style')
  @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
  @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('content')

  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <form method="GET" action="{{ route('dashboard.analytics') }}" class="d-flex gap-3 flex-grow-1">
              <div style="min-width: 240px;">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-select" onchange="this.form.submit()">
                  <option value="">All Departments</option>
                  {{-- @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $selectedDepartment == $dept->id ? 'selected' : '' }}>
                      {{ $dept->name }}
                    </option>
                  @endforeach --}}
                </select>
              </div>
            </form>

            {{-- <a href="{{ route('dashboard.analytics.pdf') . ($selectedDepartment ? '?department_id=' . $selectedDepartment : '') }}"
              class="btn btn-primary" target="_blank">
              <i class="bx bx-download"></i> Download PDF
            </a> --}}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    {{-- <!-- Sales Trend -->
    <div class="col-lg-6 col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Sales Trend (Last 12 Months)</h5>
        </div>
        <div class="card-body">
          <div id="salesChart" style="height: 340px;"></div>
        </div>
      </div>
    </div>

    <!-- Expenses Trend -->
    <div class="col-lg-6 col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Expenses Trend (Last 12 Months)</h5>
        </div>
        <div class="card-body">
          <div id="expensesChart" style="height: 340px;"></div>
        </div>
      </div>
    </div>

    <!-- Comparison Bar -->
    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Sales vs Expenses Comparison</h5>
        </div>
        <div class="card-body">
          <div id="comparisonChart" style="height: 380px;"></div>
        </div>
      </div>
    </div>

    <!-- Donut -->
    <div class="col-lg-6 col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Financial Overview</h5>
        </div>
        <div class="card-body">
          <div id="donutChart" style="height: 340px;"></div>
        </div>
      </div>
    </div>

    <!-- Department Pie - only when all departments selected -->
    @if (!$selectedDepartment && isset($departmentSalesData) && $departmentSalesData->isNotEmpty())
      <div class="col-lg-6 col-12 mb-4">
        <div class="card">
          <div class="card-header">
            <h5>Sales Distribution by Department</h5>
          </div>
          <div class="card-body">
            <div id="deptPieChart" style="height: 340px;"></div>
          </div>
        </div>
      </div>
    @endif --}}
  </div>

@endsection
@section('page-script')
  <script>

  </script>
@endsection
