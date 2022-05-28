<x-filament::page>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-5">
        <div class="col-span-1">
            <x-filament::card>
                <x-filament::card.heading>
                    {{ __('Disks') }}
                </x-filament::card.heading>
                <ul>
                    @foreach ($disks as $did => $disk)
                        <li><a
                                href="#"
                                wire:click="selectDisk({{ $did }})"
                            >{{ $disk }}</a></li>
                    @endforeach
                    <ul>
            </x-filament::card>
        </div>
        <div class="col-span-4">
            <x-filament::card>
                <div wire:loading.class="hide">
                    @foreach ($currentFiles as $current)
                        {{ $current->disk . '-' . $current->id }}
                    @endforeach
                    <div wire:loading>
                        loading.
                    </div>
                    {{ $currentFiles->links() }}
                </div>
            </x-filament::card>

        </div>

    </div>

</x-filament::page>
