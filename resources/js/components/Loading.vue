<template>
    <div
        class="loader w-[80px] md:w-[120px] aspect-square border-[12px] md:border-[16px] border-t-green-600 border-neutral-200"
    ></div>
</template>

<style scoped>
.loader {
    border-radius: 50%;
    -webkit-animation: spin 1s linear infinite; /* Safari */
    animation: spin 1s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
    }
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
