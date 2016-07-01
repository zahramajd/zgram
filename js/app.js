var app = new Vue({
    el: '#app',
    data: {
        current: null,
        peers: null,
        dialogs: [],
        profile: null,
        draft: '',
        searchUser: '',
        searchUserResult: null,
        selectedUser: null,
        cgName: '',
        cgUsername: '',
        searchHashtag: '',
        searchHashtagResult: null,
        gpName: '',
        gpUsername: '',
    },
    methods: {

        refresh: function () {

            // Reload chats list
            $.ajax({url: 'api/peers.php', dataType: "json"})
                .success(function (r) {
                    app.peers = r;
                });


            if (app.profile)
                $.ajax({url: 'api/messages.php?id=' + app.profile._id, dataType: "json"}).success(
                    function (m) {
                        app.dialogs = m;
                    }
                )


        },

        openChat: function (id) {
            $.ajax({url: 'api/profile.php?id=' + id, dataType: "json"}).success(function (t) {
                console.log('chat oppened');
                app.profile = t;
                app.profile.is_reported = app.profile.report.indexOf(app.current._id) >= 0;
                app.is_friend=app.current.peers.indexOf(app.profile._id)>=0;
            });
        },

        sendMessage: function () {

            // Send Message
            $.ajax({
                url: 'api/send.php?to=' + app.profile._id + '&text=' + encodeURIComponent(app.draft),
                success: function (m) {
                    console.log('Sent');
                    console.log(m)
                }
            });

            // Clear Input
            app.draft = "";

        },

        reopenChat: function () {
            var id=app.profile._id+"";
            app.profile=null;
            app.openChat(id);
        },

        updateProfile: function () {
            console.log("Updating profile ...");
            $.ajax({
                url: 'api/updateProfile.php',
                type: "POST",
                data: {'data': app.current}
            }).success(
                function (r) {
                    console.log("Profile Updated!")
                    console.log(r)
                }
            )
        },

        doSearchUser: function () {

            $.ajax({
                url: 'api/searchUser.php?&q=' + app.searchUser,
                dataType: 'json',
                success: function (q) {
                    app.searchUserResult = q;
                }
            });


        },

        selectUser: function (username, _id) {
            console.log(username + ' ' + _id);
            app.selectedUser = {
                username: username,
                _id: _id,
            }
        },

        addFriend: function (_id) {
            $.ajax({url: 'api/addFriend.php?id=' + _id}).success(function (t) {
                console.log('Friend Added!');
                app.reopenChat();
            });

        },

        report: function (_id) {

            console.log(_id);
            $.ajax({url: 'api/report.php?id=' + _id}).success(function (t) {
                app.profile.is_reported = true;
                app.refresh();
            });
        },

        unfriend: function (_id) {
            console.log("fefef");
            $.ajax({url: 'api/unfriend.php?id=' + _id}).success(function (t) {
                console.log('Unfriend');
                app.reopenChat();
            });

        },

        createChannel: function () {
            $.ajax({
                url: 'api/createChannel.php?name=' + app.cgName + '&username=' + app.cgUsername,
                success: function (m) {
                    app.refresh();

                }
            });
            app.cgName = "";
            app.cgUsername = "";
        },

        createGroup: function () {
            $.ajax({
                url: 'api/createGroup.php?name=' + app.gpName + '&username=' + app.gpUsername,
                success: function (m) {
                    app.refresh();
                }
            });
            app.gpName = "";
            app.gpUsername = "";

        },

        doSearchHashtag: function () {

            if (app.searchHashtag == "")
                return;

            $.ajax({
                url: 'api/searchHashtag.php?q=' + app.searchHashtag,
                dataType: 'json',
                success: function (q) {
                    app.searchHashtagResult = q;
                }
            });

        },

        doLeave: function (_id) {

            // Send Message
            $.ajax({
                url: 'api/send.php?to=' + _id + '&text=' + app.current.username + ' left the group',
                success: function (m) {
                    app.refresh();
                }
            });

            // leave
            $.ajax({url: 'api/unfriend.php?id=' + _id}).success(function (t) {
                app.reopenChat();
            });

        }


    }
});

setInterval(app.refresh, 500);
app.refresh();
