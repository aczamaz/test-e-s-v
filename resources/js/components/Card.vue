<template>
  <a
    class="card"
    :style="{ backgroundImage: `url(${card.media['0'].original_url})` ,backgroundSize: 'contain' }"
  >
        <div class="card__name">
            {{card.name}}
        </div>
  </a>
</template>

<script>
    export default {
        name: 'Card',
        props: {
            card:String
        },
        mounted() {
            console.log('Component Card.');
        }
    }
</script>
<style>
    .card{
        width: 200px;
        height: 200px;
        color:white;
        display: flex;
        justify-content: flex-end;
        text-decoration: none;
        padding: 10px;
    }
    .card:hover
    {
        color:white;
    }
    .card + .card
    {
        margin-left: 5px;
    }
    .card__name
    {
        font-size:20px;
    }
    .hover-block
    {
        height: 100%;
        opacity:0.5;
        padding:5px;
        color:white;
    }
</style>
