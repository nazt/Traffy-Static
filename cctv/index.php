<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Bangkok CCTV</title>
  <meta name="author" content="iNAzT">
  <!-- Date: 2011-03-25 -->
  <script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAAIGrUyMawOsMwPNQ1fDjKfRTO2GP6viO2ZGn3HxCyFOGqrcbBIhS4idv32G-DF41klrTYAqYQKbnAWQ"></script>
<style type="text/css">
    .cctv-wrapper {
       width: 400px;
       padding-bottom: 20px;
       margin: 2px;
     }
    .cleaner {
      clear: both;
    }
</style>
</head>
<body>
    <div id="fb-root"></div>
  <div class ="cctv-wrapper">
	  <fb:like-box href="http://www.facebook.com/together.in.th" width="292" show_faces="false" stream="false" header="false"></fb:like-box>
  </div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId  : '203158633036737',
          status : true, // check login status
          cookie : true, // enable cookies to allow the server to access the session
          xfbml  : true  // parse XFBML
        });
	FB.Canvas.setAutoResize(90);
      }
    </script>
  <div class='cctv-jsonp-example'>
  <button type='button' id='show-cctv-button'>reload กล้อง CCTV</button>
  <div class='cctv-jsonp-example-output'></div>
</div>
<div class="cleaner"></div>
<script type="text/javascript">
 google.load("jquery", "1.5.1");
 google.setOnLoadCallback(OnLoad);
  var service_endpoint = "http://www.together.in.th/drupal";

  function OnLoad() {
    $(function() {
      display_cctv();
      $('#show-cctv-button').click(function(e) {
        $('.cctv-jsonp-example-output').children().remove();
        display_cctv();
	FB.Canvas.setSize();
      });
    });
  }

  function display_cctv() {
    var loading = $("<div class='loading-cctv'>Loading...</div>");
    loading.css('padding', '20px');
    $('.cctv-jsonp-example-output').append(loading);

    $.getJSON(service_endpoint+ '/traffy/wrapper/getcctv/?format=js&call=?&header=js', function(res) {
      $.each(res, function(k, v) {
        $('.cctv-jsonp-example-output').append(cctv_layout(k, v.name_th, v.lastupdate));
      });

      $('.cctv-wrapper').css('margin', '20px 20px');
      $('.cctv-lastupdate').css('margin-left', '10px');

      $(loading).remove();
    });
  }

  function cctv_layout(cid, name, time) {
    var wrapper = $("<div class='cctv-wrapper' />");
    var info = $("<div class='cctv-info' />");

    var cctv_image_src = service_endpoint + "/traffy/wrapper/getcctvimg?&header=jpeg&format=jpeg&id=" + cid;
    var cctv_image_src_static = service_endpoint + "/traffy/generate/cctvimg/"+ cid + ".jpg";
    var cctv_image = $("<img alt='cctv-image' />").attr('src', cctv_image_src_static);

    var name = $("<span class='cctv-name' />").html(name);
    var lastupdate = $("<span class='cctv-lastupdate' />").html(time);

    info.append(name).append(lastupdate);
    wrapper.append(cctv_image).append(info);

    return wrapper;
  }
</script>
  <script type="text/javascript">
      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js#xfbml=1';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
  </script>
</script>

<div class ="cctv-wrapper">
	<fb:like-box href="http://www.facebook.com/together.in.th" width="292" show_faces="false" stream="false" header="false"></fb:like-box>
</div>
<div class="site-footer">by <a target="_blank" href="/">http://www.together.in.th</a></div>
</body>
</html>
