@extends('doswal.navsidebar')

@section('content')
        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
                <p class="text-sm font-large text-gray-900 truncate dark:text-gray-300" role="none">
                    Welcome! {{ auth()->user()->username }}
                </p>
            </div>
        </div>

    </section>
@endsection
