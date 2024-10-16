<html>

<head>
  <title>Chat Box V1</title>
</head>
<body>
    @if ($Counter>0)

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ShehrozShabbir/ihsancrm/ihsancrmV2.1.css">

<script src="https://cdn.jsdelivr.net/gh/ShehrozShabbir/ihsancrm/ihsancrmV2.1.js"></script>

<script>
const ihsanCRM_init = ihsanCRM('ihsanCRMWebAi', {
name: 'Aaqib AI',
token: '{!! $webKey !!}'
});
</script>
@else
<h5>Sorry Invalid Bot Key ...</h5>
@endif
</body>

</html>
