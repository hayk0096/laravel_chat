<template>
    <div class="container">
        <div class="row">
            <div class="title col-lg-12">
                <h3>Private room chat</h3>
                <span>After typing a message just press enter</span>
            </div>
            <div class="col-md-12">
                <div class="col-sm-8 col-xs-8">
                    <textarea name="" class="form-control" cols="30" readonly rows="10">{{ messages.join('\n')}}</textarea>
                    <hr>
                    <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage" @keydown="actionUser">
                    <span v-if="isActive">{{ isActive.name }} typing a message...</span>
                </div>
                <div class="col-sm-4 col-xs-4">
                    <ul>
                        <li v-for="user in activeUsers">{{ user }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['room', 'user'],
        data(){
            return {
                messages: [],
                textMessage: '',
                isActive: false,
                typingTimer: false,
                activeUsers: []
            }
        },
        computed: {
            channel() {
                return window.Echo.join(`room.${this.room.id}`)
            }
        },
        mounted() {
            this.channel
                .here((users) => {
                    this.activeUsers = users;
                })
                .joining((user) => {
                    this.activeUsers.push(user);
                })
                .leaving((user) => {
                    this.activeUsers.splice(this.activeUsers.indexOf(user), 1);
                })
                .listen('PrivateChat', ({data}) => {
                    this.messages.push(data.user + ': ' + data.body);
                    this.isActive = false;
                })
                .listenForWhisper('typing', (e) => {
                    this.isActive = e;

                    if (this.typingTimer) clearTimeout(this.typingTimer);

                    this.typingTimer = setTimeout( () => {
                        this.isActive = false;
                    }, 2000);
                });
        },
        methods: {
            sendMessage(){
                axios.post('/room-messages', { body: this.textMessage, room_id: this.room.id, user: this.user.name });

                this.messages.push(`I: ${this.textMessage}`);
                this.textMessage = '';
            },
            actionUser(){
                this.channel
                    .whisper('typing', {
                        name: this.user.name
                    })
            }
        }
    }
</script>
