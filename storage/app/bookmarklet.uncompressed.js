(function(){
  // the minimum version of jQuery we want
  var v = "1.5";
  // check prior inclusion and version
  if (window.jQuery === undefined || window.jQuery.fn.jquery < v) {
    var done = false;
    var script = document.createElement("script");
    script.src = "//ajax.googleapis.com/ajax/libs/jquery/" + v + "/jquery.min.js";
    script.onload = script.onreadystatechange = function(){
      if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
        done = true;
        gem_shorten();
      }
    };
    document.getElementsByTagName("head")[0].appendChild(script);
  } else {
    gem_shorten();
  }
  
  function gem_shorten() {
    (window.myBookmarklet = function() {
     var appurl=jQuery("#gem_bookmarklet").attr("data-url");
     var token=jQuery("#gem_bookmarklet").attr("data-token");
      // HTML Template
      var html='<div id="gempixel-bookmarklet" style="z-index:99999 !important;box-shadow:0 5px 10px rgba(0,0,0,0.1) !important;font-family:arial !important;font-size:13px !important;background:#fff !important;position:fixed !important;border-radius:5px !important;color:#000 !important; padding-bottom: 5px !important;"><h2 style="border-bottom:1px solid #eee !important;margin:0 !important ;padding:10px !important;font-size:14px !important;color:#000 !important;">URL Shortener<a style="color:#000 !important;font-size:11px !important;text-align:right !important;text-decoration:none !important;float:right !important;margin-top:2px !important;" id="close" href="#close">(Close)</a></h2><form style="padding:10px !important;"><label for="gem-url">Short URL</label><input style="border-radius:3px !important;margin-top:10px !important;background:#fff !important;border:1px solid #32a0ee !important;width:250px !important;display:block !important;padding:5px 8px !important;" type="text" name="url" id="gem-url" value=""></form></div>';
      //Append HTML
      jQuery("body").append(html);
      //Adjust CSS
      jQuery("#gempixel-bookmarklet").css({top:'20px',left:((jQuery(document).width() - jQuery("#gempixel-bookmarklet").width())*0.5)});
      //Show Box
      jQuery("#gempixel-bookmarklet").slideDown('slow');
      //Close and Remove Box
      jQuery("#gempixel-bookmarklet #close").click(function(e){
        e.preventDefault();
        jQuery("#gempixel-bookmarklet").remove();
      });
      jQuery.getJSON(appurl+"/?bookmark=true&callback=?",
      {
        url: document.URL,
        token: token
      },
      function(r) {
       if(r.error=='0'){
        jQuery("#gempixel-bookmarklet #gem-url").val(r.short).select();
       }else{
        jQuery("#gempixel-bookmarklet #gem-url").val(r.msg);
       }      
      });  
    })();
  }
})();