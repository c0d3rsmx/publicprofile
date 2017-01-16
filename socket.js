/**
 * Created by antoniobg on 1/3/17.
 */

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
var port = 3000;
var rm = '';



// Post handler.
io.on('connection', function (socket) {
    console.info('New client connected, id=' + socket.id);

//    Get the room name.
    socket.on('channel', function (room) {
        rm = room;
    //  Redis channel subscription.
        redis.subscribe(room, function (err, count) {
            console.log('redis: ' + room);
        });
        // console.log('io: ' + room);
    });

    // Close connection
    socket.on('disconnect', function(){
        console.log('Client disconnected, id='+ socket.id);
        socket.leave(this.rm);
    });

});


// Redis messages handler.
// Need server side message handlder implementation (Event).
redis.on('message', function (channel, data) {
    console.log('New Post Handler: ' + data);
    try {
        d = JSON.parse(data);
        io.emit(channel + ':' + d.event, null);
    }catch (err){
        console.log(err);
    }
});


// Server port listener.
http.listen(port, function () {
    console.log('Listening port: '+ port)
});