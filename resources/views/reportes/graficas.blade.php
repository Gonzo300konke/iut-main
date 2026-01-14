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
                <!-- Gráfico de Bienes por Tipo -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienes por Tipo</h2>
                    <canvas id="chartTipo" class="w-96 h-56"></canvas>
                </div>

                <!-- Gráfico de Bienes por Estado -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienes por Estado</h2>
                    <canvas id="chartEstado" class="w-full h-64"></canvas>
                </div>

                <!-- Gráfico de Bienes por Registro (Progresivo) -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienes por Registro (Progresivo)</h2>
                    <canvas id="chartRegistro" class="w-full h-64"></canvas>
                </div>

                <!-- Gráfico de Bienes Desincorporados -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6 md:col-span-2">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bienes Desincorporados</h2>
                    <canvas id="chartDesincorporados" class="w-full h-64"></canvas>
                </div>


            <!-- Registro de Dependencias -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Registro de Dependencias</h2>
                <canvas id="chartDependencia" class="w-96 h-56"></canvas>
            </div>

            <!-- Registro de Unidades Administradoras -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Registro de Unidades Administradoras</h2>
                <canvas id="chartUnidad" class="w-96 h-56"></canvas>
            </div>

            <!-- Registro de Organismos -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Registro de Organismos</h2>
                <canvas id="chartOrganismo" class="w-96 h-56"></canvas>
            </div>
            </div>
            </div>


        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Bienes por Tipo
            const dataTipo = @json($bienesPorTipo);
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
            const dataEstado = @json($bienesPorEstado);
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
            const dataRegistro = @json($bienesPorRegistro);
            const labelsRegistro = Object.keys(dataRegistro);
            const valuesRegistro = Object.values(dataRegistro);

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
                        title: { display: true, text: 'Registro progresivo de Bienes por Mes' }
                    }
                }
            });

            // Bienes Desincorporados
            const dataDesincorporados = @json($bienesDesincorporados);
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
                        title: { display: true, text: 'Bienes Desincorporados por Mes' }
                    }
                }
            });
            // Registro de Dependencias
    const dataDependencia = @json($registroDependencias);
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
                title: { display: true, text: 'Registro de Dependencias por Mes' }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Registro de Unidades Administradoras
    const dataUnidad = @json($registroUnidades);
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
                title: { display: true, text: 'Registro de Unidades Administradoras por Mes' }
            },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Registro de Organismos
    const dataOrganismo = @json($registroOrganismos);
    const labelsOrganismo = Object.keys(dataOrganismo);
    const valuesOrganismo = Object.values(dataOrganismo);

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
                title: { display: true, text: 'Registro de Organismos por Mes' }
            },
            scales: { y: { beginAtZero: true } }
        }
    });



        </script>
@endsection
