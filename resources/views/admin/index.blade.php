@extends('layout.admin_and_user_page.master')
@section('main')
    <div class="row">
        <div class="col-md-12">
            {{ Breadcrumbs::render('admin.index') }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="header">
                <h4 class="title">Thống kê người dùng</h4>
            </div>
            <div class="content">
                <div id="chartUser" class="ct-chart ">
                </div>
            </div>
            <div class="footer">
                <div class="legend">
                    Tổng: {{ $allUsers }}
                    <i class="fa fa-circle text-info" style="margin-left: 24px;"></i> User: {{ $userCount }}
                    <i class="fa fa-circle text-warning" style="margin-left: 16px;"></i> Censor: {{ $censorCount }}
                    <i class="fa fa-circle text-danger" style="margin-left: 16px;"></i> Admin: {{ $adminCount }}
                </div>
                <hr>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            let dataPreferences = {
                series: [
                    [25, 30, 20, 25]
                ]
            };
            let optionsPreferences = {
                donut: true,
                donutWidth: 40,
                startAngle: 0,
                height: "350px",
                total: 100,
                showLabel: false,
                axisX: {
                    showGrid: false
                }
            };

            Chartist.Pie('#chartUser', dataPreferences, optionsPreferences);

            Chartist.Pie('#chartUser', {
                labels: [{{ $userPercentage }} + '%', {{ $censorPercentage }} + '%', {{ $adminPercentage }} + '%'],
                series: [{{ $userPercentage }}, {{ $censorPercentage }}, {{ $adminPercentage }}]
            });

        </script>
    @endpush
@endsection
