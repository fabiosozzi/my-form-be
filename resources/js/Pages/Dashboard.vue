<script setup>
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue';
import ContactsTable from '@/Components/ContactsTable.vue';

const props = defineProps({
    contacts: {
        type: Object,
        required: true,
    },
    canUpdate: {
        type: Boolean,
        required: true,
    },
    canDelete: {
        type: Boolean,
        required: true,
    },
    sort_field: {
        type: String,
        required: false,
    },
    sort_order: {
        type: String,
        required: false,
    }
})

function reloadContacts() {
    router.reload({ only: ['contacts'] })
}

reloadContacts()

</script>

<template>
    <AppLayout title="Elenco contatti">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Elenco contatti
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <template v-if="contacts !== undefined">
                    <ContactsTable @reload-data="reloadContacts" 
                        :contacts="contacts.data" 
                        :meta="contacts.meta" 
                        :canUpdate="canUpdate" 
                        :canDelete="canDelete"
                        :sortField="sort_field"
                        :sortOrder="sort_order"
                    />
                </template>
            </div>
        </div>
    </AppLayout>
</template>
