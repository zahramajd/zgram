<div class="text-field">
    <div class="form-group">
        <input class="form-control input-lg" type="text" placeholder="Message..." autofocus v-model="draft" @keyup.enter="sendMessage">
    </div>
    <button class="btn btn-info btn-lg" @click="sendMessage">Send</button>
</div>