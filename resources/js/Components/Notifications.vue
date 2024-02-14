<script setup>
</script>

<template>
    <v-alert v-if="$page.props?.notification" :color="$page.props?.notification?.type" class="my-4" @click.prevent="$page.props.notification=null">
        <v-alert-title> {{ $page.props?.notification.text }}</v-alert-title>
    </v-alert>
</template>
