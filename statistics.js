/**
 * script statistics.js
 * 
 * this script contains the neccessary resources for JavaScript
 * (c) Joaquin Javier ESTEBAN MARTINEZ
 * last updated 2019-01-05
*/

$(document).ready(function() {
    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);
    chart.numberFormatter.numberFormat = "#.";

    // Add data
    chart.data = [{"year":1988,"practica":1},{"year":1989,"practica":0},{"year":1990,"practica":0},{"year":1991,"practica":1},{"year":1992,"practica":2},{"year":1993,"practica":0},{"year":1994,"practica":34},{"year":1995,"practica":26},{"year":1996,"practica":51},{"year":1997,"practica":129},{"year":1998,"practica":24},{"year":1999,"practica":158},{"year":2000,"practica":267},{"year":2001,"practica":307},{"year":2002,"practica":334},{"year":2003,"practica":407},{"year":2004,"practica":327},{"year":2005,"practica":416},{"year":2006,"practica":451},{"year":2007,"practica":369},{"year":2008,"practica":478},{"year":2009,"practica":540},{"year":2010,"practica":370},{"year":2011,"practica":326},{"year":2012,"practica":333},{"year":2013,"practica":458},{"year":2014,"practica":430},{"year":2015,"practica":488},{"year":2016,"practica":555},{"year":2017,"practica":620},{"year":2018,"practica":464}];
    
    // Create axes

    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "year";
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
    series.dataFields.valueY = "practica";
    series.dataFields.categoryX = "year";
    series.name = "Visits";
    series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;

    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;
    
    /**
     * chart 2: XXX
     */
    
    var chart2 = am4core.create("chartdiv2", am4charts.XYChart);
    //chart2.data = [{"year":1988,"practica":1},{"year":1989,"practica":0},{"year":1990,"practica":0},{"year":1991,"practica":1},{"year":1992,"practica":2},{"year":1993,"practica":0},{"year":1994,"practica":34},{"year":1995,"practica":26},{"year":1996,"practica":51},{"year":1997,"practica":129},{"year":1998,"practica":24},{"year":1999,"practica":158},{"year":2000,"practica":267},{"year":2001,"practica":307},{"year":2002,"practica":334},{"year":2003,"practica":407},{"year":2004,"practica":327},{"year":2005,"practica":416},{"year":2006,"practica":451},{"year":2007,"practica":369},{"year":2008,"practica":478},{"year":2009,"practica":540},{"year":2010,"practica":370},{"year":2011,"practica":326},{"year":2012,"practica":333},{"year":2013,"practica":458},{"year":2014,"practica":430},{"year":2015,"practica":488},{"year":2016,"practica":555},{"year":2017,"practica":620},{"year":2018,"practica":464}];
    chart2.data = [{"month":1,"amount":617},{"month":2,"amount":525},{"month":3,"amount":689},{"month":4,"amount":571},{"month":5,"amount":557},{"month":6,"amount":759},{"month":7,"amount":1007},{"month":8,"amount":968},{"month":9,"amount":789},{"month":10,"amount":652},{"month":11,"amount":549},{"month":12,"amount":683}];
    
    // Create axes

    var categoryAxis = chart2.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "month";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;

    categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
      if (target.dataItem && target.dataItem.index & 2 == 2) {
        return dy + 25;
      }
      return dy;
    });

    var valueAxis = chart2.yAxes.push(new am4charts.ValueAxis());

    // Create series
    var series = chart2.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueY = "amount";
    series.dataFields.categoryX = "month";
    series.name = "Visits";
    series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;

    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;
    
    /**
     * chart 3: XXX
     */
    
    var chart3 = am4core.create("chartdiv3", am4charts.pieChart);
    chart3.data = [{"month":1,"amount":617},{"month":2,"amount":525},{"month":3,"amount":689},{"month":4,"amount":571},{"month":5,"amount":557},{"month":6,"amount":759},{"month":7,"amount":1007},{"month":8,"amount":968},{"month":9,"amount":789},{"month":10,"amount":652},{"month":11,"amount":549},{"month":12,"amount":683}];
    
    var pieSeries = chart3.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "amount";
pieSeries.dataFields.category = "month";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

});