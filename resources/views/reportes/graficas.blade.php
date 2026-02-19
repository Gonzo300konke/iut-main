@extends('layouts.base')

@section('title', 'Gráficas')

@section('content')
        <div class="max-w-6xl mx-auto space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Gráficas</h1>
                    <p class="text-gray-600 mt-2 max-w-2xl">
                        Visualización gráfica de los bienes por tipo, estado, registro y desincorporación.
                    </p>
                </div>
            </div>

            <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-2">
                <!-- Valor total por Estado -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Valor total por Estado (Bs.)</h2>
                    <button data-chart="valorPorEstado" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                    <canvas id="chartValorEstado" class="w-full h-64"></canvas>
                </div>

                <!-- Top 10 Dependencias por Valor -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Top 10 Dependencias por Valor (Bs.)</h2>
                    <button data-chart="topDependencias" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                    <canvas id="chartTopDeps" class="w-full h-64"></canvas>
                </div>

                <!-- Cobertura de Fotografías -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Cobertura de Fotografías</h2>
                    <button data-chart="fotos" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                    <canvas id="chartFotos" class="w-96 h-56"></canvas>
                </div>

                <!-- Bienes sin Movimientos 12 meses -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienes sin Movimientos (12 meses)</h2>
                    <button data-chart="movimientos" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                    <canvas id="chartMovimientos" class="w-96 h-56"></canvas>
                </div>
                <!-- Gráfico de Bienes por Tipo -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienes por Tipo</h2>
                    <button data-chart="bienesPorTipo" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                    <canvas id="chartTipo" class="w-96 h-56"></canvas>
                </div>

                <!-- Gráfico de Bienes por Estado -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienes por Estado</h2>
                    <button data-chart="bienesPorEstado" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                    <canvas id="chartEstado" class="w-full h-64"></canvas>
                </div>

                <!-- Gráfico de Bienes por Registro (Progresivo) -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 md:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Bienes por Registro (Progresivo)</h2>
                        <button data-chart="bienesPorRegistro" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-gray-600">Granularidad:</label>
                            <select id="granularity" name="granularity" class="border-gray-300 rounded px-2 py-1 text-sm">
                                <option value="daily" @selected(request('granularity') == 'daily')>Diaria</option>
                                <option value="weekly" @selected(request('granularity') == 'weekly')>Semanal</option>
                                <option value="monthly" @selected(request('granularity', 'monthly') == 'monthly')>Mensual</option>
                            </select>
                        </div>
                    </div>
                    <canvas id="chartRegistro" class="w-full h-64"></canvas>
                </div>

                <!-- Gráfico de Bienes Desincorporados -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienes Desincorporados</h2>
                    <button data-chart="bienesDesincorporados" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                    <canvas id="chartDesincorporados" class="w-full h-64"></canvas>
                </div>


            <!-- Registro de Dependencias -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Registro de Dependencias</h2>
                <button data-chart="registroDependencias" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                <canvas id="chartDependencia" class="w-96 h-56"></canvas>
            </div>

            <!-- Registro de Unidades Administradoras -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Registro de Unidades Administradoras</h2>
                <button data-chart="registroUnidades" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                <canvas id="chartUnidad" class="w-96 h-56"></canvas>
            </div>

            <!-- Registro de Organismos -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Registro de Organismos</h2>
                <button data-chart="registroOrganismos" class="ml-2 inline-block px-3 py-1 text-xs bg-gray-100 rounded hover:bg-gray-200 download-btn">Descargar PDF</button>
                <canvas id="chartOrganismo" class="w-96 h-56"></canvas>
            </div>
            </div>
            </div>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Bienes por Tipo
            const dataTipo = (Object.keys(@json($bienesPorTipo)).length ? @json($bienesPorTipo) : { 'Sin datos': 0 });
            const labelsTipo = Object.keys(dataTipo);
            const valuesTipo = Object.values(dataTipo);

            new Chart(document.getElementById('chartTipo').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: labelsTipo,
                    datasets: [{
                        label: 'Cantidad',
                        data: valuesTipo,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Distribución de Bienes por Tipo' }
                    }
                }
            });

            // Bienes por Estado
            const dataEstado = (Object.keys(@json($bienesPorEstado)).length ? @json($bienesPorEstado) : { 'Sin datos': 0 });
            const labelsEstado = Object.keys(dataEstado);
            const valuesEstado = Object.values(dataEstado);

            new Chart(document.getElementById('chartEstado').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labelsEstado,
                    datasets: [{
                        label: 'Cantidad',
                        data: valuesEstado,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } },
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Bienes por Estado' }
                    }
                }
            });

            // Bienes por Registro (Progresivo)
            const dataRegistro = (Object.keys(@json($bienesPorRegistro)).length ? @json($bienesPorRegistro) : { 'Sin datos': 0 });
            const labelsRegistro = Object.keys(dataRegistro);
            const valuesRegistro = Object.values(dataRegistro);

            const granularity = @json($granularity ?? 'monthly');
            const granularityLabel = granularity === 'daily' ? 'Diaria' : (granularity === 'weekly' ? 'Semanal' : 'Mensual');

            new Chart(document.getElementById('chartRegistro').getContext('2d'), {
                type: 'line',
                data: {
                    labels: labelsRegistro,
                    datasets: [{
                        label: 'Cantidad Acumulada',
                        data: valuesRegistro,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } },
                    plugins: {
                        legend: { position: 'top' },
                                title: { display: true, text: `Registro progresivo de Bienes (${granularityLabel})` }
                    }
                }
            });

            // Bienes Desincorporados
            const dataDesincorporados = (Object.keys(@json($bienesDesincorporados)).length ? @json($bienesDesincorporados) : { 'Sin datos': 0 });
            const labelsDesincorporados = Object.keys(dataDesincorporados);
            const valuesDesincorporados = Object.values(dataDesincorporados);

            new Chart(document.getElementById('chartDesincorporados').getContext('2d'), {
                type: 'line',
                data: {
                    labels: labelsDesincorporados,
                    datasets: [{
                        label: 'Cantidad Desincorporada',
                        data: valuesDesincorporados,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } },
                    plugins: {
                                legend: { position: 'top' },
                                title: { display: true, text: `Bienes Desincorporados (${granularityLabel})` }
                    }
                }
            });
            // Registro de Dependencias
    const dataDependencia = (Object.keys(@json($registroDependencias)).length ? @json($registroDependencias) : { 'Sin datos': 0 });
    const labelsDependencia = Object.keys(dataDependencia);
    const valuesDependencia = Object.values(dataDependencia);

    new Chart(document.getElementById('chartDependencia').getContext('2d'), {
        type: 'line',
        data: {
            labels: labelsDependencia,
            datasets: [{
                label: 'Dependencias Registradas',
                data: valuesDependencia,
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: `Registro de Dependencias (${granularityLabel})` }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Listener para cambiar granularidad y recargar con el parámetro
    document.getElementById('granularity')?.addEventListener('change', function () {
        const g = this.value;
        const params = new URLSearchParams(window.location.search);
        params.set('granularity', g);
        // Mantener otros filtros
        window.location.search = params.toString();
    });

    // Registro de Unidades Administradoras
    const dataUnidad = (Object.keys(@json($registroUnidades)).length ? @json($registroUnidades) : { 'Sin datos': 0 });
    const labelsUnidad = Object.keys(dataUnidad);
    const valuesUnidad = Object.values(dataUnidad);

    new Chart(document.getElementById('chartUnidad').getContext('2d'), {
        type: 'line',
        data: {
            labels: labelsUnidad,
            datasets: [{
                label: 'Unidades Registradas',
                data: valuesUnidad,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: `Registro de Unidades Administradoras (${granularityLabel})` }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Registro de Organismos
    const dataOrganismo = (Object.keys(@json($registroOrganismos)).length ? @json($registroOrganismos) : { 'Sin datos': 0 });
    const labelsOrganismo = Object.keys(dataOrganismo);
    const valuesOrganismo = Object.values(dataOrganismo);

    // --- Nuevos datasets desde el servidor ---
    const dataValorPorEstado = (Object.keys(@json($valorPorEstado ?? [])).length ? @json($valorPorEstado) : { 'Sin datos': 0 });
    const labelsValorPorEstado = Object.keys(dataValorPorEstado);
    const valuesValorPorEstado = Object.values(dataValorPorEstado);

    const dataTopDeps = (Object.keys(@json($topDependenciasValor ?? [])).length ? @json($topDependenciasValor) : { 'Sin datos': 0 });
    const labelsTopDeps = Object.keys(dataTopDeps);
    const valuesTopDeps = Object.values(dataTopDeps);

    const dataFotos = (Object.keys(@json($fotoCoverage ?? [])).length ? @json($fotoCoverage) : { 'Sin datos': 0 });
    const labelsFotos = Object.keys(dataFotos);
    const valuesFotos = Object.values(dataFotos);

    const dataMov = (Object.keys(@json($movimientoCoverage ?? [])).length ? @json($movimientoCoverage) : { 'Sin datos': 0 });
    const labelsMov = Object.keys(dataMov);
    const valuesMov = Object.values(dataMov);

    // Si por alguna razón se inyectó una tabla en esta vista, ocultarla
    document.addEventListener('DOMContentLoaded', function () {
        const tabla = document.getElementById('tablaBienesContainer');
        if (tabla) tabla.style.display = 'none';
    });

    new Chart(document.getElementById('chartOrganismo').getContext('2d'), {
        type: 'line',
        data: {
            labels: labelsOrganismo,
            datasets: [{
                label: 'Organismos Registrados',
                data: valuesOrganismo,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: `Registro de Organismos (${granularityLabel})` }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Valor total por Estado
    new Chart(document.getElementById('chartValorEstado').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labelsValorPorEstado,
            datasets: [{
                label: 'Valor (Bs.)',
                data: valuesValorPorEstado,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: { responsive: false, maintainAspectRatio: false, scales: { y: { beginAtZero: true } }, plugins: { title: { display: true, text: 'Valor total por Estado (Bs.)' } } }
    });

    // Top 10 Dependencias por Valor (horizontal bar)
    new Chart(document.getElementById('chartTopDeps').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labelsTopDeps,
            datasets: [{
                label: 'Valor (Bs.)',
                data: valuesTopDeps,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: { indexAxis: 'y', responsive: false, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Top 10 Dependencias por Valor (Bs.)' } } }
    });

    // Cobertura de fotografías (doughnut)
    new Chart(document.getElementById('chartFotos').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labelsFotos,
            datasets: [{ data: valuesFotos, backgroundColor: ['#60A5FA', '#F87171'], hoverOffset: 6 }]
        },
        options: { responsive: false, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Cobertura de Fotografías' } } }
    });

    // Bienes sin movimientos (12 meses)
    new Chart(document.getElementById('chartMovimientos').getContext('2d'), {
        type: 'pie',
        data: { labels: labelsMov, datasets: [{ data: valuesMov, backgroundColor: ['#34D399', '#FBBF24'] }] },
        options: { responsive: false, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Bienes con/sin movimientos (12 meses)' } } }
    });

    // Descarga de PDFs por gráfica
    document.querySelectorAll('.download-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const chart = this.getAttribute('data-chart');
            const params = new URLSearchParams(window.location.search);
            if (chart) params.set('chart', chart);
            // Mantener granularity si existe en selector
            const g = document.getElementById('granularity')?.value;
            if (g) params.set('granularity', g);

            const url = `${window.location.pathname.replace(/\/graficas.*$/, '')}/graficas/pdf?${params.toString()}`;
            window.open(url, '_blank');
        });
    });



        </script>
@endsection
