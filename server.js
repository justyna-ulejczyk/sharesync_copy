const express = require('express')
const app = express()
const server = require('http').Server(app)
const io = require('socket.io')(server)
const v4 = 10
/* group id goes for v4 */


app.set('view engine', 'ejs')
app.use(express.static('public'))


app.get('/', (req,res) => {
    res.redirect(`/${v4}/`)
    console.log("redirected")
})

app.get('/:room',(req,res) => {
    res.render('room', {roomId: req.params.room })
    console.log("room set")
})


io.on('connection', (socket) =>{
    socket.on('join-room',(roomId,userId) =>{
        socket.join(roomId)
        socket.to(roomId).emit('user-connected', userId);
        console.log("connected to room :" + roomId + " with user " + userId)
    })
})

server.listen(3000)