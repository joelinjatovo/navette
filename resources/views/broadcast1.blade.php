<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Publish an event to channel <code>my-channel</code>
    with event name <code>my-event</code>; it will appear below:
  </p>

  <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('69f8d746e9b5ad39d512', {
      cluster: 'eu',
      forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      console.log(JSON.stringify(data));
    });

    // Vue application
      /*
    const app = new Vue({
      el: '#app',
      data: {
        messages: [],
      },
    });
    */
  </script>
</body>