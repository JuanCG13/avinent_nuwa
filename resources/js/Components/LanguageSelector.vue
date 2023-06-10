<template>
    <select v-model="$i18n.locale">
        <option v-for="language in languages" :key="language.id" :value="language.id">
            {{language.name}}
        </option>
    </select>
</template>

<script>
    import { useI18n } from "vue-i18n";
    export default {
    setup() {
        const { t } = useI18n({});
        return { t };
    },
}
</script>