/// transforms a composer name in yearformed - name

/// npm install lastfm

if (process.argv.length < 3) {
    console.error('error usage: ' + process.argv[1] + " <ambiguous name>");
    console.error('transforms an ambiguous name in mbid - yearformed - name');
    process.exit(1);
}

var LastFmNode = require('lastfm').LastFmNode;

var lastfm = new LastFmNode({
    api_key: '08f8c671daf92a739d7aac4c10fce690',
    secret: '7b588b67960b8f1f3ca4bd290e63123e'
});

//var name = "davidbowie";
//var ambiguous = "ludwigvanbeethoven"; //828955
var ambiguous = process.argv[2];

var mbid = '5441c29d-3602-4898-b1a1-b77fa23b8e50';

var yearRequest = lastfm.request("artist.getInfo", {
    artist: ambiguous,
//                mbid: '1f9df192-a621-4f54-8850-2c5373b7eac9',
    //    mbid : '5441c29d-3602-4898-b1a1-b77fa23b8e50',
    handlers: {
        success: function(data) {
            var artist = data.artist;
            var yearformed = artist.bio.yearformed;
            console.log(artist.mbid + ' ' + yearformed + ' ' + artist.name);
        },
        error: function(error) {
            console.log("Error: " + error.message);
        }
    }
});