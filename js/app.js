


var app = new Vue({
    el: '#app',
    data: {
      clipSource: ""
    }
  })

  ComfyJS.onCommand = ( user, command, message, flags, extra ) => {
    if( flags.broadcaster && command === "test" ) {
      console.log( "!test was typed in chat" );
      app.message = ("<iframe src=\"https://clips.twitch.tv/embed?clip=PoliteFinePlumAllenHuhu&parent=www.example.com\" frameborder=\"0\" allowfullscreen=\"true\" scrolling=\"no\" height=\"378\" width=\"620\"></iframe>")
    }
  }

  function getTwitchClips() {

  }

  ComfyJS.Init( "fisfhood" );
