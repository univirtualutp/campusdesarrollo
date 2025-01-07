M.block_rumbletalk_chat = {
    Y : null,
    transaction : [],
    init : function(Y){
        alert('RumbleTalk module initialisation');
        this.Y = Y;
    },

    hello : function(Y){
        alert('Hello, Welcome at RumbleTalk Group Chat');
        this.Y = Y;
    },

    create_account : function(Y, email, password){
        alert('Hello, Email: ' + email + ' Password: ' + password);
        this.Y = Y;
    }
}
