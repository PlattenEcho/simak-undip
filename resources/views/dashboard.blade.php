@extends('templates.main')

@section('body')
    <section>
        <div>
            Dashboard
        </div>
        <form action="/logout" method="POST">
            <div class="m-auto">
                @csrf
                <button type="submit"
                    class="w-full mr-auto text-white bg-red-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Log Out
                </button>
            </div>
        </form>

    </section>
@endsection
