<template>
    <div>
        <div id="page-wrapper">
            <div id="page-inner">

                <div v-if="this.loading == true" id="over">
                    <img :src="'/fintechjobs.io/public/admin/img/loading.gif'" width="100px">
                </div>

                <div v-else class="row">
                    <div class="col-lg-12">
                        <h2>Billing</h2>
                        <p>My payments</p>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <table v-if="payments.length > 0" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Payment date</th>
                                    <th>Ammount</th>
                                    <th>Plan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="payment in payments" :key="payment.id" :payment="payment">
                                    <td>{{moment(payment.created_at).format('MMMM Do YYYY')}}</td>
                                    <td>{{payment.amount}}</td>
                                    <td>
                                        {{payment.plan}}
                                        <img class="hidden loading-image" :id="'loading-'+payment.id" :src="'/fintechjobs.io/public/admin/img/loading.gif'" alt="Loading" width="18px">
                                        <span><i @click="downloadPayment(payment.id, payment.plan)" class="fa fa-download float-right"></i></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h4 v-else>No payments at the moment!</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    export default {

        data(){

            return {
                loading: false,
                payments: [],
                payment: {id:'', amount:'', expire_date:'', created_at:''},
            }

        },

        methods:{

            moment,

            getPayments(){
                window.axios.get('http://localhost:8888/fintechjobs.io/public/api/billing').then( response => {
                    this.payments = response.data
                }).catch(e => {
                    console.log(e);
                })
            },

            downloadPayment(payment_id, payment_name){
                var loading_element = document.getElementById('loading-'+payment_id);
                loading_element.classList.remove('hidden');
                axios({
                    url: 'http://localhost:8888/fintechjobs.io/public/api/billing/'+payment_id+'/download',
                    method: 'GET',
                    responseType: 'blob', // important
                }).then((response) => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', moment()+payment_name+'.pdf');
                    document.body.appendChild(link);
                    link.click();
                    loading_element.classList.add('hidden');
                });
            }

        },

        mounted(){
            this.loading = true;
            this.getPayments();
            setTimeout(() => {
                this.loading = false;
            }, 400);
        },


    }
</script>

<style scoped>

.fa-download{
    font-size: 17px;
    padding-right: 15px;
}

.fa-download:hover{
    cursor: pointer;
}

.float-right{
    float: right;
}

.hidden{
    display: none!important;
}

.loading-image{
    position: absolute;
    margin-left: 2px;
}

</style>
