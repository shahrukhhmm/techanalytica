'use strict';

(function () {
    let cardColor, headingColor, legendColor, labelColor, shadeColor, borderColor, fontFamily;

    function initColors() {
        if (typeof isDarkStyle !== 'undefined') {
            if (isDarkStyle) {
                cardColor = config.colors_dark.cardColor;
                headingColor = config.colors_dark.headingColor;
                legendColor = config.colors_dark.bodyColor;
                labelColor = config.colors_dark.textMuted;
                borderColor = config.colors_dark.borderColor;
            } else {
                cardColor = config.colors.cardColor;
                headingColor = config.colors.headingColor;
                legendColor = config.colors.bodyColor;
                labelColor = config.colors.textMuted;
                borderColor = config.colors.borderColor;
            }
            fontFamily = config.fontFamily;
        } else {
            console.warn("isDarkStyle or config not defined");
            cardColor = '#fff';
            headingColor = '#566a7f';
            legendColor = '#566a7f';
            labelColor = '#a1acb8';
            borderColor = '#d9dee3';
            fontFamily = 'Public Sans';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initColors();

        const tool1Select = $('#compareTool1');
        const tool2Select = $('#compareTool2');
        const comparisonContainer = document.getElementById('comparisonChartContainer');
        const loadingIndicator = document.getElementById('comparisonLoading');

        let comparisonChartInstance = null;
        let currentTool1Data = null;
        let currentTool2Data = null;

        // Manual select2 init removed as theme handles it.

        $(document).on('change select2:select', '#compareTool1', function (e) {
            console.log("Tool 1 changed event fired. Value:", $(this).val());
            fetchToolData($(this).val(), true);
        });

        $(document).on('change select2:select', '#compareTool2', function (e) {
            console.log("Tool 2 changed event fired. Value:", $(this).val());
            fetchToolData($(this).val(), false);
        });

        async function fetchToolData(toolId, isTool1) {
            if (!toolId) {
                if (isTool1) {
                    currentTool1Data = null;
                    document.getElementById('tool1Details').innerHTML = '<div class="text-center text-muted d-flex align-items-center justify-content-center" style="min-height: 200px;">Select a tool above to view details.</div>';
                } else {
                    currentTool2Data = null;
                    document.getElementById('tool2Details').innerHTML = '<div class="text-center text-muted d-flex align-items-center justify-content-center" style="min-height: 200px;">Select a tool above to view details.</div>';
                }
                checkCompareButton();
                return;
            }

            const detailsEl = isTool1 ? document.getElementById('tool1Details') : document.getElementById('tool2Details');
            if (detailsEl) detailsEl.innerHTML = '<div class="d-flex justify-content-center align-items-center" style="min-height: 200px;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            try {
                const response = await fetch(`/admin/api/compare-tools?${isTool1 ? 't1' : 't2'}=${toolId}`);
                const data = await response.json();

                if (data.status === 'success') {
                    if (isTool1) {
                        currentTool1Data = data.tool1;
                        renderComparisonDetails(currentTool1Data, null, true);
                    } else {
                        currentTool2Data = data.tool2;
                        renderComparisonDetails(null, currentTool2Data, false);
                    }
                } else {
                    if (detailsEl) detailsEl.innerHTML = `<div class="text-center text-danger">Error loading tool details.</div>`;
                }
            } catch (e) {
                console.error("Fetch tool error:", e);
                if (detailsEl) detailsEl.innerHTML = `<div class="text-center text-danger">An error occurred.</div>`;
            }

            checkCompareButton();
        }

        function checkCompareButton() {
            const t1Value = tool1Select.val();
            const t2Value = tool2Select.val();

            if (t1Value && t2Value && t1Value !== t2Value && currentTool1Data && currentTool2Data) {
                const chartSection = document.getElementById('radarChartSection');
                if (chartSection) chartSection.classList.remove('d-none');

                const chartEl = document.getElementById('toolComparisonRadarChart');
                if (chartEl) chartEl.style.display = 'block';

                renderComparisonChart(currentTool1Data, currentTool2Data);
            } else {
                const chartSection = document.getElementById('radarChartSection');
                if (chartSection) chartSection.classList.add('d-none');
            }
        }

        function renderComparisonChart(tool1, tool2) {
            const chartEl = document.querySelector('#toolComparisonRadarChart');
            if (!chartEl) return;

            if (comparisonChartInstance) {
                comparisonChartInstance.destroy();
            }

            const categories = ['Categories', 'Industries', 'Media Files'];

            const t1Data = [
                tool1.categories_count || 0,
                tool1.industries_count || 0,
                tool1.media_count || 0,
            ];

            const t2Data = [
                tool2.categories_count || 0,
                tool2.industries_count || 0,
                tool2.media_count || 0,
            ];

            const chartConfig = {
                chart: {
                    height: 400,
                    type: 'radar',
                    toolbar: { show: false },
                    dropShadow: {
                        enabled: true,
                        blur: 1,
                        left: 1,
                        top: 1
                    }
                },
                series: [
                    { name: tool1.name, data: t1Data },
                    { name: tool2.name, data: t2Data }
                ],
                labels: categories,
                stroke: { width: 2 },
                fill: { opacity: 0.2 },
                markers: { size: 5, hover: { size: 10 } },
                colors: [config.colors.primary, config.colors.warning],
                yaxis: { show: false },
                xaxis: {
                    labels: {
                        style: {
                            colors: [labelColor, labelColor, labelColor],
                            fontSize: '14px',
                            fontFamily: fontFamily
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    fontFamily: fontFamily,
                    labels: { colors: legendColor }
                }
            };

            comparisonChartInstance = new ApexCharts(chartEl, chartConfig);
            comparisonChartInstance.render();
        }

        function renderComparisonDetails(tool1, tool2, isTool1 = true) {
            if (tool1) {
                const details1El = document.getElementById('tool1Details');
                if (details1El) details1El.innerHTML = generateToolDetailsHTML(tool1);
            }

            if (tool2) {
                const details2El = document.getElementById('tool2Details');
                if (details2El) details2El.innerHTML = generateToolDetailsHTML(tool2);
            }
        }

        function generateToolDetailsHTML(tool) {
            const vendorName = tool.vendor ? tool.vendor.company_name : 'No Vendor provided';
            const tierName = tool.tier ? tool.tier.name : 'Unknown';
            const statusBadgeClass = getStatusBadgeClass(tool.status);
            const categoryNames = tool.categories && tool.categories.length ? tool.categories.map(c => `<span class="badge bg-label-primary me-1 mb-1">${c.name}</span>`).join('') : '';
            const industryNames = tool.industries && tool.industries.length ? tool.industries.map(i => `<span class="badge bg-label-info me-1 mb-1">${i.name}</span>`).join('') : '';
            const ctaTypeDisplay = tool.cta_type ? tool.cta_type.replace('_', ' ').toUpperCase() : 'N/A';

            const ctaTypeLower = tool.cta_type ? tool.cta_type.toLowerCase() : '';

            let logoHtml = '';
            if (tool.logo_url) {
                logoHtml = `<img src="${tool.logo_url}" alt="${tool.name} Logo" class="mb-3 rounded" style="max-height: 80px; max-width: 100%;" onerror="this.onerror=null; this.outerHTML='<div class=\\'mb-3 d-flex align-items-center justify-content-center bg-label-secondary rounded\\' style=\\'height: 80px; width: 80px;\\'><i class=\\'bx bx-wrench fs-2\\'></i></div>';">`;
            } else {
                logoHtml = `<div class="mb-3 d-flex align-items-center justify-content-center bg-label-secondary rounded" style="height: 80px; width: 80px;"><i class="bx bx-wrench fs-2"></i></div>`;
            }

            return `
                <div class="d-flex flex-column align-items-center mb-3">
                    ${logoHtml}
                    <h4 class="mb-1 text-center">${tool.name}</h4>
                    <span class="badge ${statusBadgeClass}">${tool.status ? tool.status.toUpperCase() : 'UNKNOWN'}</span>
                </div>
                <div class="mb-3 text-center">
                    <p class="text-muted mb-0">${tool.short_description || 'No description available.'}</p>
                </div>
                <div class="info-container">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2 pb-1"><span class="fw-medium me-2">Vendor:</span> <span>${vendorName}</span></li>
                        <li class="mb-2 pb-1"><span class="fw-medium me-2">Pricing Tier:</span> <span>${tierName}</span></li>
                        ${tool.pricing_text ? `<li class="mb-2 pb-1"><span class="fw-medium me-2">Pricing Details:</span> <span>${tool.pricing_text}</span></li>` : ''}
                    </ul>
                </div>
                <hr class="my-3">
                <div class="mb-3">
                    <h6 class="text-uppercase mb-2 text-muted fw-normal">Categories</h6>
                    <div class="d-flex flex-wrap">
                        ${categoryNames || '<span class="text-muted small">None</span>'}
                    </div>
                </div>
                <div class="mb-3">
                    <h6 class="text-uppercase mb-2 text-muted fw-normal">Industries</h6>
                    <div class="d-flex flex-wrap">
                        ${industryNames || '<span class="text-muted small">None</span>'}
                    </div>
                </div>
                <hr class="my-3">
                <div class="d-flex justify-content-center">
                     ${tool.website_url && ctaTypeLower !== 'website' ? `<a href="${tool.website_url}" target="_blank" class="btn btn-outline-primary btn-sm me-2"><i class="bx bx-globe me-1"></i> Website</a>` : ''}
                     ${tool.cta_url ? `<a href="${tool.cta_url}" target="_blank" class="btn btn-primary btn-sm">${ctaTypeDisplay}</a>` : ''}
                </div>
            `;
        }

        function getStatusBadgeClass(status) {
            switch (status) {
                case 'published': return 'bg-success';
                case 'draft': return 'bg-secondary';
                case 'pending': return 'bg-warning';
                case 'archived': return 'bg-danger';
                default: return 'bg-label-primary';
            }
        }
    });
})();
