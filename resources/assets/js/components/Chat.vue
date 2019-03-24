<template>
    <div class="container">
        <div class="row">
            <div class="title col-lg-12">
                <h3>Public chat </h3>
                <span>After typing a message just press enter</span>
            </div>
            <div class="col-sm-12">
                <textarea name="" class="form-control" cols="30" readonly rows="10">{{messages.join('\n')}}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                messages: [],
                textMessage: ''
            }
        },
        mounted() {
            window.Echo.channel('chat')
                .listen('Message', ({message}) => {
                    this.messages.push(message.body);
                });
            console.log('Component mounted.')
        },
        methods: {
            sendMessage(){
                axios.post('/messages', { body: this.textMessage });

                this.messages.push(this.textMessage);
                this.textMessage = '';
            }
        }
    }
</script>
