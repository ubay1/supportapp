@extends('header')
@section('content')
<!-- Main Section -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/view_admin.css') }} ">
<link href="https://fonts.googleapis.com/css?family=Hind+Guntur&display=swap" rel="stylesheet">
<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }

    .col-lg-12{
        display: flex;
        align-items: center;
    }

</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

{{-- get all project and masalah --}}

<!-- Chart code -->
<script>
    am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

var url = "http://localhost:8000/api/admin/getAllProject";
var url2 = "http://localhost:8000/api/admin/getAllMasalah";

var data = $.parseJSON($.ajax({
    url: url,
    dataType: "json",
    async: false
}).responseText);

var data2 = $.parseJSON($.ajax({
    url: url2,
    dataType: "json",
    async: false
}).responseText);

var Project = Object.keys(data);
var Masalah = Object.keys(data2).length;

console.log(Masalah);

chart.data = [{
    "title": "Masalah",
    "litres": Masalah
}, {
    "title": "Project",
    "litres": Project
}];

// Add data
chart.data = [{
  "project": Project,
  "masalah": Masalah
}];

// Create axes

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "project";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
  if (target.dataItem && target.dataItem.index & 2 == 2) {
    return dy + 25;
  }
  return dy;
});

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "masalah";
series.dataFields.categoryX = "project";
series.name = "masalah";
series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;

}); // end am4core.ready()
</script>


<section class="main-section">

    <div id="content">
        @if(\Session::has('alert-sukses'))
        <div class="alert alert-info">
            <div>{{Session::get('alert-sukses')}}</div>
        </div>
        @endif

        @if(\Session::has('akses'))
        <div class="alert alert-danger">
            <div>{{Session::get('akses')}}</div>
        </div>
        @endif

        <div class="container-fluid">
            <div class="col-lg-12">
                <div id="chartdiv"></div>
            </div>
        </div>
    </div>


    <!-- /.content -->
</section>

<script type="text/javascript" src="{{ asset('assets/css/view.js') }}"></script>
<!-- /.main-section -->


@endsection
