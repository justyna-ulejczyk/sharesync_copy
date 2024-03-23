const socket = io('/')

const myPeer  = new Peer()

myPeer.on('open', id =>{
    socket.emit('join-room', ROOM_ID, id)
})


const videoGrid = document.getElementById('video-grid')
const myVideo = document.createElement('video')
myVideo.muted = true

navigator.mediaDevices.getUserMedia({
    video:true,
    audio:true
}).then(stream => {
    socket.on('user-connected',userId =>{
        connectToNewUser(userId,stream)
        console.log('New User Connected: ' + userId)
    })
    console.log('test')
    myPeer.on('call', call => {
        call.answer(stream)
        const video = document.createElement('video')
        call.on('stream', userVideoStream => {
            console.log('test')
            addVideoStream(video, userVideoStream)
        })
    })
    addVideoStream(myVideo,stream)
})


function connectToNewUser(userId, stream){
    const call = myPeer.call(userId,stream)
    const video = document.createElement('video')
    call.on('stream', userVideoStream => {
        addVideoStream(video,userVideoStream)
    })
    call.on('close', () => {
        video.remove()
    })
}

function addVideoStream(video,stream){
    video.srcObject = stream 
    video.addEventListener('loadedmetadata', () =>{
        video.play()
    })
    videoGrid.append(video)
}