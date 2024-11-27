@section('header', __('Dashboard'))
@section('section', __('General'))

<div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-4">
        <x-card>
            <x-card-counter-section url="#0" label="Clientes" icon="fa-solid fa-users" counter="{{ $users->count() }}"
                color="blue" />
        </x-card>
        <x-card>
            <x-card-counter-section url="#0" label="Medios" icon="fa-solid fa-tags"
                counter="{{ $categories->count() }}" color="red" />
        </x-card>
        <x-card>
            <x-card-counter-section url="#0" label="Productos" icon="fa-solid fa-video"
                counter="{{ $products->count() }}" color="yellow" />
        </x-card>
        <x-card>
            <x-card-counter-section url="#0" label="Ventas" icon="fa-solid fa-list"
                counter="{{ $ventas->count() }}" color="green" />
        </x-card>
    </div>

    <x-card class="mb-4">
        <div class="grid grid-cols-5 gap-3">
            <x-select-label label="Año" wire:model.live="yearSelected">
                <option value="" selected>Todos</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}">
                        {{ $year }}</option>
                @endforeach
            </x-select-label>
            <x-select-label label="Trimestre" wire:model.live="quarterSelected">
                <option value="" selected>Todos</option>
                @foreach ($quarters as $quarter)
                    <option value="{{ $quarter['quarter'] }}">
                        {{ $quarter['label'] }}</option>
                @endforeach
            </x-select-label>
            <x-select-label label="Mes" wire:model.live="monthSelected">
                <option value="" selected>Todos</option>
                @foreach ($meses as $mes)
                    <option value="{{ $mes['id'] }}">{{ $mes['name'] }}</option>
                @endforeach
            </x-select-label>

            <x-select-label label="Día" wire:model.live="daySelected">
                <option value="" selected>Todos</option>
                @foreach ($days as $day)
                    <option value="{{ $day['day'] }}">
                        {{ $day['label'] }}
                    </option>
                @endforeach
            </x-select-label>
            <x-select-label label="Genero" wire:model.live="generoSelected">
                <option value="" selected>Todos</option>
                @foreach ($generos as $genero)
                    <option value="{{ $genero }}">
                        {{ ucfirst($genero) }}
                    </option>
                @endforeach
            </x-select-label>
        </div>
    </x-card>

    <div class="grid grid-cols-4 gap-4 mb-4">
        <div class="flex flex-col gap-4 col-span-3">
            <div class="grid grid-cols-2 gap-4">
                <x-card>
                    <div class="mx-auto">
                        <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Numero de ventas por vendedor
                            </h2>
                        </header>
                        <div wire:ignore>
                            <canvas id="chartBar1" height="280"></canvas>
                        </div>
                    </div>
                </x-card>
                <x-card>
                    <div class="mx-auto">
                        <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Numero de ventas por medio
                            </h2>
                        </header>
                        <div wire:ignore class="flex justify-center mt-3 h-80">
                            <canvas id="pie1"></canvas>
                        </div>
                    </div>
                </x-card>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <x-card>
                    <div class="mx-auto">
                        <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Numero de ventas por medio
                            </h2>
                        </header>
                        <div wire:ignore>
                            <canvas id="chartBar2" height="280"></canvas>
                        </div>
                    </div>
                </x-card>
                <x-card>
                    <div>
                        <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                            <h2 class="font-semibold text-gray-800 dark:text-gray-100">Numero de ventas por vendedor
                            </h2>
                        </header>
                        <div wire:ignore class="flex justify-center mt-3 h-80">
                            <canvas id="pie2"></canvas>
                        </div>
                    </div>
                </x-card>
            </div>
            <x-card>
                <div>
                    <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-100">Ventas por cliente
                        </h2>
                    </header>
                    <div class="mt-3 h-80 overflow-auto">
                        <x-table-container>
                            <table class="w-full text-left table-auto min-w-max">
                                <x-table-thead>
                                    <tr>
                                        <th class="p-2 font-normal">Cliente</th>
                                        <th class="p-2 font-normal">Genero</th>
                                        <th class="p-2 font-normal">Medio</th>
                                        <th class="p-2 font-normal">Cantidad</th>
                                        <th class="p-2 font-normal">Total</th>
                                    </tr>
                                </x-table-thead>
                                <tbody class="text-sm divide-y divide-gray-300">
                                    @foreach ($ventasClientes as $item)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="p-2">
                                                {{ $item['cliente'] }}
                                            </td>
                                            <td class="p-2">
                                                {{ $item['genero'] }}
                                            </td>
                                            <td class="p-2">
                                                {{ $item['medio'] }}
                                            </td>
                                            <td class="p-2">
                                                {{ $item['cantidad_ventas'] }}
                                            </td>
                                            <td class="p-2">
                                                {{ $item['total_ventas'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </x-table-container>
                    </div>
                </div>
            </x-card>
        </div>
        <div class="flex flex-col gap-4">
            <x-card>
                <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Total de ventas
                    </h2>
                </header>

                <div class="mt-2 text-center text-lg bg-gray-700 rounded-lg text-white py-1">
                    S/. {{ $totalVentas }}
                </div>
            </x-card>
            <x-card>
                <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Total de ventas por vendedor
                    </h2>
                </header>

                @foreach ($bar1 as $item)
                    <div class="mt-2 text-center text-sm rounded-lg py-1 flex justify-between">
                        <div>{{ $item['vendedor'] }}</div>
                        <div>S/. {{ $item['total_ventas'] }}</div>
                    </div>
                @endforeach
            </x-card>

            <x-card>
                <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Total de ventas por medio
                    </h2>
                </header>

                @foreach ($pie1 as $item)
                    <div class="mt-2 text-center text-xs rounded-lg py-1 flex justify-between">
                        <div>{{ $item['medio'] }}</div>
                        <div>S/. {{ $item['total_ventas'] }}</div>
                    </div>
                @endforeach
            </x-card>

            <x-card>
                <header class="pb-4 border-b border-gray-100 dark:border-gray-700/60">
                    <h2 class="font-semibold text-gray-800 dark:text-gray-100">Total de ventas por genero
                    </h2>
                </header>

                <div class="h-96 overflow-auto pr-2">
                    @foreach ($vgeneros as $item)
                        <div class="mt-2 text-center text-xs rounded-lg py-1 flex justify-between">
                            <div>{{ $item['genero'] }}</div>
                            <div>S/. {{ $item['total_ventas'] }}</div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script type="module">
        // Configuración inicial del gráfico
        const chartBardata = {
            labels: @json($labels1),
            datasets: [{
                label: 'Numero de ventas',
                data: @json($data1),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 205, 86, 0.5)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                borderWidth: 1
            }]
        };

        const chartBardata2 = {
            labels: @json($labels2),
            datasets: [{
                label: 'Numero de ventas',
                data: @json($data2),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 205, 86, 0.5)',
                    'rgba(22, 163, 74, 0.5)',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(22, 163, 74)',
                ],
                borderWidth: 1
            }]
        };

        const configchartBar = {
            type: 'bar',
            data: chartBardata,
            options: {},
        };

        const configchartBar2 = {
            type: 'bar',
            data: chartBardata2,
            options: {},
        };

        var chartBar = new Chart(
            document.getElementById("chartBar1"),
            configchartBar
        );

        var chartBar2 = new Chart(
            document.getElementById("chartBar2"),
            configchartBar2
        );

        const polarAreadata = {
            labels: @json($labels2),
            datasets: [{
                label: 'Numero de ventas',
                data: @json($data2),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 205, 86, 0.5)',
                    'rgba(22, 163, 74, 0.5)',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(22, 163, 74)',
                ],
                borderWidth: 1
            }]
        };

        const polarAreadata2 = {
            labels: @json($labels1),
            datasets: [{
                label: 'Numero de ventas',
                data: @json($data1),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 205, 86, 0.5)',
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                ],
                borderWidth: 1
            }]
        };

        const configpolarArea = {
            type: 'pie',
            data: polarAreadata,
            options: {},
        };

        const configpolarArea2 = {
            type: 'pie',
            data: polarAreadata2,
            options: {},
        };

        var polarArea = new Chart(
            document.getElementById("pie1"),
            configpolarArea
        );

        var polarArea2 = new Chart(
            document.getElementById("pie2"),
            configpolarArea2
        );

        const chartBarMonthsdata = {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre",
                "Noviembre", "Diciembre"
            ],
            datasets: [{
                label: 'Numero de Noticias',
                data: @json($dataMes),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]
        };

        const configchartBarMonths = {
            type: 'bar',
            data: chartBarMonthsdata,
            options: {},
        };

        var chartBarMonths = new Chart(
            document.getElementById("chartBarMonths"),
            configchartBarMonths
        );

        Livewire.on('post-created', event => {
            // Actualizar los datos del gráfico
            chartBar.data.datasets[0].data = event[0].dataAll[0];
            chartBar.update();

            chartBar2.data.datasets[0].data = event[0].dataToday[0];
            chartBar2.update();

            polarArea.data.datasets[0].data = event[0].dataToday[0];
            polarArea.update();

            polarArea2.data.datasets[0].data = event[0].dataAll[0];
            polarArea2.update();
        })
    </script>

</div>
