<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-wrap gap-y-4 px-1 py-3">
        <div class="w-4/12 px-2">
            <div class="pb-4 shadow-md bg-white sm:rounded-lg"><canvas id="myChart"></canvas>
            </div>
        </div>
        <div class="w-4/12 px-2">
            <div class="pb-4 shadow-md bg-white sm:rounded-lg"><canvas id="myChart2"></canvas>
            </div>
        </div>
        <div class="w-4/12 px-2">
            <div class="pb-4 shadow-md bg-white sm:rounded-lg overflow-hidden">
                <div id="myChart3" style="width:100%; max-width:600px;"></div>

            </div>
        </div>
        <div class="w-3/12 px-2">
            <div class="shadow-md bg-white sm:rounded-lg">
                <div class="flex py-4 justify-between items-center px-6">
                    <ion-icon name="document-text" class="size-16 text-primary-600"></ion-icon>
                    <div class="flex flex-col items-end">
                        <p class="text-4xl font-semibold">9</p>
                        <p class="text-lg">Invoices</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-3/12 px-2">
            <div class="shadow-md bg-white sm:rounded-lg">
                <div class="flex py-4 justify-between items-center px-6">
                    <ion-icon name="people" class="size-16 text-primary-600"></ion-icon>
                    <div class="flex flex-col items-end">
                        <p class="text-4xl font-semibold">13</p>
                        <p class="text-lg">Tenants</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-3/12 px-2">
            <div class="shadow-md bg-white sm:rounded-lg">
                <div class="flex py-4 justify-between items-center px-6">
                    <ion-icon name="hammer" class="size-16 text-primary-600"></ion-icon>
                    <div class="flex flex-col items-end">
                        <p class="text-4xl font-semibold">4</p>
                        <p class="text-lg">Maintenance tickets</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-3/12 px-2">
            <div class="shadow-md bg-white sm:rounded-lg">
                <div class="flex py-4 justify-between items-center px-6">
                    <ion-icon name="business" class="size-16 text-primary-600"></ion-icon>
                    <div class="flex flex-col items-end">
                        <p class="text-4xl font-semibold">5</p>
                        <p class="text-lg">Sites</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-2 w-6/12">
            <h1 class="font-bold">Recent payments</h1>
            <!--div class="relative rounded-lg">
                <div class="shadow-md border-solid border-black border-2 rounded-lg">
                    <table class="table-fixed border-spacing-y-2 text-sm">
                        <thead class="bg-gray-700 text-white text-left">
                            <tr class="px-4">
                                <th>Song</th>
                                <th>Artist</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-solid border-black border-t">
                                <td>The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                                <td>Malcolm Lockyer</td>
                                <td>1961</td>
                            </tr>

                            <tr class="border-solid border-black border-t">
                                <td>Witchy Woman</td>
                                <td>The Eagles</td>
                                <td>1972</td>
                            </tr>
                            <tr class="border-solid border-black border-t">
                                <td>Shining Star</td>
                                <td>Earth, Wind, and Fire</td>
                                <td>1975</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </!--div-->
            <table class="table mt-1 rounded-lg shadow-md overflow-hidden">
                <thead class="table-active bg-gray-500">
                    <tr class="bg-gray-500">
                        <th scope="col">Invoice#</th>
                        <th scope="col">Names</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">12</th>
                        <td>Mark Buthelezi</td>
                        <td>R 1000</td>
                        <td>12 June</td>
                    </tr>
                    <tr>
                        <th scope="row">13</th>
                        <td>Jacob Malesa</td>
                        <td>R1 000</td>
                        <td>12 June</td>
                    </tr>
                    <tr>
                        <th scope="row">14</th>
                        <td>Larry Potter</td>
                        <td>R1 000</td>
                        <td>12 June</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-2 w-6/12">
            <h1 class="font-bold">Recent maintenance tickets</h1>
            <!--div class="relative rounded-lg">
                <div class="shadow-md border-solid border-black border-2 rounded-lg">
                    <table class="table-fixed border-spacing-y-2 text-sm">
                        <thead class="bg-gray-700 text-white text-left">
                            <tr class="px-4">
                                <th>Song</th>
                                <th>Artist</th>
                                <th>Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-solid border-black border-t">
                                <td>The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                                <td>Malcolm Lockyer</td>
                                <td>1961</td>
                            </tr>

                            <tr class="border-solid border-black border-t">
                                <td>Witchy Woman</td>
                                <td>The Eagles</td>
                                <td>1972</td>
                            </tr>
                            <tr class="border-solid border-black border-t">
                                <td>Shining Star</td>
                                <td>Earth, Wind, and Fire</td>
                                <td>1975</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </!--div-->
            <table class="table mt-1 rounded-lg shadow-md overflow-hidden">
                <thead class="table-active bg-gray-500">
                    <tr class="bg-gray-500">
                        <th scope="col">Invoice#</th>
                        <th scope="col">Names</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">12</th>
                        <td>Mark Buthelezi</td>
                        <td>R 1000</td>
                        <td>12 June</td>
                    </tr>
                    <tr>
                        <th scope="row">13</th>
                        <td>Jacob Malesa</td>
                        <td>R1 000</td>
                        <td>12 June</td>
                    </tr>
                    <tr>
                        <th scope="row">14</th>
                        <td>Larry Potter</td>
                        <td>R1 000</td>
                        <td>12 June</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Check if the user has a specific role -->
        @role('landlord')
        <p>This is visible to users with the landlord role.</p>
        @endrole

        <!-- Check if the user has a specific permission -->
        @can('edit sites')
            <p>This is visible to users with the edit sites permission.</p>
        @endcan

    </div>
</x-app-layout>
<script>
    var nullRoomsCount = {{ $nullRoomsCount }};
    var occupiedRoomsCount = {{ $occupiedRoomsCount }};

    var xValues = ["Collected", "Pending", "Vacant"];
    var yValues = [13, 4, 2];
    var barColors = ["#FED361", "#FE6161", "#5B5B5B"];

    new Chart("myChart", {
        type: "doughnut",
        data: {
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }],
            labels: xValues,

        },
        options: {
            title: {
                display: true,
                text: "Rent collected"
            }
        }
    });
</script>
<script>
    var nullRoomsCount = {{ $nullRoomsCount }};
    var occupiedRoomsCount = {{ $occupiedRoomsCount }};

    var xValues = ["Occupied", "Vacant"];
    var yValues = [occupiedRoomsCount, nullRoomsCount];
    var barColors = ["#FED361", "#FE6161"];

    new Chart("myChart2", {
        type: "doughnut",
        data: {
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }],
            labels: xValues,

        },
        options: {
            title: {
                display: true,
                text: "Rooms"
            }
        }
    });
</script>
<script>
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
            ['Element', 'Number of Tickets', { role: 'style' }],
            ['Pending', 5, '#FE6161'],
            ['Solved', 25, '#FED361'],
        ]);

        var options = {
            title: 'Maintenance Tickets',
            chartArea: { width: '50%' },
            hAxis: {
                title: 'Number of Tickets',
                minValue: 0
            },
            legend: { position: 'none' } // Hide the legend if not needed
        };

        var chart = new google.visualization.BarChart(document.getElementById('myChart3'));
        chart.draw(data, options);
    }
</script>
