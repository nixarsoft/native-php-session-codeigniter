<div class="row mrg20B">

    <div class="col-md-4">

        <a href="javascript:;" class="tile-button btn clearfix bg-white mrg30B" title="">
            <div class="tile-header pad10A font-size-13 popover-title">
                Cloud downloads
            </div>
            <div class="tile-content-wrapper">
                <i class="glyph-icon icon-cloud-download"></i>
                <div class="tile-content">
                    <i class="glyph-icon icon-arrow-up font-green"></i>
                    6.52
                    <span>k</span>
                </div>
                <small>
                    12% new downloads
                </small>
            </div>
            <div class="tile-footer mrg5A primary-bg">
                view details
                <i class="glyph-icon icon-arrow-right"></i>
            </div>
        </a>

    </div>


    <div class="col-md-4">

        <a href="javascript:;" class="tile-button btn clearfix bg-white" title="">
            <div class="tile-header pad10A font-size-13 popover-title">
                Recent sales
            </div>
            <div class="tile-content-wrapper">
                <i class="glyph-icon icon-credit-card"></i>
                <div class="tile-content">
                    1.2<span>k</span>
                </div>
                <small>
                    <i class="glyph-icon icon-caret-up"></i>
                    $272 daily revenue
                </small>
            </div>
            <div class="tile-footer mrg5A primary-bg">
                view details
                <i class="glyph-icon icon-arrow-right"></i>
            </div>
        </a>

    </div>

    <div class="col-md-4">

        <a href="javascript:;" class="tile-button btn clearfix bg-white" title="">
            <div class="tile-header pad10A font-size-13 popover-title">
                Trafic statistics
            </div>
            <div class="tile-content-wrapper">
                <i class="glyph-icon icon-dashboard"></i>
                <div class="tile-content">
                    <i class="glyph-icon icon-chevron-up font-yellow"></i>
                    517
                </div>
                <small>
                    <span class="font-orange">+22,5%</span> new traffic
                </small>
            </div>
            <div class="tile-footer mrg5A primary-bg">
                view details
                <i class="glyph-icon icon-arrow-right"></i>
            </div>
        </a>

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="content-box border-top border-red">
            <h3 class="content-header clearfix">
                Weekly sales
                <small>(this is just an example)</small>
                <div class="button-group float-right" data-toggle="buttons">
                    <a href="javascript:;" class="btn medium bg-blue-alt">
                        <input type="radio" name="test-toggle-radio">
                        <i class="glyph-icon icon-edit"></i>
                    </a>
                    <a href="javascript:;" class="btn medium bg-blue-alt">
                        <input type="radio" name="test-toggle-radio">
                        <i class="glyph-icon icon-camera"></i>
                    </a>
                    <a href="javascript:;" class="btn medium bg-blue-alt">
                        <input type="radio" name="test-toggle-radio">
                        <i class="glyph-icon icon-bar-chart-o"></i>
                    </a>
                </div>
            </h3>
            <div class="content-box-wrapper">

                <figure id="left-example-1" style="width: 98%; height: 300px;"></figure>

<script type="text/javascript">

var tt = document.createElement('div'),
  leftOffset = -(~~$('html').css('padding-left').replace('px', '') + ~~$('body').css('margin-left').replace('px', '')),
  topOffset = 0;
tt.className = 'tooltip top fade in';
document.body.appendChild(tt);

var data = {
  "xScale": "time",
  "yScale": "linear",
  "main": [
    {
      "className": ".pizza",
      "data": [
        {
          "x": "2012-11-05",
          "y": 6
        },
        {
          "x": "2012-11-06",
          "y": 6
        },
        {
          "x": "2012-11-07",
          "y": 8
        },
        {
          "x": "2012-11-08",
          "y": 3
        },
        {
          "x": "2012-11-09",
          "y": 4
        },
        {
          "x": "2012-11-10",
          "y": 9
        },
        {
          "x": "2012-11-11",
          "y": 6
        }
      ]
    }
  ]
};
var opts = {
  "dataFormatX": function (x) { return d3.time.format('%Y-%m-%d').parse(x); },
  "tickFormatX": function (x) { return d3.time.format('%A')(x); },
  "mouseover": function (d, i) {
    var pos = $(this).offset();
    $(tt).html('<div class="arrow"></div><div class="tooltip-inner">'+d3.time.format('%A')(d.x) + ': ' + d.y+'</div>')
      .css({top: topOffset + pos.top, left: pos.left + leftOffset})
      .show();
  },
  "mouseout": function (x) {
    $(tt).hide();
  }
};
var myChart = new xChart('line-dotted', data, '#left-example-1', opts);

</script>

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-box border-top border-green">
            <h3 class="content-header clearfix">
                Server statistics
                <small>(Example description)</small>
                <div class="button-group float-right" id="upd-chart">
                    <a href="javascript:;" data-type="bar" class="btn medium bg-green">
                        <span class="button-content">Bar</span>
                    </a>
                    <a href="javascript:;" data-type="line-dotted" class="btn medium bg-green">
                        <span class="button-content">Line</span>
                    </a>
                    <a href="javascript:;" data-type="cumulative" class="btn medium bg-green">
                        <span class="button-content">Cumulative</span>
                    </a>
                </div>
            </h3>
            <div class="content-box-wrapper">

                <figure id="example-vis" style="width: 98%; height: 300px;"></figure>

<script type="text/javascript">

                (function () {

                var tt = document.createElement('div'),
                  leftOffset = -(~~$('html').css('padding-left').replace('px', '') + ~~$('body').css('margin-left').replace('px', '')),
                  topOffset = 0;
                tt.className = 'tooltip top fade in';
                document.body.appendChild(tt);

                var data = [{"xScale":"ordinal","comp":[],"main":[{"className":".main.l1","data":[{"y":15,"x":"2012-11-19T00:00:00"},{"y":11,"x":"2012-11-20T00:00:00"},{"y":8,"x":"2012-11-21T00:00:00"},{"y":10,"x":"2012-11-22T00:00:00"},{"y":1,"x":"2012-11-23T00:00:00"},{"y":6,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]},{"className":".main.l2","data":[{"y":29,"x":"2012-11-19T00:00:00"},{"y":33,"x":"2012-11-20T00:00:00"},{"y":13,"x":"2012-11-21T00:00:00"},{"y":16,"x":"2012-11-22T00:00:00"},{"y":7,"x":"2012-11-23T00:00:00"},{"y":18,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]}],"type":"line-dotted","yScale":"linear"},{"xScale":"ordinal","comp":[],"main":[{"className":".main.l1","data":[{"y":12,"x":"2012-11-19T00:00:00"},{"y":18,"x":"2012-11-20T00:00:00"},{"y":8,"x":"2012-11-21T00:00:00"},{"y":7,"x":"2012-11-22T00:00:00"},{"y":6,"x":"2012-11-23T00:00:00"},{"y":12,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]},{"className":".main.l2","data":[{"y":29,"x":"2012-11-19T00:00:00"},{"y":33,"x":"2012-11-20T00:00:00"},{"y":13,"x":"2012-11-21T00:00:00"},{"y":16,"x":"2012-11-22T00:00:00"},{"y":7,"x":"2012-11-23T00:00:00"},{"y":18,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]}],"type":"cumulative","yScale":"linear"},{"xScale":"ordinal","comp":[],"main":[{"className":".main.l1","data":[{"y":12,"x":"2012-11-19T00:00:00"},{"y":18,"x":"2012-11-20T00:00:00"},{"y":8,"x":"2012-11-21T00:00:00"},{"y":7,"x":"2012-11-22T00:00:00"},{"y":6,"x":"2012-11-23T00:00:00"},{"y":12,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]},{"className":".main.l2","data":[{"y":29,"x":"2012-11-19T00:00:00"},{"y":33,"x":"2012-11-20T00:00:00"},{"y":13,"x":"2012-11-21T00:00:00"},{"y":16,"x":"2012-11-22T00:00:00"},{"y":7,"x":"2012-11-23T00:00:00"},{"y":18,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]}],"type":"bar","yScale":"linear"}];
                var order = [0, 1, 0, 2],
                  i = 0,
                  xFormat = d3.time.format('%A'),
                  chart = new xChart('line-dotted', data[order[i]], '#example-vis', {
                    axisPaddingTop: 5,
                    dataFormatX: function (x) {
                      return new Date(x);
                    },
                    tickFormatX: function (x) {
                      return xFormat(x);
                    },
                      mouseover: function (d, i) {
                        var pos = $(this).offset();
                        $(tt).html('<div class="arrow"></div><div class="tooltip-inner">'+d3.time.format('%A')(d.x) + ': ' + d.y+'</div>')
                          .css({top: topOffset + pos.top, left: pos.left + leftOffset})
                          .show();
                      },
                      mouseout: function (x) {
                        $(tt).hide();
                      },
                    timing: 1250
                  }),
                  rotateTimer,
                  toggles = d3.selectAll('#upd-chart a'),
                  t = 3500;

                function updateChart(i) {
                  var d = data[i];
                  chart.setData(d);
                  toggles.classed('active', function () {
                    return (d3.select(this).attr('data-type') === d.type);
                  });
                  return d;
                }

                toggles.on('click', function (d, i) {
                  clearTimeout(rotateTimer);
                  updateChart(i);
                });

                function rotateChart() {
                  i += 1;
                  i = (i >= order.length) ? 0 : i;
                  var d = updateChart(order[i]);
                  rotateTimer = setTimeout(rotateChart, t);
                }
                rotateTimer = setTimeout(rotateChart, t);
                }());

</script>

            </div>
        </div>
    </div>
</div>

<div class="row mrg20B">

    <div class="col-md-3">

        <a href="javascript:;" class="tile-button btn bg-blue-alt" title="">
            <div class="tile-content-wrapper">
                <i class="glyph-icon icon-dashboard"></i>
                <div class="tile-content">
                    <span>$</span>
                    378
                </div>
                <small>
                    <i class="glyph-icon icon-caret-up"></i>
                    <span></span>
                </small>
            </div>
            <div class="tile-footer">
                view details
                <i class="glyph-icon icon-arrow-right"></i>
            </div>
        </a>

    </div>

    <div class="col-md-3">

        <a href="javascript:;" class="tile-button btn bg-green" title="">
            <div class="tile-content-wrapper">
                <i class="glyph-icon icon-camera"></i>
                <div class="tile-content">
                    <span>$</span>
                    378
                </div>
                <small>
                    <i class="glyph-icon icon-caret-up"></i>
                    +7,6% new users in the first quarter
                </small>
            </div>
            <div class="tile-footer">
                view details
                <i class="glyph-icon icon-arrow-right"></i>
            </div>
        </a>

    </div>


    <div class="col-md-3">

        <a href="javascript:;" class="tile-button btn bg-azure" title="">
            <div class="tile-content-wrapper">
                <i class="glyph-icon icon-bullhorn"></i>
                <div class="tile-content">
                    <span>$</span>
                    378
                </div>
                <small>
                    <i class="glyph-icon icon-caret-up"></i>
                    +7,6% new users in the first quarter
                </small>
            </div>
            <div class="tile-footer">
                view details
                <i class="glyph-icon icon-arrow-right"></i>
            </div>
        </a>

    </div>

    <div class="col-md-3">

        <a href="javascript:;" class="tile-button btn bg-red" title="">
            <div class="tile-content-wrapper">
                <i class="glyph-icon icon-anchor"></i>
                <div class="tile-content">
                    <span>$</span>
                    378
                </div>
                <small>
                    <i class="glyph-icon icon-caret-up"></i>
                    +7,6% new users in the first quarter
                </small>
            </div>
            <div class="tile-footer">
                view details
                <i class="glyph-icon icon-arrow-right"></i>
            </div>
        </a>

    </div>

</div>
