
<html>
  <head>
    <script src="https://cdn.jsdelivr.net/npm/comfy.js/dist/comfy.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Bangers' rel='stylesheet'>
  </head>
  <style>
    body {
      margin:0px;
    }
    #check {
      font-family: 'Bangers';
      font-size: 3em;
      word-wrap: none;
      visibility: hidden;
      top:0px;
      position:absolute;
      z-index: 10;
      text-align: center;
      width:100%;
      -webkit-text-stroke: 1px black;
        color: white;
        text-shadow:
        3px 3px 0 #000,
        -1px -1px 0 #000,  
        1px -1px 0 #000,
        -1px 1px 0 #000,
        1px 1px 0 #000;
        
    }
    #slugInfo {
      font-family: 'Bangers';
      font-size: 3em;
      word-wrap: none;
      visibility: hidden;
      top:0px;
      position:absolute;
      z-index: 10;
      text-align: center;
      width:100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 700px;
      -webkit-text-stroke: 1px black;
        color: white;
        text-shadow:
        3px 3px 0 #000,
        -1px -1px 0 #000,  
        1px -1px 0 #000,
        -1px 1px 0 #000,
        1px 1px 0 #000;
    }
    #slugInfoTwo {
      font-family: 'Bangers';
      font-size: 3em;
      word-wrap: none;
      visibility: hidden;
      bottom:0px;
      position:absolute;
      z-index: 10;
      text-align: center;
      width:100%;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      max-width: 700px;
      -webkit-text-stroke: 1px black;
        color: white;
        text-shadow:
        3px 3px 0 #000,
        -1px -1px 0 #000,  
        1px -1px 0 #000,
        -1px 1px 0 #000,
        1px 1px 0 #000;
    }

    #video {
      width:100%;
      height:100%;
      top:0px;
      position: absolute;
    }
	#streamerName {
		color: #990099;
	}
  </style>
  <body><div id="slugInfo"></div><div id="check">Check out <span id="streamer">streamer</span></div><div id="player">
    <video id="video" width="100%" height="100%" autoplay >
      <source src="" type="video/mp4">
      Your browser does not support the video tag.
    </video><div id="slugInfoTwo"></div>
    </div>
    <script type="text/javascript">
    
    var video = document.getElementById('video');
    var container = document.getElementById('video');
    var check = document.getElementById('check');
    var slogInfo = document.getElementById('slugInfo');
    var slogInfoTwo = document.getElementById('slugInfoTwo');
    var streamer = document.getElementById('streamer');
    var clips = [];
    var names = [];
    var slugClip;
    var slugId = [];
    var slugViewCount = [];
    var slugCreator = [];
    var slugDate = [];
    var slugTitle = [];
    var commandType = [];
    var isVideoPlaying;
    var mp4Res;
  	var listenBotSo = true;
    var listenBotSlug = true;

    container.style.visibility = 'hidden';
      ComfyJS.onCommand = ( user, command, message, flags, extra ) => {


         if(command === "resetso" && flags.broadcaster || command === "resetso" && flags.mod){
               location.reload();
              }

        if( flags.broadcaster && command == "so" || flags.mod && command == "so" || flags.broadcaster && command == "soclip" || flags.mod && command == "soclip" ) {
          console.log("So Command Triggered");
          if(listenBotSo) {
              function reqListener () {
                mp4Res = this.responseText;
                console.log(mp4Res);
                  if(mp4Res.length > 5) {
                    clips.push(this.responseText);
                    names.push(message);
                    commandType.push("clip");
                    console.log("Clip Found");
                  } else {
                    console.log("No Clips Found");
                  }
              }

            var oReq = new XMLHttpRequest();
            oReq.addEventListener("load", reqListener);
            oReq.open("GET", "../clipsapi2.php?channel="+message);
            oReq.send();
            }
		}
    
      if( flags.broadcaster && command == "soreset" || flags.mod && command == "soreset" ) {
         console.log("Reset Command Sent");
         clips = [];
         names = [];
         slugId = [];
         slugViewCount = [];
         slugCreator = [];
         slugDate = [];
         slugTitle = [];
         commandType = [];
         video.setAttribute('src', '');
         isVideoPlaying = false;
         container.style.visibility = 'hidden';
         check.style.visibility = 'hidden';
         slugInfo.style.visibility = 'hidden';
         slugInfoTwo.style.visibility = 'hidden';
          }

      if( flags.broadcaster && command == "soclipsoff" || flags.mod && command == "soclipsoff" ) {
        console.log("Turning off Clips");
	    	listenBotSo = false;
        }

		  if( flags.broadcaster && command == "soclipson" || flags.mod && command == "soclipson" ) {
        console.log("Turning on Clips");
	    	listenBotSo = true;
        }

      if( flags.broadcaster && command == "soslugsoff" || flags.mod && command == "soslugsoff" ) {
        console.log("Turning off Slug Clips");
	    	listenBotSlug = false;
        }
		if( flags.broadcaster && command == "soslugson" || flags.mod && command == "soslugson" ) {
        console.log("Turning on Slug Clips");
	    	listenBotSlug = true;
        }

    if( flags.broadcaster && command == "playslug" || flags.mod && command == "playslug" ) {
          console.log("Slug Command Triggered");
          if(listenBotSlug) {
            function reqListener () {
               slugClip = JSON.parse(this.responseText);
                if(this.responseText.length > 5) {
                   commandType.push("slug");
                   console.log("Found Clip");
                   clips.push(slugClip[0].mp4)
                   names.push(slugClip[0].broadcaster_name);
                   slugCreator.push(slugClip[0].creator_name) 
                   slugViewCount.push(slugClip[0].view_count)
                   slugTitle.push(slugClip[0].title)
                   slugDate.push(slugClip[0].created_at)
                } else {
                  console.log("No Clip Found");
                  }
          }
        }

        var oReq = new XMLHttpRequest();
        oReq.addEventListener("load", reqListener);
        if(message.includes("clip/")) {
          console.log("true /");
          message = message.split("clip/");
          message = message[1];
        }
        if(message.includes("?")){
          console.log("tr ?");
          message = message.split("?");
          message = message[0];
        }
		        if(message.includes("clips.twitch.tv")){
          console.log("clips.twitch");
          message = message.split(".tv/");
          message = message[1];
        }
        oReq.open("GET", "../clipgrab.php?slug="+message);
        oReq.send();
        }
      }

      ComfyJS.onChat = ( user, message, flags, self, extra ) => {
      console.log( user, message, extra );

      // Reward Section
      if(flags.customReward && extra.customRewardId === "NOTINUSE"){
                  console.log("So Reward Triggered");
                        function reqListener () {
                mp4Res = this.responseText;
                console.log(mp4Res);
                  if(mp4Res.length > 5) {
                    clips.push(this.responseText);
                    names.push(message);
                    commandType.push("clip");
                    console.log("Clip Found");
                  } else {
                    console.log("No Clips Found");
                  }
              }

            var oReq = new XMLHttpRequest();
            oReq.addEventListener("load", reqListener);
            oReq.open("GET", "../clipsapi.php?channel="+message);
            oReq.send();
            }

            if(flags.customReward && extra.customRewardId === "NOTINUSE"){
              console.log("Slug Reward Triggered");
              function reqListener () {
               slugClip = JSON.parse(this.responseText);
                if(this.responseText.length > 5) {
                   commandType.push("slug");
                   console.log("Found Clip");
                   clips.push(slugClip[0].mp4)
                   names.push(slugClip[0].broadcaster_name);
                   slugCreator.push(slugClip[0].creator_name) 
                   slugViewCount.push(slugClip[0].view_count)
                   slugTitle.push(slugClip[0].title)
                   slugDate.push(slugClip[0].created_at)
                } else {
                  console.log("No Clip Found");
                  }
          }
        }

        var oReq = new XMLHttpRequest();
        oReq.addEventListener("load", reqListener);
        if(message.includes("clip/")) {
          console.log("true /");
          message = message.split("clip/");
          message = message[1];
        }
		
		  if(message.includes("?")){
          console.log("?");
          message = message.split("?");
          message = message[0];
        }
		
        if(message.includes("clips.twitch.tv")){
          console.log("clips.twitch");
          message = message.split(".tv/");
          message = message[1];
        }
		

		
		console.log(message);
        oReq.open("GET", "../clipgrab.php?slug="+message);
        oReq.send();
        }
		
      
      

      ComfyJS.Init( "" );
      
      function playVid(url) {
        isVideoPlaying = true;
        if(commandType[0] === "clip") {
            container.style.visibility = 'visible';
            check.style.visibility = 'visible';
            names[0] = names[0].replace("@", "");
            streamer.innerHTML = names[0];
            console.log("Playing Clip")
          } else {
            container.style.visibility = 'visible';
            check.style.visibility = 'hidden';
            slugInfo.style.visibility = 'visible';
            slugInfoTwo.style.visibility = 'visible';
            names[0] = names[0].replace("@", "");
            slugInfo.innerHTML = "<span id='streamerName'>"+names[0]+":</span> "+slugTitle[0];
            slugInfoTwo.innerHTML = "<h6>Clipped by:"+slugCreator[0]+" on: "+slugDate[0].substring(0,10)+"</h6>";
            streamer.innerHTML = names[0];
            console.log("playing slug")
          }
		  if(url === "https://clips-media-assets2.twitch.tv/AT-cm%7C612183207.mp4") {
			  url = "https://www.twitch.guru/wayne.mp4";
		  } 
        video.setAttribute('src', url);
	video.muted = false;        video.play();
      }
    
      video.onended = function() {
       removeVid();
    };

    setInterval(function(){ 
    if(clips.length > 0) {
      if(!isVideoPlaying) {
        playVid(clips[0]);
        }
      }    
    }, 1000);

    function removeVid(){
		video.muted = true;
        video.currentTime = 0;
		video.src = "";
        container.style.visibility = 'hidden';
        check.style.visibility = 'hidden';
        slugInfo.style.visibility = 'hidden';
        slugInfoTwo.style.visibility = 'hidden';
        isVideoPlaying = false;
        clips = clips.slice(1);
        names = names.slice(1);
        if(commandType[0] === "slug"){
          slugCreator = slugCreator.slice(1);
          slugViewCount = slugViewCount.slice(1);
          slugTitle = slugTitle.slice(1);
          slugDate = slugDate.slice(1);
        }
        commandType = commandType.slice(1);
        console.log("Clip Ended!");
    }

        </script>
  </body>
</html>