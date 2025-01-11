<x-app-layout>
    <div class="flex">
        <x-side-nav activeLink="applications" />

        <div class="flex-grow flex-1 overflow-y-auto" style="height: calc(100vh - 4rem - 1px);">
            <div class="px-3">
                <div class="flex flex-wrap gap-y-4">
                    @if(count($applications) === 0)
                    <p>No applications found.</p>
                    @else
                    <table class="table-auto w-full mt-1 rounded-lg shadow-md overflow-hidden">
                        <thead class="bg-gray-300">
                            <tr class="text-left">
                                <th class="px-4 py-2">Tenant Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Phone</th>
                                <th class="px-4 py-2">Site & Address</th>
                                <th class="px-4 py-2">Application Date</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($applications as $application)
                            <tr class="border-t border-gray-300">
                                <td class="px-4 py-2">{{ $application->tenant->name }} {{ $application->tenant->last_name }}</td>
                                <td class="px-4 py-2">{{ $application->tenant->email }}</td>
                                <td class="px-4 py-2">{{ $application->tenant->phone }}</td>
                                <td class="px-4 py-2">
                                    <strong>{{ $application->site->name }}</strong><br>
                                    {{ $application->site->address_line1 }}
                                </td>
                                <td class="px-4 py-2">{{ $application->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2">
                                    <div>
                                        {{ ucfirst($application->status) }}

                                        @if($application->status == 'terminated' || $application->status == 'rejected')
                                        @if($application->termination_reason)
                                        <br><span class="text-yellow-500">Termination reason: {{ $application->termination_reason }}</span>
                                        @endif

                                        @if($application->rejection_reason)
                                        <br><span class="text-red-500">Rejection reason: {{ $application->rejection_reason }}</span>
                                        @endif
                                        @elseif($application->status == 'pending')
                                        @if($application->previously_rejected && $application->rejection_reason)
                                        <br><span class="text-red-500">Previously rejected: {{ $application->rejection_reason }}</span>
                                        @elseif($application->previously_rejected)
                                        <br><span class="text-red-500">Was previously rejected</span>
                                        @endif

                                        @if($application->previously_terminated && $application->termination_reason)
                                        <br><span class="text-yellow-500">Previously terminated: {{ $application->termination_reason }}</span>
                                        @elseif($application->previously_terminated)
                                        <br><span class="text-yellow-500">Was previously terminated</span>
                                        @endif
                                        @endif
                                    </div>
                                </td>

                                <td class="px-4 py-2 relative">
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="text-gray-600 hover:text-gray-800">
                                            <ion-icon name="ellipsis-horizontal" class="size-4"></ion-icon>
                                        </button>
                                        <div
                                            x-show="open"
                                            @click.away="open = false"
                                            class="absolute right-0 mt-2 w-32 bg-white border border-gray-300 rounded-lg shadow-lg z-10"
                                            style="display: none;">
                                            @if($application->status === 'pending')
                                            <button
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                x-data
                                                @click="$dispatch('open-modal', {
                    action: 'accept',
                    applicationId: '{{ $application->id }}'
                }); open = false">
                                                Accept
                                            </button>
                                            <button
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                x-data
                                                @click="$dispatch('open-modal', {
                    action: 'reject',
                    applicationId: '{{ $application->id }}'
                }); open = false">
                                                Reject
                                            </button>
                                            @elseif($application->status === 'accepted')
                                            <button
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                x-data
                                                @click="$dispatch('open-modal', {
                    action: 'terminate',
                    applicationId: '{{ $application->id }}'
                }); open = false">
                                                Terminate
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ 
        open: false,
        action: '',
        applicationId: '',
        reason: '',
        title: '',
        message: ''
    }">
        <div
            x-init="
                window.addEventListener('open-modal', (event) => {
                    console.log('Modal event received:', event.detail);
                    open = true;
                    action = event.detail.action;
                    applicationId = event.detail.applicationId;
                    
                    // Set title and message based on action
                    if (action === 'accept') {
                        title = 'Accept Application';
                        message = 'Are you sure you want to accept this application?';
                    } else if (action === 'reject') {
                        title = 'Reject Application';
                        message = 'Are you sure you want to reject this application?';
                    } else if (action === 'terminate') {
                        title = 'Terminate Application';
                        message = 'Are you sure you want to terminate this application?';
                    }
                })
            "
            x-show="open"
            class="fixed inset-0 flex items-center justify-center z-50"
            style="display: none;">
            <div class="fixed inset-0 bg-black opacity-50"></div>

            <div class="relative bg-white rounded-lg p-6 max-w-md w-full">
                <h2 class="text-xl font-bold mb-4" x-text="title">Confirm Action</h2>
                <p x-text="message">Are you sure you want to proceed?</p>

                <div class="mt-4" x-show="action === 'reject' || action === 'terminate'">
                    <label class="block text-sm font-medium text-gray-700">Reason</label>
                    <textarea
                        x-model="reason"
                        class="mt-1 block w-full border rounded-md shadow-sm p-2"
                        rows="3"
                        placeholder="Please provide a reason...">
                    </textarea>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                        @click="open = false">
                        Cancel
                    </button>
                    <button
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                        @click="handleAction(action, applicationId, reason); open = false">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function handleAction(action, applicationId, reason = '') {
            const url = `/applications/${applicationId}/update`;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        action,
                        reason
                    }),
                });

                const data = await response.json();
                if (data.message) {
                    alert(data.message);
                }

                if (response.ok) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
</x-app-layout>