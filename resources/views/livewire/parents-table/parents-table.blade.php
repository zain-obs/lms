<div class="flex flex-col gap-y-5 bg-white p-3 rounded-md overflow-y-auto">
        <table>
            <thead>
                <tr class="text-gray-700">
                    <th>Sr#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="text-center">
                        <td class="p-2">{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        {{ $users->links() }}
</div>
