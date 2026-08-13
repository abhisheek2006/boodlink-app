<div class="users-table-card">

    <div class="table-scroll">

        <table class="users-table">

            <thead>

                <tr>

                    <th>
                        Name
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Role
                    </th>

                    <th>
                        Blood Group
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Registered
                    </th>

                    <th>
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($users as $user)

                    @php

                        $roleClass = match($user->role) {

                            'Admin' => 'role-admin',

                            'Donor' => 'role-donor',

                            'Patient' => 'role-patient',

                            default => 'role-default'

                        };


                        $statusClass = match($user->status) {

                            'Active' => 'status-active',

                            'Inactive' => 'status-inactive',

                            'Suspended' => 'status-suspended',

                            'Banned' => 'status-banned',

                            default => 'status-inactive'

                        };

                    @endphp


                    <tr>

                        {{-- USER --}}

                        <td>

                            <div class="user-cell">

                                @if($user->profile_photo)

                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_photo) }}"
                                        class="user-avatar"
                                        alt="{{ $user->name }}"
                                    >

                                @else

                                    <div class="default-avatar">

                                        <i class="bi bi-person-fill"></i>

                                    </div>

                                @endif


                                <div>

                                    <div class="user-name">
                                        {{ $user->name }}
                                    </div>

                                </div>

                            </div>

                        </td>


                        {{-- EMAIL --}}

                        <td>

                            <span class="user-email">
                                {{ $user->email }}
                            </span>

                        </td>


                        {{-- ROLE --}}

                        <td>

                            <span class="role-badge {{ $roleClass }}">
                                {{ $user->role }}
                            </span>

                        </td>


                        {{-- BLOOD GROUP --}}

                        <td>

                            @if($user->donor && $user->donor->bloodGroup)

                                <span class="blood-group">
                                    {{ $user->donor->bloodGroup->name }}
                                </span>

                            @elseif($user->patient && $user->patient->requiredBloodGroup)

                                <span class="blood-group">
                                    {{ $user->patient->requiredBloodGroup->name }}
                                </span>

                            @else

                                <span class="empty-value">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- STATUS --}}

                        <td>

                            <span class="status-badge {{ $statusClass }}">
                                {{ $user->status }}
                            </span>

                        </td>


                        {{-- REGISTERED --}}

                        <td>

                            {{ optional($user->created_at)->format('d M Y') }}

                        </td>


                        {{-- ACTION --}}

                        <td class="text-end">

                            <a
                                href="{{ route('admin.users.show', $user) }}"
                                class="view-button"
                                title="View User"
                            >
                                <i class="bi bi-eye"></i>
                            </a>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-5"
                        >

                            <div class="text-muted">

                                <i
                                    class="bi bi-people fs-1 d-block mb-2"
                                ></i>

                                No users found.

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- =================================================
         FOOTER / CUSTOM PAGINATION
         ================================================= --}}

    @if($users->total() > 0)

        <div class="users-footer">

            <div class="users-count">

                Showing
                <strong>{{ $users->firstItem() }}</strong>
                to
                <strong>{{ $users->lastItem() }}</strong>
                of
                <strong>{{ $users->total() }}</strong>
                users

            </div>


            <div class="users-pagination">

                @if ($users->hasPages())

                    <div class="custom-pagination">

                        {{-- Previous --}}

                        @if ($users->onFirstPage())

                            <span class="pagination-arrow disabled">
                                <i class="bi bi-chevron-left"></i>
                            </span>

                        @else

                            <a
                                href="{{ $users->previousPageUrl() }}"
                                class="pagination-arrow"
                                aria-label="Previous page"
                            >
                                <i class="bi bi-chevron-left"></i>
                            </a>

                        @endif


                        {{-- Page Numbers --}}

                        @foreach ($users->getUrlRange(
                            max(1, $users->currentPage() - 2),
                            min($users->lastPage(), $users->currentPage() + 2)
                        ) as $page => $url)

                            @if ($page == $users->currentPage())

                                <span class="pagination-number active">
                                    {{ $page }}
                                </span>

                            @else

                                <a
                                    href="{{ $url }}"
                                    class="pagination-number"
                                >
                                    {{ $page }}
                                </a>

                            @endif

                        @endforeach


                        {{-- Next --}}

                        @if ($users->hasMorePages())

                            <a
                                href="{{ $users->nextPageUrl() }}"
                                class="pagination-arrow"
                                aria-label="Next page"
                            >
                                <i class="bi bi-chevron-right"></i>
                            </a>

                        @else

                            <span class="pagination-arrow disabled">
                                <i class="bi bi-chevron-right"></i>
                            </span>

                        @endif

                    </div>

                @endif

            </div>

        </div>

    @endif

</div>
