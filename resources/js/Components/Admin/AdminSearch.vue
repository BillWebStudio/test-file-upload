<script setup>
import { computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage()

const props = defineProps({
    formUrl: String,
    searchInputs: Array
});

function frmDefaults() {
    let options = {};
    for (let item of props.searchInputs){
        let val = page.props[item.name] || '';

        if (val != ''){
            switch(item.name)
            {
                case "status":
                case "organization_id":
                case "subscription_plan":
                {
                    val = parseInt(val);
                    break;
                }
            }
        }

        options[item.name] = val;
    }

    return options;
};

const form = useForm(frmDefaults);

const submit = () => {
    form.get(props.formUrl, {});
};

const searchInputsFiltered =  computed(() => {
    let inps = props.searchInputs.filter(item =>(item.name != 'organization' || page.props.auth?.can['manage-organizations']));
    return inps;
})
</script>


<template>
    <v-row>
        <v-col cols="12">

            <v-form @submit.prevent="submit" class="admin-search my-4">

                <div>
                    <v-row>

                        <v-col v-for="inp in searchInputsFiltered" cols="6" md="2" lg="2">

                            <v-text-field v-if="inp.type == 'text'"
                                          v-model="form[inp.name]"
                                          :label="inp.label"
                                          hide-details
                                          variant="solo-filled"
                                          class="py-1"
                            ></v-text-field>

                            <v-select v-else-if="inp.type == 'country'"
                                      v-model="form[inp.name]"
                                      :label="inp.label"
                                      :items="$page.props.selectOptions.countries"
                                      clearable
                                      hide-details
                                      variant="solo-filled"
                                      class="py-1"
                            ></v-select>

                            <v-select v-else-if="inp.type == 'select'"
                                      v-model="form[inp.name]"
                                      :label="inp.label"
                                      :items="inp.options"
                                      clearable
                                      hide-details
                                      variant="solo-filled"
                                      class="py-1"
                            ></v-select>

                            <v-text-field v-else-if="inp.type == 'date'"
                                type="date"
                                v-model="form[inp.name]"
                                :label="inp.label"
                                hide-details
                                variant="solo-filled"
                                class="py-1"
                            ></v-text-field>

                            <v-text-field v-else
                                          v-model="form[inp.name]"
                                          :placeholder="inp.label"
                                          hide-details
                                          variant="solo-filled"
                                          class="py-1"
                            ></v-text-field>

                        </v-col>

                        <v-col class="text-no-wrap d-flex align-center">
                            <v-btn :disabled="form.processing" type="submit" class="mr-2" color="primary" size="x-large" :title="$t('Search')"><v-icon icon="mdi-magnify"></v-icon></v-btn>
                            <v-btn color="primary" variant="outlined" size="x-large" :to="formUrl" :title="$t('Clear')"><v-icon icon="mdi-close"></v-icon></v-btn>
                        </v-col>

                    </v-row>
                </div>
            </v-form>

        </v-col>
    </v-row>
</template>


<style scoped>

</style>
