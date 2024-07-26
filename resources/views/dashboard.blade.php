<x-app-layout>
    <x-header name="header">
        <h2 class="font-semibold text-gray-800 leading-tight">
            {{ __('Dashboardd') }}
        </h2>
    </x-header>

    <div class="flex flex-wrap px-3">
        <div
            class="grid gap-2  @role('landlord') grid-cols-3 w-full @endrole @role('tenant') grid-cols-1 w-1/3 @endrole">
            @role('landlord')
            <div class="">
                <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
                    <div class="text-left mb-4">
                        <p class="text-gray-600">Rooms</p>
                    </div>
                    <div class="flex justify-center mb-4">
                        <canvas id="myPieChart" class="w-full max-w-xs"></canvas>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center text-green-600 font-semibold mb-2">
                        </div>
                        <p class="text-gray-500">All rooms are occupied</p>
                    </div>
                </div>

            </div>
            <div class="">
                <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
                    <div class="text-left mb-4">
                        <p class="text-gray-600">Rooms</p>
                    </div>
                    <div class="flex justify-center mb-4">
                        <canvas id="rentPieChart"></canvas>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center text-green-600 font-semibold mb-2">
                        </div>
                        <p class="text-gray-500">All rooms are occupied</p>
                    </div>
                </div>

            </div>
            <div class="">
                <div class="pb-4 shadow-md overflow-hidden bg-white sm:rounded-lg h-72">
                    <div id="myChart3" class="h-72"></div>

                </div>
            </div>
            @endrole
            @role('tenant')
            <div class="w-full">
                <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
                    <div class="text-left mb-4">
                        <p class="text-gray-600">Rooms</p>
                    </div>
                    <div class="flex justify-center mb-4">
                        <canvas id="myPieChart" class="w-full max-w-xs"></canvas>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center text-green-600 font-semibold mb-2">
                        </div>
                        <p class="text-gray-500">All rooms are occupied</p>
                    </div>
                </div>

            </div>
            @endrole
        </div>
        {{-- Your main view file --}}
        <div
            class="grid @role('tenant') pl-2 grid-cols-2 w-2/3 @endrole @role('landlord') mt-2 grid-cols-3 w-full @endrole h-min gap-2 @role('tenant') @endrole">
            @role('tenant')
            <x-grid-item icon="bed" count="9" text="My room" link="/my-room"/>
            <x-grid-item icon="receipt" count="4" text="Lease agreements" link="/lease-agreements"/>
            @endrole
            <x-grid-item icon="document-text" count="9" text="Invoices" link="/invoices"/>
            @role('landlord')
            <x-grid-item icon="people" count="13" text="Tenants" link="/tenants"/>
            @endrole
            <x-grid-item icon="hammer" count="4" text="Maintenance tickets" link="/tickets"/>
            @role('landlord')
            <x-grid-item icon="business" count="5" text="Sites" link="/sites"/>
            @endrole
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
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {
        var data = google.visualization.arrayToDataTable([
            ['Element', 'Number of Tickets', {role: 'style'}],
            ['Pending', 5, '#FE6161'],
            ['Solved', 25, '#FED361'],
        ]);

        var options = {
            title: 'Maintenance Tickets',
            chartArea: {width: '50%'},
            hAxis: {
                title: 'Number of Tickets',
                minValue: 0
            },
            legend: {position: 'none'} // Hide the legend if not needed
        };

        var chart = new google.visualization.BarChart(document.getElementById('myChart3'));
        chart.draw(data, options);
    }
</script>
<script>
    const ctx = document.getElementById('myPieChart').getContext('2d');
    var nullRoomsCount = {{ $nullRoomsCount }};
    var occupiedRoomsCount = {{ $occupiedRoomsCount }};
    var totalRoomsCount = occupiedRoomsCount + nullRoomsCount;
    var occupiedPercentage = totalRoomsCount === 0 ? 0 : ((occupiedRoomsCount / totalRoomsCount) * 100);
    const data = {
        labels: ['Occupied', 'Vacant'],
        datasets: [{
            label: 'Visitors',
            data: [occupiedRoomsCount, nullRoomsCount],
            backgroundColor: [
                '#FED361',
                '#FE6161',
            ],
            hoverOffset: 4
        }]
    };

    const totalVisitors = data.datasets[0].data.reduce((a, b) => a + b, 0).toLocaleString();

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString();
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            cutout: '50%'
        },
        plugins: [{
            id: 'textCenter',
            beforeDraw: function (chart) {
                var width = chart.width,
                    height = chart.height,
                    ctx = chart.ctx;
                var yOffset = 14; // Adjust this value to move the text up or down

                ctx.restore();
                var fontSize = (height / 160).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";

                var text = occupiedPercentage + '%',
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = (height / 2) + yOffset;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    };

    new Chart(ctx, config);
</script>
<script>
    const ctx2 = document.getElementById('rentPieChart').getContext('2d');
    var rentCollected = 70;
    var rentPending = 20;
    var vacantCount = 10;
    var totalRentCount = rentCollected + rentPending + vacantCount;
    var rentCollectedPercentage = totalRentCount === 0 ? 0 : ((rentCollected / totalRentCount) * 100);

    const data2 = {
        labels: ['Rent Collected', 'Rent Pending', 'Vacant'],
        datasets: [{
            label: 'Rent Status',
            data: [rentCollected, rentPending, vacantCount],
            backgroundColor: [
                '#4CAF50',
                '#FFEB3B',
                '#FE6161',
            ],
            hoverOffset: 4
        }]
    };

    const config2 = {
        type: 'doughnut',
        data: data2,
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw.toLocaleString();
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            cutout: '50%'
        },
        plugins: [{
            id: 'textCenter2',
            beforeDraw: function (chart) {
                var width = chart.width,
                    height = chart.height,
                    ctx = chart.ctx;
                var yOffset = 14;

                ctx.restore();
                var fontSize = (height / 160).toFixed(2);
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";

                var text = rentCollectedPercentage + '%',
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = (height / 2) + yOffset;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    };

    new Chart(ctx2, config2);
</script>
