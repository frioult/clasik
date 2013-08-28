//--------------------------------------------------------------------------------
//-------------------------- Mini XQuery FrameWork -----------------------
//--------------------------------------------------------------------------------
// npm install basex socket.io express socket.io-client xml2json

var fs = require('fs');
var express = require('express');
var app = express();

//-------------=-------------------------------------------------------------------
//---- comportement du serveur web : servir le fichier serverHTML --------------
//--------------------------------------------------------------------------------
app.get('/*', function(req, res) {
    res.setHeader('Content-Type', 'text/html');
    console.log("requestied ", req.route.params[0]);
    var serverHTML = 'html/' + req.route.params[0] + '.html';

    fs.readFile(__dirname + '/' + serverHTML,
            function(err, data) {
                if (err) {
                    res.writeHead(500);
                    return res.end('Error loading ' + serverHTML);
                }
                res.end(data);
                console.log('page ' + serverHTML + ' envoyee !');
            });
});
//--------------------------------------------------------------------------------
/// si on ecoute sur le port 80, il faut lancer 'sudo node app.js' (port < 100) et stopper apache2
var port = 8080;
var io = require('socket.io').listen(app.listen(port), {log: false});
//, {log: false});

//--------------------------------------------------------------------------------
// traitement des donnees
var basex = require('./node_modules/basex/index');
var fs = require('fs');
var http = require('http');
basex.debug_mode = false;

//var d3 = require("d3");

//--------------------------------------------------------------------------------
function loadfile(src) {
    return fs.readFileSync(__dirname + "/" + src, 'utf-8');
}

//--------------------------------------------------------------------------------
function print(err, reply) {
    if (err) {
        console.log("Error: " + err);
    } else {
        //console.log(reply);
        var json = JSON.parse(reply.result);
        console.log(json);
    }
}

//----------------------------------------------------
//----------- traitement des connexions ---------------
//----------------------------------------------------
var parser = require('xml2json');
io.sockets.on('connection', function(socket) {
    //console.log(socket);
    // message 
    socket.on('require', function(data) {
        console.log('require', data);

        var session = new basex.Session("localhost", 1984, "admin", "admin");
        var fileName = 'xq/' + data.file + '.xq';
        console.log('fileName', fileName);
        var cmd = loadfile(fileName);
        var query = session.query(cmd);
        query.execute(function(err, reply) {
            var json = parser.toJson(reply.result);
            console.log("sending message " + data.message, json);
            socket.emit(data.message, json);
        });
        query.close();
        session.close();
    });
});

console.log('info', 'Server is running on port ' + port);