<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
               <div class="p-6 text-gray-900">
                    {{-- <b>Users Table</b><br> --}}
                 <a href="{{ route('file')}}"><button type="button" class="btn btn-primary mb-4 float-right">File Upload</button></a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Sr .</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Last Update At</th>
                                <th scope="col">Registered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($userData as $users)
                            <tr>
                                <th scope="row">{{$i}}</th>
                                <td>{{$users->name}}</td>
                                <td>{{$users->email}}</td>
                                <td>{{$users->updated_at}}</td>
                                <td>{{$users->created_at}}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
