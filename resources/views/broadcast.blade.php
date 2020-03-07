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
  <div id="app">
  </div>
  <script src="/js/app.js"></script>
</body>