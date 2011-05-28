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
    .cctv-image {
      cursor: pointer;
    }
    #show-all-cctv-button {
      display: none;
    }
    .suggest-share-text {
      margin-top: 20px;
      font-size: 0.8em;
      color: tomato;
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
  <button type='button' id='show-all-cctv-button'>กล้อง CCTV ทั้งหมด</button>
  <button type='button' id='reload-cctv-button'>reload กล้อง CCTV</button>
  <div class='suggest-share-text'>* ร่วมแบ่งปันสภาพจราจร คลิ๊กที่รูปได้เลยจ้าาา</div>
  <div class='cctv-jsonp-example-output'></div>
</div>
<div class="cleaner"></div>
<script type="text/javascript">
 google.load("jquery", "1.5.1");
 google.setOnLoadCallback(OnLoad);
  var service_endpoint = "http://www.together.in.th/drupal";

  function OnLoad() {
    $('#show-all-cctv-button').click(function(e) {
      window.top.location = "http://www.facebook.com/together.in.th?sk=app_203158633036737";
    });
    $('.cctv-image').live('click', function(e) {
          var self = $(this);
          var siblings = self.siblings('.cctv-info');
          var road = $('.cctv-name', siblings).text();
          var last_update = $('.cctv-lastupdate', siblings).text();
          //console.log('cid: ', self.attr('cid'), $('.cctv-name', siblings).text());
          e.stopPropagation();
          e.preventDefault();
          var success_callback = function() {
            var post_to = FB.getSession().uid || '153305968014537';
            var text_to_post = road + " เมื่อ " + last_update;
            var data_ui = prepare_data_ui(post_to, text_to_post, self.attr('cid'));
            //console.log(data_ui);
            FB.ui(data_ui, function(response) {
              if (response && response.post_id) {
                //console.log(response);
              }
              else {
                //console.log(response);
              }
            });
          }
          doLogin(success_callback);
    });

    $(function() {
      display_cctv();
      $('#reload-cctv-button').click(function(e) {
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

  var prepare_data_ui = function(to, road_text, cid) {
    var picture_path = 'http://www.together.in.th/drupal/sites/default/files/traffy/cctv/'+ cid +'.jpg';
    var data_ui = {
        method: 'feed',
        name: 'แบ่งปันสภาพจราจร',
        link: 'http://www.facebook.com/together.in.th?sk=app_203158633036737&app_data=cid:'+cid,
        picture: picture_path,
        caption: road_text,
        message: '',
        description: ' ',
        to: to
      };
    return data_ui;
  }

  function cctv_layout(cid, name, time) {
    var wrapper = $("<div class='cctv-wrapper' />");
    var info = $("<div class='cctv-info' />");

    var cctv_image_src = service_endpoint + "/traffy/wrapper/getcctvimg?&header=jpeg&format=jpeg&id=" + cid;
    var cctv_image_src_static = service_endpoint + "/traffy/generate/cctvimg/"+ cid + ".jpg";
    var cctv_image = $("<img />").attr({'alt': name, 'src': cctv_image_src_static, 'cid': cid, 'class': 'cctv-image' });

    var name = $("<span class='cctv-name' />").html(name);
    var lastupdate = $("<span class='cctv-lastupdate' />").html(time);

    info.append(name).append(lastupdate);
    wrapper.append(cctv_image).append(info);

    return wrapper;
  }


  var doLogin = function(success_cb) {
    FB.login(function(response) {
      if (response.session) {
        if (response.perms) {
          success_cb();
        } else {
          // user is logged in, but did not grant any permissions
        }
      } else {
        // user is not logged in
        //console.log('not loggedin');
      }
    }, {perms:'publish_stream'});
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
<script>
<?php
  print "window.display_flag = 'all';";
  if (!empty($_REQUEST['signed_request'])) {
    $signed_request = $_REQUEST['signed_request'];
    list($encoded_sig, $payload) = explode('.', $signed_request, 2);
    $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
    if (!empty($data["user_id"])) {
      //if($data["user_id"] == "896050346") {
        if (!empty($data['app_data'])) {
          $exp_data = explode(":", $data['app_data']);
          if ($exp_data[0] == 'cid' && is_numeric($exp_data[1])) {
            print "window.display_flag = 'cid';";
            print "window.cctv_id = ${exp_data[1]};";
          }
        }
        else {
            print "window.display_flag = 'all';";
        }
      //}
    }
  }
?>
</script>
</body>
</html>
