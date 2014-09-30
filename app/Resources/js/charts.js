/**
 * Plik do pisania wtyczek odnośnie różnych wykresów.
 *
 * Wszystkie wykresy powinny być generowane na podstawie AJAX`a, gdzie dane powinny być
 * w postaci JSON. W symfony 2 do tego jest klasa: "JsonResponse(array, code)".
 */
(function($) {
    /**
     * Wykres liniowy.
     *
     * @param elRefresh element DOM który po naciśnięciu ma pobierać nowe dane (json)
     * @param options dodatkowe opcje
     * @returns {*|HTMLElement}
     */
    $.fn.lineChart = function (elRefresh, options) {
        var $this = $(this);
        var opt = $.extend(true, {
            data: [],
            urlData: {},
            chart: {
                margin: {
                    top: 30,
                    right: 0,
                    bottom: 20,
                    left: 35
                },
                attr: {
                    showYAxis: true,
                    showXAxis: true,
                    showLegend: true,
                    useInteractiveGuideline: true,
                    transitionDuration: 350
                },
                options: {
                    showControls: false,
                    showLegend: true
                }
            },
            onInit: function (opt) { return onInit(opt); }
        }, options);

        opt.onInit(opt);

        /* Jeżeli element odświeżający jest przypisany to ustawiamy akcję po kliknięciu */
        if (elRefresh !== undefined) {
            elRefresh.click( function () {
                if (!isBlockedRefresh()) {
                    addChart(opt);
                    blockRefresh();
                }
            });
        }

        /* Dodanie nowego wykresu */
        function addChart(opt) {
            if ($this.attr('data-url')) {
                $.ajax({
                    url: $this.attr('data-url'),
                    data: opt.urlData,
                    beforeSend: function () {},
                    success: function (data) {
                        buildChart(opt, data);
                        unblockRefresh();
                    },
                    error: function() {
                        alert('error');
                    }
                });
            }
        }

        function blockRefresh() {
            if (elRefresh !== undefined) {
                elRefresh.addClass('process');
            }
        }

        function isBlockedRefresh() {
            if (elRefresh !== undefined) {
                return elRefresh.hasClass('process');
            } else {
                return false;
            }
        }

        function unblockRefresh() {
            if (elRefresh !== undefined) {
                elRefresh.removeClass('process');
            }
        }

        function onInit(opt) {
            if (opt.data.length <= 0) {
                addChart(opt);
            } else {
                buildChart(opt, opt.data);
            }
        }

        function buildChart(opt, data) {
            nv.addGraph(function() {
                var chart = nv.models.lineChart().margin(opt.chart.margin)
                    .clipEdge(true)
                    .useInteractiveGuideline(opt.chart.attr.useInteractiveGuideline)
                    .showYAxis(opt.chart.attr.showYAxis)
                    .showXAxis(opt.chart.attr.showXAxis)
                    .showLegend(opt.chart.attr.showLegend)
                    .transitionDuration(opt.chart.attr.transitionDuration);

                chart.options(opt.chart.options);

                d3.select('#'+$this.attr('id')+' svg').datum(data).call(chart);
                nv.utils.windowResize(chart.update);

                return chart;
            });
        }

        return $this;
    };
})(jQuery);