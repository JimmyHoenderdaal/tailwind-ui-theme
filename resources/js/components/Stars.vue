<template>
    <div v-if="stars" class="flex items-start">
        <div class="flex items-center">
            <svg v-for="star in stars" :class="classStar" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
            <svg v-for="star in 5 - stars" :class="classStarInactive" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            score: {
                type: Number,
                required: true
            },
            count: {
                type: Number,
                required: false
            },
            classStar: {
                type: String,
                required: false,
                default: 'size-5 fill-current text-tut-primary'
            },
            classStarInactive: {
                type: String,
                required: false,
                default: 'size-5 fill-current text-gray-300'
            },
        },
        computed: {
            stars() {
                return Math.round(this.score / 100 * 5)
            }
        }
    }
</script>
