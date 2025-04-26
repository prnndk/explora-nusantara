<x-button type="primary" x-on:click="$dispatch('open-modal', 'create')">
    <x-heroicon-o-plus class="w-5 h-5" />
    Create New Meeting
</x-button>


<x-plain-modal name="create" :show="false">
    <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
            Create new Meeting
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Create meetings to suit your needs!
        </p>

        <form wire:submit.prevent="handleCreation">

            <div class="flex flex-col gap-2 space-y-1 mt-5">
                <x-input.text label="Agenda" name="agenda" :transparent="false" wire:model="agenda" :required="true" />
                <x-input.text label="Duration" name="duration" :transparent="false" wire:model="duration"
                    :required="true" />
                <x-input.text label="Password" name="password" :transparent="false" wire:model="password"
                    :required="true" />
                <x-input.text label="Start Time" name="start_time" type="datetime-local" :transparent="false"
                    wire:model="start_time" :required="true" />
                <x-input.text label="End Time" name="end_time" type="datetime-local" :transparent="false"
                    wire:model="end_time" :required="true" />
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button @click="$dispatch('close-modal', 'create')" button="button"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>
                <x-button type="primary">
                    Submit
                </x-button>
            </div>
        </form>
    </div>
</x-plain-modal>
