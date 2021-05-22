<template>
    <div class="col-md text-center">
        <p class="mensaje-error">
            <slot></slot>
        </p>
    </div>
</template>

<script>
    export default {
        name: 'MensajeValidacion'
    }
</script>

<style scoped>
  .mensaje-error{
    font-weight: bold;
    color: rgba(231, 76, 60, 0.8);
    margin:0;
  }
</style>