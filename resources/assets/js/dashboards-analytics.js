/**
 * TechAnalytica Dashboard Analytics (Fast, Modern & Frontend Aligned)
 */

'use strict';

(function () {
  const cardColor = '#150d1a';
  const headingColor = '#ffffff';
  const legendColor = '#cbd5e1';
  const labelColor = '#9a8c9e';
  const borderColor = 'rgba(255, 255, 255, 0.08)';
  const fontFamily = "'Plus Jakarta Sans', 'Inter', sans-serif";

  // Vibrant AI Theme Palette matching Frontend
  const pinkColor = '#e04385';
  const purpleColor = '#a4358a';
  const cyanColor = '#00f2fe';
  const successColor = '#10b981';
  const warningColor = '#f59e0b';
  const dangerColor = '#ef4444';
  const chartPalette = [pinkColor, purpleColor, cyanColor, successColor, warningColor, '#8b5cf6', '#ec4899'];

  if (typeof dashboardData === 'undefined') {
    return;
  }

  // 1. Tools by Category Chart (Donut)
  const toolsByCategoryChartEl = document.querySelector('#toolsByCategoryChart');
  if (toolsByCategoryChartEl && dashboardData.categoryNames && dashboardData.categoryNames.length) {
    const toolsByCategoryConfig = {
      chart: {
        height: 320,
        type: 'donut',
        fontFamily: fontFamily,
        background: 'transparent'
      },
      labels: dashboardData.categoryNames,
      series: dashboardData.categoryCounts,
      colors: chartPalette,
      stroke: {
        width: 3,
        colors: [cardColor]
      },
      dataLabels: {
        enabled: true,
        formatter: function (val) {
          return parseInt(val) + '%';
        },
        style: {
          fontSize: '12px',
          fontFamily: fontFamily,
          fontWeight: '600'
        }
      },
      legend: {
        show: true,
        position: 'bottom',
        fontFamily: fontFamily,
        labels: {
          colors: legendColor
        },
        markers: {
          radius: 12
        }
      },
      tooltip: {
        theme: 'dark',
        y: {
          formatter: function (val) {
            return val + ' Tools';
          }
        }
      },
      plotOptions: {
        pie: {
          donut: {
            size: '68%',
            labels: {
              show: true,
              name: {
                fontSize: '0.9rem',
                fontFamily: fontFamily,
                color: labelColor
              },
              value: {
                fontSize: '1.5rem',
                fontFamily: fontFamily,
                fontWeight: '700',
                color: headingColor,
                formatter: function (val) {
                  return parseInt(val);
                }
              },
              total: {
                show: true,
                fontSize: '0.85rem',
                color: labelColor,
                label: 'Total Tools',
                formatter: function (w) {
                  return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                }
              }
            }
          }
        }
      }
    };
    const toolsByCategoryChart = new ApexCharts(toolsByCategoryChartEl, toolsByCategoryConfig);
    toolsByCategoryChart.render();
  }

  // 2. Tools Status Chart (Bar)
  const toolsStatusChartEl = document.querySelector('#toolsStatusChart');
  if (toolsStatusChartEl && dashboardData.statuses && dashboardData.statuses.length) {
    const toolsStatusConfig = {
      chart: {
        height: 320,
        type: 'bar',
        fontFamily: fontFamily,
        background: 'transparent',
        toolbar: { show: false }
      },
      series: [{
        name: 'Tools',
        data: dashboardData.statusCounts
      }],
      xaxis: {
        categories: dashboardData.statuses.map(s => s.charAt(0).toUpperCase() + s.slice(1)),
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: {
          style: {
            colors: labelColor,
            fontFamily: fontFamily,
            fontSize: '12px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontFamily: fontFamily
          }
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 8,
          columnWidth: '45%',
          distributed: true,
          startingShape: 'rounded',
          endingShape: 'rounded'
        }
      },
      colors: [successColor, warningColor, dangerColor, cyanColor],
      dataLabels: { enabled: false },
      legend: { show: false },
      grid: {
        borderColor: borderColor,
        strokeDashArray: 4,
        padding: { top: 0, bottom: -8, left: 10, right: 10 }
      },
      tooltip: {
        theme: 'dark'
      }
    };
    const toolsStatusChart = new ApexCharts(toolsStatusChartEl, toolsStatusConfig);
    toolsStatusChart.render();
  }

  // 3. Tools Claimed vs Unclaimed (Donut)
  const toolsClaimedChartEl = document.querySelector('#toolsClaimedChart');
  if (toolsClaimedChartEl) {
    const toolsClaimedConfig = {
      chart: {
        height: 320,
        type: 'donut',
        fontFamily: fontFamily,
        background: 'transparent'
      },
      labels: ['Claimed & Verified', 'Unclaimed Community'],
      series: [dashboardData.claimedToolsCount || 0, dashboardData.unclaimedToolsCount || 0],
      colors: [pinkColor, '#332040'],
      stroke: {
        width: 3,
        colors: [cardColor]
      },
      dataLabels: {
        enabled: true,
        style: {
          fontSize: '12px',
          fontFamily: fontFamily,
          fontWeight: '600'
        }
      },
      legend: {
        show: true,
        position: 'bottom',
        fontFamily: fontFamily,
        labels: {
          colors: legendColor
        }
      },
      tooltip: {
        theme: 'dark'
      },
      plotOptions: {
        pie: {
          donut: {
            size: '68%',
            labels: {
              show: true,
              name: {
                fontSize: '0.85rem',
                fontFamily: fontFamily,
                color: labelColor
              },
              value: {
                fontSize: '1.4rem',
                fontFamily: fontFamily,
                fontWeight: '700',
                color: headingColor
              },
              total: {
                show: true,
                fontSize: '0.85rem',
                color: labelColor,
                label: 'Total Catalog',
                formatter: function (w) {
                  return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                }
              }
            }
          }
        }
      }
    };
    const toolsClaimedChart = new ApexCharts(toolsClaimedChartEl, toolsClaimedConfig);
    toolsClaimedChart.render();
  }

  // 4. Tools Added Trend (Smooth Gradient Area Chart)
  const toolsAddedTrendChartEl = document.querySelector('#toolsAddedTrendChart');
  if (toolsAddedTrendChartEl && dashboardData.months && dashboardData.months.length) {
    const toolsAddedTrendConfig = {
      chart: {
        height: 280,
        type: 'area',
        fontFamily: fontFamily,
        background: 'transparent',
        toolbar: { show: false }
      },
      dataLabels: { enabled: false },
      stroke: {
        curve: 'smooth',
        width: 3
      },
      series: [{
        name: 'New AI Tools Listed',
        data: dashboardData.toolsAddedCounts
      }],
      xaxis: {
        categories: dashboardData.months,
        axisBorder: { show: false },
        axisTicks: { show: false },
        labels: {
          style: {
            colors: labelColor,
            fontFamily: fontFamily,
            fontSize: '12px'
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontFamily: fontFamily
          }
        },
        min: 0
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.5,
          gradientToColors: ['#a4358a'],
          opacityTo: 0.05,
          stops: [0, 95, 100]
        }
      },
      colors: [pinkColor],
      grid: {
        borderColor: borderColor,
        strokeDashArray: 4,
        padding: { top: -10, bottom: -5, left: 10, right: 10 }
      },
      tooltip: {
        theme: 'dark'
      }
    };
    const toolsAddedTrendChart = new ApexCharts(toolsAddedTrendChartEl, toolsAddedTrendConfig);
    toolsAddedTrendChart.render();
  }

  // Modal Fullscreen Chart Viewer
  const chartModalEl = document.getElementById('chartModal');
  if (chartModalEl) {
    const chartModal = new bootstrap.Modal(chartModalEl);
    const modalContainer = document.querySelector('#modalChartContainer');
    const modalTitle = document.querySelector('#chartModalTitle');
    let modalChart = null;

    const getChartConfig = (chartId) => {
      switch (chartId) {
        case 'toolsByCategoryChart':
          return {
            chart: { height: 480, type: 'donut', fontFamily: fontFamily, background: 'transparent' },
            labels: dashboardData.categoryNames,
            series: dashboardData.categoryCounts,
            colors: chartPalette,
            stroke: { width: 3, colors: [cardColor] },
            legend: { show: true, position: 'bottom', labels: { colors: legendColor } },
            tooltip: { theme: 'dark' }
          };
        case 'toolsStatusChart':
          return {
            chart: { height: 480, type: 'bar', fontFamily: fontFamily, background: 'transparent', toolbar: { show: true } },
            series: [{ name: 'Tools', data: dashboardData.statusCounts }],
            xaxis: { categories: dashboardData.statuses.map(s => s.charAt(0).toUpperCase() + s.slice(1)), labels: { style: { colors: labelColor } } },
            yaxis: { labels: { style: { colors: labelColor } } },
            colors: [successColor, warningColor, dangerColor, cyanColor],
            tooltip: { theme: 'dark' }
          };
        case 'toolsClaimedChart':
          return {
            chart: { height: 480, type: 'donut', fontFamily: fontFamily, background: 'transparent' },
            labels: ['Claimed & Verified', 'Unclaimed Community'],
            series: [dashboardData.claimedToolsCount || 0, dashboardData.unclaimedToolsCount || 0],
            colors: [pinkColor, '#332040'],
            stroke: { width: 3, colors: [cardColor] },
            legend: { show: true, position: 'bottom', labels: { colors: legendColor } },
            tooltip: { theme: 'dark' }
          };
        case 'toolsAddedTrendChart':
          return {
            chart: { height: 480, type: 'area', fontFamily: fontFamily, background: 'transparent', toolbar: { show: true } },
            series: [{ name: 'New AI Tools Listed', data: dashboardData.toolsAddedCounts }],
            xaxis: { categories: dashboardData.months, labels: { style: { colors: labelColor } } },
            yaxis: { labels: { style: { colors: labelColor } }, min: 0 },
            colors: [pinkColor],
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.05, stops: [0, 100] } },
            tooltip: { theme: 'dark' }
          };
        default: return null;
      }
    };

    document.querySelectorAll('.chart-maximize').forEach(btn => {
      btn.addEventListener('click', function () {
        const chartId = this.getAttribute('data-chart');
        const headerEl = this.closest('.card-header');
        const title = headerEl ? headerEl.querySelector('h5').textContent : 'Chart View';
        const config = getChartConfig(chartId);

        if (config) {
          modalTitle.textContent = title;
          modalContainer.innerHTML = '';
          chartModal.show();

          setTimeout(() => {
            if (modalChart) modalChart.destroy();
            modalChart = new ApexCharts(modalContainer, config);
            modalChart.render();
          }, 250);
        }
      });
    });

    chartModalEl.addEventListener('hidden.bs.modal', function () {
      if (modalChart) {
        modalChart.destroy();
        modalChart = null;
      }
      modalContainer.innerHTML = '';
    });
  }
})();
