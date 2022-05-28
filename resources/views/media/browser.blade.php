<x-filament::page>
    <x-filament::card>
        @if (count($disks) > 1)
            <x-filament::card.heading>
                <div class="grid grid-cols-{{ count($disks) }}">
                    @foreach ($disks as $did => $disk)
                        <a
                        href="#"
                        wire:click="selectDisk({{ $did }})"
                        class="col-span-1 flex justify-center px-6 br-6" style="{{ $selectedDisk == $did ? "background-color: lightblue" : '' }}"
                        >
                            {{ $disk }}
                        </a>
                    @endforeach
                </div>
            </x-filament::card.heading>
        @endif
        <div wire:loading class="w-full">
            <div class="flex items-center justify-center w-full bg-gray-400 bg-opacity-50">
                <img src="https://paladins-draft.com/img/circle_loading.gif" width="64" height="64" class="m-auto mt-1/4">
            </div>
        </div>
        <div wire:loading.remove>
            @foreach ($currentFiles as $current)
            {{ $current->getFirstMedia('images') }}
            @endforeach
            {{ $currentFiles->links() }}
        </div>
    <hr />
    <form wire:submit.prevent="save">
        {{ $this->form }}
    </form>
    </x-filament::card>
</x-filament::page>
