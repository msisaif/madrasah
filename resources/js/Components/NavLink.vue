<template>
    <Link
        :href="href"
        class="py-1.5 text-sm font-medium text-gray-500 md:text-lg"
        :class="classes"
    >
        <slot />
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    props: ["href", "active"],

    computed: {
        classes() {
            return this.active ? "text-sky-600" : "text-gray-500";
        },
    },
};
</script>
