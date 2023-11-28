@if (session()->has('message'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="bg-laravel fixed left-1/2 top-0 -translate-x-1/2 transform px-48 py-3 text-white">
        <p>
            {{ session()->get('message') }}
        </p>
    </div>
@endif
