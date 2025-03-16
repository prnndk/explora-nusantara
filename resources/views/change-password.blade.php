<x-layouts.dashboard webTitle="Change Password">
    <div class="flex flex-row items-center gap-4">
        <x-heroicon-o-arrow-left-circle class="size-8" />
        <div>
            <h1 class="text-4xl font-bold">Change Password</h1>
            <h6>Change your password at any time to maintain your privacy.</h6>
        </div>
    </div>

    <div class="flex flex-col my-14 mx-10 gap-6">
        <x-input.password label="Current Password" name="current_password" :required="true" />
        <x-input.password label="New Password" name="new_password" :required="true" />
        <x-input.password label="Confirm New Password" name="confirm_new_password" :required="true" />
        <div class="flex flex-row justify-end mt-4 gap-4">
            <x-button type="outline-neutral" addClasses="px-8">Cancel</x-button>
            <x-button @click="$dispatch('open-modal','update-password')" type="primary"
                addClasses="px-8">Save</x-button>
        </div>
    </div>

    <x-modal name="update-password" title="Change Password?">
        <div class="flex flex-col gap-4">
            <h6>Are you sure you want to change your password?</h6>
            <div class="flex flex-row justify-end gap-4">
                <x-button type="outline-neutral" addClasses="px-8"
                    @click="$dispatch('close-modal','update-password' )">Cancel</x-button>
                <x-button type="warning" addClasses="px-8">Save</x-button>
            </div>
        </div>
    </x-modal>
</x-layouts.dashboard>
