<x-app-layout>
    <div class="flex">
        <x-side-nav activeLink="tenants"/>

        <div class="flex-grow flex-1 overflow-y-auto" style="height: calc(100vh - 4rem - 1px);">
            <x-header name="header">
                <div>
                    <nav class="breadcrumbs">
                        <ul class="flex font-medium text-sm">
                            <li class="mr-1"><a href="/dashboard">Dashboard</a></li>
                            <li class="mr-1"> ></li>
                            <li class="mr-1"><a href="/tenants">Tenants</a></li>
                            <li class="mr-1"> ></li>
                            <li class="mr-1">{{$tenant->name}}</li>
                        </ul>
                    </nav>
                    <h1 class="font-bold text-lg">{{$tenant->name}}</h1>
                </div>
            </x-header>

            <div x-data="{
    openLeaseModal: false, openInvoiceModal: false,
    viewInvoiceModal: false,
    deleteInvoiceModal: false,
    editInvoiceModal: false,
    viewLeaseModal: false,
    editLeaseModal: false,
    selectedInvoice: null,
    selectedLease: null,
    viewInvoice(invoice) {
        this.selectedInvoice = invoice;
        this.viewInvoiceModal = true;
    },
    confirmDeleteInvoice(invoice) {
        this.selectedInvoice = invoice;
        this.deleteInvoiceModal = true;
    },
    editInvoice(invoice) {
        this.selectedInvoice = invoice;
        this.editInvoiceModal = true;
    },
    viewLease(lease) {
        this.selectedLease = lease;
        this.viewLeaseModal = true;
    },
    editLease(lease) {
        this.selectedLease = lease;
        this.editLeaseModal = true;
    },
    toggleTermination(event) {
        this.selectedLease.is_terminated = event.target.checked;
    }
}" class="flex flex-wrap gap-y-4 px-3 pb-5">
                <div class="w-3/12 flex flex-col items-center">
                    <div class="w-full aspect-w-1 aspect-h-1 rounded-full overflow-hidden mt-4">
                        @php
                            $profileImagePath = 'images/profile/' . $tenant->id . '.jpg';
                            $defaultImagePath = 'images/profile/default.jpg';
                        @endphp
                        <img
                            src="{{ asset(file_exists(public_path($profileImagePath)) ? $profileImagePath : $defaultImagePath) }}"
                            alt="Tenant Image"
                            class="w-full h-full object-cover">
                    </div>
                    <h1 class="mt-2 text-xl font-bold">{{ ucfirst($tenant->name) }} {{ ucfirst($tenant->last_name) }}</h1>
                    <table class="w-full mt-1 border-collapse border-0">
                        <tbody>
                        <tr>
                            <td class="py-1 text-gray-700">ID no</td>
                            <td class="py-1 text-gray-900">:{{ $tenant->id_number }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-700">Email</td>
                            <td class="py-1 text-gray-900">:{{ $tenant->email }}</td>
                        </tr>
                        <tr>
                            <td class="py-1 text-gray-700">Phone</td>
                            <td class="py-1 text-gray-900">:{{ $tenant->phone }}</td>
                        </tr>
                        <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                    <div class="text-left w-full">
                        <h1 class="font-bold mt-3">Tenant rooms</h1>
                        @php
                            // Group rooms by site id
                            $groupedRooms = $rooms->groupBy('site.id');
                        @endphp

                        @foreach($groupedRooms as $siteId => $siteRooms)
                            <p class="mr-1/2">{{ $siteRooms->first()->site->name }}:
                                @php
                                    // Collect room names for this site
                                    $roomNames = $siteRooms->pluck('name')->implode(', ');
                                @endphp
                                {{ $roomNames }} </p>
                        @endforeach
                    </div>

                </div>
                <div class="w-9/12 pl-3">
                    <h1 class="text-left w-full font-bold">Maintenance tickets</h1>
                    <div class="grid grid-cols-3 w-full gap-2">
                        @if($tenant->tenantTickets && $tenant->tenantTickets->isNotEmpty())
                            @foreach($tenant->tenantTickets as $ticket)
                                <div class="bg-gray-300 px-4 h-min py-2 rounded-lg">
                                    <h1 class="font-bold">{{ $ticket->details }}</h1>
                                    @if(!empty($ticket->response))
                                        <h1>Re: {{ $ticket->response }}</h1>
                                    @endif
                                    <div class="flex w-full items-center justify-between mt-5">
                                        <div
                                            class="bg-danger w-min text-sm rounded-md px-2 py-1">{{ $ticket->status }}</div>
                                        <p>{{ $ticket->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No tickets available.</p>
                        @endif
                    </div>
                    <div class="w-full mt-7 flex justify-between items-end p-1">
                        <h1 class="font-bold">Invoices</h1>
                        @php
                            $hasActiveLease = $tenant->leaseAgreements
                                ->where('is_terminated', false)
                                ->where('end_date', '>=', now())
                                ->count() > 0;
                        @endphp
                        
                        <button @click="@if($hasActiveLease) openInvoiceModal = true @else alert('Cannot create invoice: No active lease agreement found. Please create a lease agreement first.') @endif"
                                class="bg-primary-600 shadow-md font-semibold text-black px-4 py-2 rounded-md hover:bg-primary-700 @if(!$hasActiveLease) opacity-50 cursor-not-allowed @endif">
                            + Create invoice
                        </button>
                    </div>
                    @if($tenant->invoices->isEmpty())
                        <p>No invoices found for this tenant.</p>
                    @else
                        <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                            <thead class="bg-gray-300">
                            <tr class="text-left">
                                <th class="px-4 py-2">Invoice#</th>
                                <th class="px-4 py-2">Site Details</th>
                                <th class="px-4 py-2">Room</th>
                                <th class="px-4 py-2">Issue Date</th>
                                <th class="px-4 py-2">Total Amount</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($tenant->invoices as $invoice)
                                <tr class="border-t border-gray-300 cursor-pointer hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $invoice->id }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $invoice->room->site->name }}</span>
                                            <span class="text-sm text-gray-600">{{ $invoice->room->site->full_address }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2">{{ $invoice->room->name }}</td>
                                    <td class="px-4 py-2">{{ $invoice->issue_date }}</td>
                                    <td class="px-4 py-2">R{{ number_format($invoice->amount, 2) }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($invoice->status) }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex">
                                            <button @click="viewInvoice({{ $invoice }})"
                                                    class="text-blue-500 hover:underline">
                                                <ion-icon name="eye" class="size-5 mr-1 text-gray-500"></ion-icon>
                                            </button>
                                            <button @click="editInvoice({{ $invoice }})" class="hover:text-gray-700">
                                                <ion-icon name="pencil" class="size-5 mr-1 text-gray-500"></ion-icon>
                                            </button>
                                            <button @click="confirmDeleteInvoice({{ $invoice }})" class="text-danger hover:text-red-700">
                                                <ion-icon name="trash" class="size-5"></ion-icon>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                    <div class="w-full flex mt-7 justify-between items-end p-1">
                        <h1 class="font-bold">Lease agreements</h1>
                        <button @click="openLeaseModal = true"
                                class="bg-primary-600 shadow-md font-semibold text-black px-4 py-2 rounded-md hover:bg-primary-700">
                            + Create agreement
                        </button>
                    </div>
                    @if($tenant->leaseAgreements->isEmpty())
                        <p>No lease agreements found for this tenant.</p>
                    @else
                        <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                            <thead class="bg-gray-300">
                            <tr class="text-left">
                                <th class="px-4 py-2">Lease#</th>
                                <th class="px-4 py-2">Site Details</th>
                                <th class="px-4 py-2">Room</th>
                                <th class="px-4 py-2">Term</th>
                                <th class="px-4 py-2">Is terminated</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($tenant->leaseAgreements as $leaseAgreement)
                                <tr class="border-t border-gray-300 cursor-pointer hover:bg-gray-100">
                                    <td class="px-4 py-2">{{ $leaseAgreement->id }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $leaseAgreement->room->site->name }}</span>
                                            <span class="text-sm text-gray-600">{{ $leaseAgreement->room->site->full_address }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2">{{ $leaseAgreement->room->name }}</td>
                                    <td class="px-4 py-2">
                                        @php
                                            $startDate = \Carbon\Carbon::parse($leaseAgreement->start_date)->format('d M Y');
                                            $endDate = \Carbon\Carbon::parse($leaseAgreement->end_date)->format('d M Y');
                                        @endphp
                                        {{ $startDate }} - {{ $endDate }}
                                    </td>
                                    <td class="px-4 py-2">{{ $leaseAgreement->is_terminated ? 'Yes' : 'No' }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex">
                                            <button @click="viewLease({{ $leaseAgreement }})" class="hover:text-gray-700">
                                                <ion-icon name="eye" class="size-5 mr-1 text-gray-500"></ion-icon>
                                            </button>
                                            <button @click="editLease({{ $leaseAgreement }})" class="hover:text-gray-700">
                                                <ion-icon name="pencil" class="size-5 mr-1 text-gray-500"></ion-icon>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <!-- Modal -->
                <div x-show="openLeaseModal" x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="fixed inset-0 flex items-center justify-center z-50">
                    <!-- Modal content -->
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative z-50">
                        <h2 class="text-xl font-bold mb-4">Create Lease Agreement</h2>
                        <form action="{{ route('lease-agreements.store') }}" method="POST">
                            @csrf

                            <!-- Hidden input to pass the tenant ID -->
                            <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">

                            <div class="mb-4">
                                <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                                <select name="room_id" id="room_id"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <option value="" disabled selected>Select a room</option>
                                    @foreach($rooms as $room)
                                        <option
                                            value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                            {{ $room->name }} ({{ $room->site->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start
                                    Date:</label>
                                <input type="date" name="start_date" id="start_date"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       value="{{ old('start_date') }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End
                                    Date:</label>
                                <input type="date" name="end_date" id="end_date"
                                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                       value="{{ old('end_date') }}" required>
                            </div>

                            <div class="flex justify-end">
                                <button @click="openLeaseModal = false" type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 mr-2">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="bg-primary-700 text-black px-4 py-2 rounded-md hover:bg-primary-800">
                                    Create
                                    Lease Agreement
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Overlay -->
                    <div @click="openLeaseModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                </div>

                <!-- Modal -->
                <div x-show="openInvoiceModal" x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="fixed inset-0 flex items-center justify-center z-50">
                    <!-- Modal content -->
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative z-50">
                        <h2 class="text-xl font-bold mb-4">Create Invoice</h2>
                        <form action="{{ route('invoices.store') }}" method="POST">
                            @csrf

                            <!-- Hidden input to pass additional IDs if needed -->
                            <input type="hidden" name="tenant_id" value="{{ $tenant->id ?? '' }}">

                            <!-- Dropdown for selecting a room -->
                            <div class="mb-4">
                                <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                                <select name="room_id" id="room_id"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <option value="">Select a room</option>
                                    @foreach($rooms as $room)
                                        @php
                                            $hasActiveLease = $tenant->leaseAgreements
                                                ->where('room_id', $room->id)
                                                ->where('is_terminated', false)
                                                ->where('end_date', '>=', now())
                                                ->count() > 0;
                                        @endphp
                                        @if($hasActiveLease)
                                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                {{ $room->name }} - {{ $room->site->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="mb-4">
                                    <label for="issue_date" class="block text-gray-700 text-sm font-bold mb-2">Issue
                                        Date:</label>
                                    <input type="date" name="issue_date" id="issue_date"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           value="{{ old('issue_date') }}" required>
                                </div>

                                <div class="mb-4">
                                    <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Due
                                        Date:</label>
                                    <input type="date" name="due_date" id="due_date"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           value="{{ old('due_date') }}" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="mb-4">
                                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Rent
                                        Amount:</label>
                                    <input type="number" name="amount" id="amount" step="0.01"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           value="{{ old('amount') }}" required>
                                </div>
                                <div class="mb-4">
                                    <label for="paid_amount" class="block text-gray-700 text-sm font-bold mb-2">Paid
                                        Amount:</label>
                                    <input type="number" name="paid_amount" id="paid_amount" step="0.01"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           value="{{ old('paid_amount') }}"/>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                <select name="status" id="status"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue
                                    </option>
                                    <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>
                                        Canceled
                                    </option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="mb-4">
                                    <label for="water_charge" class="block text-gray-700 text-sm font-bold mb-2">Water
                                        Charge:</label>
                                    <input type="number" name="water_charge" id="water_charge" step="0.01"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           value="{{ old('water_charge') }}"/>
                                </div>

                                <div class="mb-4">
                                    <label for="electricity_charge" class="block text-gray-700 text-sm font-bold mb-2">Electricity
                                        Charge:</label>
                                    <input type="number" name="electricity_charge" id="electricity_charge" step="0.01"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           value="{{ old('electricity_charge') }}"/>
                                </div>

                                <div class="mb-4">
                                    <label for="other_charges" class="block text-gray-700 text-sm font-bold mb-2">Other
                                        Charges:</label>
                                    <input type="number" name="other_charges" id="other_charges" step="0.01"
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                           value="{{ old('other_charges') }}"/>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="description"
                                       class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                                <textarea name="description" id="description"
                                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                          rows="4">{{ old('description') }}</textarea>
                            </div>

                            <div class="flex justify-end">
                                <button @click="openInvoiceModal = false" type="button"
                                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700 mr-2">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="bg-primary-700 text-white px-4 py-2 rounded-md hover:bg-primary-800">
                                    Create
                                    Invoice
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Overlay -->
                    <div @click="openInvoiceModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                </div>

                <!-- Add the View Invoice Modal -->
                <div x-show="viewInvoiceModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="fixed inset-0 flex items-center justify-center z-50">
                    
                    <!-- Modal content -->
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative z-50">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">View Invoice</h2>
                            <button @click="viewInvoiceModal = false" class="text-gray-500 hover:text-gray-700">
                                <ion-icon name="close" class="size-6"></ion-icon>
                            </button>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="space-y-4">
                                <!-- Site Details Section -->
                                <div class="border-b pb-4">
                                    <h3 class="font-medium text-gray-700">Property Details</h3>
                                    <div class="mt-2">
                                        <div class="text-gray-900 font-medium" x-text="selectedInvoice?.room?.site?.name"></div>
                                        <div class="text-sm text-gray-600" x-text="selectedInvoice?.room?.site?.address_line1"></div>
                                        <div class="text-sm text-gray-600" x-text="selectedInvoice?.room?.site?.address_line2"></div>
                                        <div class="text-sm text-gray-600" x-text="(selectedInvoice?.room?.site?.city || '') + (selectedInvoice?.room?.site?.postal_code ? ', ' + selectedInvoice?.room?.site?.postal_code : '')"></div>

                                        <div class="text-sm text-gray-700 mt-1">
                                            Room: <span x-text="selectedInvoice?.room?.name"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rest of the invoice details remain unchanged -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Invoice Number</label>
                                        <div class="mt-1 text-gray-900" x-text="selectedInvoice?.id"></div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <div class="mt-1 text-gray-900 capitalize" x-text="selectedInvoice?.status"></div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                                        <div class="mt-1 text-gray-900" x-text="selectedInvoice?.issue_date"></div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                        <div class="mt-1 text-gray-900" x-text="selectedInvoice?.due_date"></div>
                                    </div>
                                </div>

                                <!-- Rest of your existing invoice details... -->

                                <div class="flex justify-end mt-6 space-x-3">
                                    <a :href="'/invoices/' + selectedInvoice?.id + '/print'" 
                                       target="_blank"
                                       class="bg-primary-600 text-black px-4 py-2 rounded-md hover:bg-primary-700 flex items-center">
                                        <ion-icon name="print-outline" class="size-5 mr-2"></ion-icon>
                                        Print Invoice
                                    </a>
                                    <button @click="viewInvoiceModal = false"
                                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Overlay -->
                    <div @click="viewInvoiceModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                </div>

                <!-- Delete Invoice Confirmation Modal -->
                <div x-show="deleteInvoiceModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="fixed inset-0 flex items-center justify-center z-50">
                    
                    <!-- Modal content -->
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full relative z-50">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Delete Invoice</h2>
                            <button @click="deleteInvoiceModal = false" class="text-gray-500 hover:text-gray-700">
                                <ion-icon name="close" class="size-6"></ion-icon>
                            </button>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <p class="text-gray-700 mb-4">Are you sure you want to delete invoice #<span x-text="selectedInvoice?.id"></span>?</p>
                            <p class="text-gray-600 mb-6">This action cannot be undone.</p>

                            <form :action="'/invoices/' + selectedInvoice?.id" method="POST" class="flex justify-end space-x-3">
                                @csrf
                                @method('DELETE')
                                
                                <button type="button" 
                                        @click="deleteInvoiceModal = false"
                                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                    Cancel
                                </button>
                                
                                <button type="submit"
                                        class="bg-danger text-white px-4 py-2 rounded-md hover:bg-red-700">
                                    Delete Invoice
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Overlay -->
                    <div @click="deleteInvoiceModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                </div>

                <!-- Edit Invoice Modal -->
                <div x-show="editInvoiceModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="fixed inset-0 flex items-center justify-center z-50">
                    
                    <!-- Modal content -->
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative z-50">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Edit Invoice</h2>
                            <button @click="editInvoiceModal = false" class="text-gray-500 hover:text-gray-700">
                                <ion-icon name="close" class="size-6"></ion-icon>
                            </button>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <form :action="'/invoices/' + selectedInvoice?.id" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                                    <select name="room_id" id="room_id"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            required>
                                        @foreach($rooms as $room)
                                            <option :value="{{ $room->id }}" 
                                                    :selected="selectedInvoice?.room_id == {{ $room->id }}">
                                                {{ $room->name }} - {{ $room->site->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="mb-4">
                                        <label for="issue_date" class="block text-gray-700 text-sm font-bold mb-2">Issue Date:</label>
                                        <input type="date" name="issue_date" id="issue_date"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               :value="selectedInvoice?.issue_date"
                                               required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="due_date" class="block text-gray-700 text-sm font-bold mb-2">Due Date:</label>
                                        <input type="date" name="due_date" id="due_date"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               :value="selectedInvoice?.due_date"
                                               required>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="mb-4">
                                        <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Rent Amount:</label>
                                        <input type="number" name="amount" id="amount" step="0.01"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               :value="selectedInvoice?.amount"
                                               required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="paid_amount" class="block text-gray-700 text-sm font-bold mb-2">Paid Amount:</label>
                                        <input type="number" name="paid_amount" id="paid_amount" step="0.01"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               :value="selectedInvoice?.paid_amount">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                                    <select name="status" id="status"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            required>
                                        <option value="pending" :selected="selectedInvoice?.status === 'pending'">Pending</option>
                                        <option value="paid" :selected="selectedInvoice?.status === 'paid'">Paid</option>
                                        <option value="overdue" :selected="selectedInvoice?.status === 'overdue'">Overdue</option>
                                        <option value="canceled" :selected="selectedInvoice?.status === 'canceled'">Canceled</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="mb-4">
                                        <label for="water_charge" class="block text-gray-700 text-sm font-bold mb-2">Water Charge:</label>
                                        <input type="number" name="water_charge" id="water_charge" step="0.01"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               :value="selectedInvoice?.water_charge">
                                    </div>

                                    <div class="mb-4">
                                        <label for="electricity_charge" class="block text-gray-700 text-sm font-bold mb-2">Electricity Charge:</label>
                                        <input type="number" name="electricity_charge" id="electricity_charge" step="0.01"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               :value="selectedInvoice?.electricity_charge">
                                    </div>

                                    <div class="mb-4">
                                        <label for="other_charges" class="block text-gray-700 text-sm font-bold mb-2">Other Charges:</label>
                                        <input type="number" name="other_charges" id="other_charges" step="0.01"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               :value="selectedInvoice?.other_charges">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                                    <textarea name="description" id="description"
                                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                              rows="4" x-text="selectedInvoice?.description"></textarea>
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <button type="button" 
                                            @click="editInvoiceModal = false"
                                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                        Cancel
                                    </button>
                                    
                                    <button type="submit"
                                            class="bg-primary-600 text-black px-4 py-2 rounded-md hover:bg-primary-700">
                                        Update Invoice
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Overlay -->
                    <div @click="editInvoiceModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                </div>

                <!-- View Lease Modal -->
                <div x-show="viewLeaseModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="fixed inset-0 flex items-center justify-center z-50">
                    
                    <!-- Modal content -->
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl w-full relative z-50">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Lease Agreement Details</h2>
                            <button @click="viewLeaseModal = false" class="text-gray-500 hover:text-gray-700">
                                <ion-icon name="close" class="size-6"></ion-icon>
                            </button>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <!-- Site Details Section -->
                            <div class="border-b pb-4">
                                <h3 class="font-medium text-gray-700">Property Details</h3>
                                <div class="mt-2">
                                    <div class="text-gray-900 font-medium" x-text="selectedLease?.room?.site?.name"></div>
                                    <div class="text-sm text-gray-600" x-text="selectedLease?.room?.site?.address_line1"></div>
                                    <div class="text-sm text-gray-600" x-text="selectedLease?.room?.site?.address_line2"></div>
                                    <div class="text-sm text-gray-600" x-text="(selectedLease?.room?.site?.city || '') + (selectedLease?.room?.site?.postal_code ? ', ' + selectedLease?.room?.site?.postal_code : '')"></div>
                                    <div class="text-sm text-gray-700 mt-1">
                                        Room: <span x-text="selectedLease?.room?.name"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <p class="text-gray-600">Agreement Number</p>
                                    <p class="font-semibold" x-text="selectedLease?.id"></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">Status</p>
                                    <div>
                                        <p class="font-semibold" x-text="selectedLease?.is_terminated ? 'Terminated' : 'Active'"></p>
                                        <template x-if="selectedLease?.is_terminated && selectedLease?.termination_date">
                                            <p class="text-sm text-gray-500" 
                                               x-text="'Terminated on: ' + new Date(selectedLease?.termination_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })">
                                            </p>
                                        </template>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray-600">Start Date</p>
                                    <p class="font-semibold" x-text="selectedLease ? new Date(selectedLease.start_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : ''"></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">End Date</p>
                                    <p class="font-semibold" x-text="selectedLease ? new Date(selectedLease.end_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }) : ''"></p>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <a :href="'/lease-agreements/' + selectedLease?.id + '/print'" 
                                   target="_blank"
                                   class="bg-primary-600 text-black px-4 py-2 rounded-md hover:bg-primary-700 flex items-center">
                                    <ion-icon name="print-outline" class="size-5 mr-2"></ion-icon>
                                    Print Agreement
                                </a>
                                <button @click="viewLeaseModal = false" 
                                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Overlay -->
                    <div @click="viewLeaseModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                </div>

                <!-- Edit Lease Modal -->
                <div x-show="editLeaseModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-90"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-90"
                     class="fixed inset-0 flex items-center justify-center z-50">
                    
                    <!-- Modal content -->
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative z-50">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Edit Lease Agreement</h2>
                            <button @click="editLeaseModal = false" class="text-gray-500 hover:text-gray-700">
                                <ion-icon name="close" class="size-6"></ion-icon>
                            </button>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <form :action="'/lease-agreements/' + selectedLease?.id" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="room_id" class="block text-gray-700 text-sm font-bold mb-2">Room:</label>
                                    <select name="room_id" id="room_id"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            required>
                                        @foreach($rooms as $room)
                                            <option :value="{{ $room->id }}" 
                                                    :selected="selectedLease?.room_id == {{ $room->id }}">
                                                {{ $room->name }} - {{ $room->site->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="mb-4">
                                        <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
                                        <input type="date" 
                                               name="start_date" 
                                               id="start_date"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               x-bind:value="selectedLease ? new Date(selectedLease.start_date).toISOString().split('T')[0] : ''"
                                               required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
                                        <input type="date" 
                                               name="end_date" 
                                               id="end_date"
                                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                               x-bind:value="selectedLease ? new Date(selectedLease.end_date).toISOString().split('T')[0] : ''"
                                               required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="flex items-center">
                                        <input type="checkbox" 
                                               name="is_terminated" 
                                               value="1"
                                               :checked="selectedLease?.is_terminated == 1"
                                               @change="toggleTermination($event)"
                                               class="form-checkbox h-5 w-5 text-primary-600">
                                        <span class="ml-2 text-gray-700">Terminate Lease</span>
                                    </label>
                                    <template x-if="selectedLease?.is_terminated && selectedLease?.termination_date">
                                        <p class="text-sm text-gray-500 mt-1" 
                                           x-text="'Terminated on: ' + new Date(selectedLease?.termination_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' })">
                                        </p>
                                    </template>
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <button type="button" 
                                            @click="editLeaseModal = false"
                                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                                        Cancel
                                    </button>
                                    
                                    <button type="submit"
                                            class="bg-primary-600 text-black px-4 py-2 rounded-md hover:bg-primary-700">
                                        Update Lease Agreement
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Overlay -->
                    <div @click="editLeaseModal = false" class="fixed inset-0 bg-black opacity-50 z-40"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
