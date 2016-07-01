<div class="last-contacts" v-if="peers!=null">
    <div  v-for="peer in peers" @click="openChat(peer._id)"
         v-bind:class="['contact', (profile && peer._id==profile._id) ? 'selected' : '']">
        <div class="contact-title">
            <i class="glyphicon glyphicon-flag" v-if="current.peers.indexOf(peer._id)<0"></i>

            {{peer.username}}
            <i class="glyphicon glyphicon-flag" v-if="current.peers.indexOf(peer._id)<0"></i>

        </div>
        <img v-bind:src="peer.avatar" class="img-circle">
    </div>
</div>
<div v-else="">
    Loading
</div>