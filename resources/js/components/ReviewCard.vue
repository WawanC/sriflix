<template>
    <article
        :class="`flex flex-col gap-4 text-xl p-4 border border-black rounded shadow
        md:flex-row md:items-center`"
    >
        <div class="flex flex-col items-center">
            <StarIcon id="star" :value="1" class="w-8 md:w-16 aspect-square" />
            <span class="font-semibold">4</span>
        </div>
        <div class="flex flex-col justify-center gap-2 w-full">
            <p class="italic text-justify">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris
                ultrices gravida felis, ac euismod elit sodales eu. Maecenas
                vehicula nunc ac mi rutrum, quis auctor augue tincidunt. Fusce
                ultricies dolor non risus efficitur posuere. Morbi fringilla
                velit pharetra euismod laoreet. Integer dapibus dui eget nulla
                pulvinar ullamcorper.
            </p>
            <span class="text-lg font-semibold self-end">User123</span>
        </div>
    </article>
</template>
<script lang="ts" setup>
import StarIcon from "../icons/StarIcon.vue";
</script>
