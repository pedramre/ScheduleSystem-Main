var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');

var redis = new Redis();

redis.psubscribe('*', (err, count) => {

});
console.log('ok');

redis.on('pmessage', function(subscribed, channel, data) {
    message = JSON.parse(data)
    console.log(channel + ':' + message.event)
    io.emit(channel + ':' + message.event, message.data)
});

server.listen(3000);
