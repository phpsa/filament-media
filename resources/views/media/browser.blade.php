<x-filament::page>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
        <div class="col-span-1">
            <x-filament::card>
                @foreach ($disks as $disk)
                    {{ $disk }}
                @endforeach
            </x-filament::card>
        </div>
        <div class="col-span-4">
            <x-filament::card>

            </x-filament::card>

        </div>

    </div>


</x-filament::page>
