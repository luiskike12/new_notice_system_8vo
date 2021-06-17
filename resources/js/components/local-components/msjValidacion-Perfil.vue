<template>
    <div class="col-md-12">
      <div class="row">
        <div class="col-md-12 text-center">
            <p class="mensaje-error">
              <slot></slot>
            </p>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  name: 'MensajeValidacion'
}
/*export default {
  name: 'MensajeValidacion',
  props: {
    mensaje : {
      type : String,
      default: ''
    }
  }
}*/
</script>
  
<style scoped>
  .mensaje-error{
    font-weight: bold;
    color: rgba(231, 76, 60, 0.8);
    margin:0;
  }
</style>