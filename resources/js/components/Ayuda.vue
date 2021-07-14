<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Ayuda</li>
    </ol>
    <div class="container-fluid ayuda">
      <div class="card">
        <div class="card-header">
          <i class="icon-book-open"></i> Ayuda
        </div>
        <div class="card-body pdf-viewer">
          <!-- card-body pdf-viewer -->
            <iframe :src="'pdf-viewer/web/viewer.html?file='+urlPDF" frameborder="0" width="100%" height="100%"></iframe>
          <!-- card-body pdf-viewer -->
        </div>
      </div>
    </div>
</main>
</template>

<script>
export default {
    data() {
        return {
            urlPDF : '/../storage/ayuda/manual/compressed.tracemonkey-pldi-09.pdf'
        }
    },
    methods : {

    },
    mounted(){

    }
}
</script>

<style scoped>
    iframe{
        display: block;
        background: #000;
        border: none;
    }

    @media only screen and (min-width: 412px){
        .ayuda > .card{
            height: 1155px;
        }
    }

    @media only screen and (max-width: 411px){
        .ayuda > .card{
            height: 600px;
        }
    }
    
    .pdf-viewer{
        padding: 0;
    }
</style>