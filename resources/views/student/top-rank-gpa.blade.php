<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students Top Rank GPA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table id="students-table" class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student ID</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Faculty</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Major</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">GPA</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Math Score</th>
                                    <th class="px-6 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Science Score</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($students as $index => $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->nomor_induk }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->faculty->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->major_study }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->gpa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->math_score }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $student->science_score }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#students-table').DataTable({
                responsive: true,
                processing: true,
                pageLength: 10,
                order: [[0, 'asc']],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)"
                },
                drawCallback: function() {
                    // Tambahkan kelas Tailwind ke elemen DataTables
                    $('.dataTables_length select').addClass('border-gray-300 rounded-md');
                    $('.dataTables_filter input').addClass('border-gray-300 rounded-md');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>