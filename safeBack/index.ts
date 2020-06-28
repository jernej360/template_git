import express from "express";
import * as socketio from "socket.io";
import * as path from "path";
import cors from 'cors';

const app = express();
app.use(cors());
app.set("port", process.env.PORT || 8000);

let http = require("http").Server(app);
let io = require("socket.io")(http);


const server = http.listen(8000, function() {
  console.log("listening on *:8000");

  io.on("connection", function(socket: any) {
    console.log("a user connected");

    socket.on('disconnect', function(socket: any){
        console.log('user disconnected');  
    });

    socket.on('my message', function(msg: string){
        console.log('message: ' + msg);
    }); 


    socket.on('code', function(msg: string){
        console.log('someones code: ' + msg);
        if(msg==="2324"){
            socket.emit('ans',"ctf{ave_moi_Brutus!!}");
        }else{
            socket.emit('ans',"false");
        }
    }); 

});

});