<ul class="chat">
    <li class="left clearfix" v-for="dialog in dialogs">

        <span v-bind:class="['chat-img','pull-'+(dialog.is_me?'left':'right'),'title']">
             <img v-bind:src="(dialog.is_me?current:profile).avatar" alt="User Avatar" class="img-circle"/>
        </span>

        <div class="chat-body clearfix">
            <div class="header">
                <strong class="primary-font">{{(dialog.is_me?current:profile).name}}</strong>
                <small class="pull-right text-muted">
                    <span class="glyphicon glyphicon-time"></span> -
                </small>
            </div>
            <p>{{dialog.text}}</p>
        </div>
    </li>
</ul>