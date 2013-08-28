
/*
 * This example shows how results from a query can be received in an iterative
 * mode and illustrated in a table. 
 */
var basex = require('./node_modules/basex/index');
var fs = require('fs');
var http = require('http');
basex.debug_mode = false;

function loadfile(src) {
    return fs.readFileSync(__dirname + "/" + src, 'utf-8');
}
;

function print(err, reply) {
    if (err) {
        console.log("Error: " + err);
    } else {
        //console.log(reply);
        var json = JSON.parse(reply.result);
        console.log(json);
    }
}

var session = new basex.Session("localhost", 1984, "admin", "admin");
var xq = "auteurs.xq";
var cmd = loadfile(xq);
var query = session.query(cmd);
query.execute(function(err, reply){console.log(JSON.parse(reply.result));});
query.close();
session.close();

