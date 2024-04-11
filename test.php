<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Push Notifications</title>
    
</head>
<body>
    <!-- Your HTML content here -->
    
    <script>
        // Your JavaScript code here
        importScripts("https://js.pusher.com/beams/service-worker.js");

    </script>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script src="service-worker.js"></script>

    <script>
  const beamsClient = new PusherPushNotifications.Client({
    instanceId: 'd3597afd-c67a-4ea3-9610-1ebaa16714e4',
  });

  beamsClient.start()
    .then(() => beamsClient.addDeviceInterest('hello'))
    .then(() => console.log('Successfully registered and subscribed!'))
    .catch(console.error);
</script>
</body>
</html>
