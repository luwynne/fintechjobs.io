<template>
    <div class="modal-backdrop">
    <div class="modal-small-response">
      <header class="modal-header">
        <slot name="header">
          <h3>Your request</h3>
          <button type="button" class="btn-close" @click="close">
            x
          </button>
        </slot>
      </header>
      <section class="modal-body">
        <slot name="body">
            <h4>{{response}}</h4>
        </slot>
      </section>
      <footer class="modal-footer">
    </footer>
  </div>
</div>
</template>

<script>
export default {

    props:['response'],

    data(){
        return{

        }
    },

    methods:{
        close(){
            this.$emit('closeInviteRequest');
        }
    }

}
</script>

<style>
  .modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal-small-response{
    background: #FFFFFF;
    box-shadow: 2px 2px 20px 1px;
    display: flex;
    flex-direction: column;
    margin-left: 15%px;
    position: fixed;
    width: 30%;
    height: 30%;
    top: 10%;
    overflow-y: auto;
    /* border: 1px black solid; */
    border-radius: 10px;
    padding: 10px;
    margin-left: auto;
    margin-right: auto;
  }

  .modal-header,
  .modal-footer {
    padding: 15px;
    display: flex;
    border: none!important;
  }

  .modal-header {
    /* border-bottom: 1px solid #eeeeee; */
    color: #214761;
    justify-content: space-between;
  }

  .modal-footer {
    /* border-top: 1px solid #eeeeee; */
    justify-content: flex-end;
  }

  .modal-body {
    position: relative;
    padding: 20px 20px;
    position: relative;
    padding: 20px 10px;
    margin-top: 30px;
    margin-left: 7px;
  }

  .btn-close {
    border: none;
    font-size: 20px;
    padding: 18px;
    cursor: pointer;
    font-weight: bold;
    color: #214761;
    background: transparent;
  }

  .btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
  }


</style>

