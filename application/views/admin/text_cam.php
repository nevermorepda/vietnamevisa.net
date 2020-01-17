<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Camera Directive</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body ng-app="myApp">

  <div class="container" ng-controller="MainCtrl">
    <camera class="camera" on-select="getPhoto(photo)"></camera>

    <hr>

    <ul class="nostyle">
      <li ng-repeat="photo in photos">
        <img id="ahihi" style="width: 100%;" ng-src="{{photo.src}}">
      </li>
    </ul>
    <a class="btn btn-warning btn-get-img">Upload</a>
    <canvas id="c" width="1920" height="1080"></canvas>
  </div>
<script src="https://www.vietnam-visa.org.vn/template/js/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular.min.js"></script>
<!--   <script src="app.js"></script>
  <script src="exif-restorer.js"></script>
  <script src="camera.js"></script> -->
  <script type="text/javascript">
      angular.module('myApp', [])
      .run(function () {
      })
      .controller('MainCtrl', function ($scope) {

        $scope.photos = [];

        $scope.getPhoto = function (photoPromise) {
          photoPromise.then(function (imgSrc) {
            $scope.photos.push({
              src: imgSrc
            });
          });
        };

      });
  </script>

  <script type="text/javascript">
    $(document).on('click', '.btn-get-img', function(event) {
      event.preventDefault();
      var image = $('#ahihi').attr('src'); // to create a image read the previous example

        $.ajax({
          url:"<?=site_url('syslog/ajax-test-camera')?>",
          data:{
            base64: image
          },
          type:"post",
          dataType:'html',
          success: function (result) {
            console.log(result);
          }
        });
    });
   
  </script>
  <script type="text/javascript">

////////////////////////////////////////////////////////////////////////////////////////////

      /*
 * ExifRestorer by Martin Prantl
 * See http://www.perry.cz/files/ExifRestorer.js
 */
angular.module('myApp')
  .factory('ExifRestorer', function () {
    //Based on MinifyJpeg
    //http://elicon.blog57.fc2.com/blog-entry-206.html

    //noinspection UnnecessaryLocalVariableJS
    var ExifRestorer = (function()
    {

      var ExifRestorer = {};
      ExifRestorer.restore = function(origFileBase64, resizedFileBase64)
      {
        if (!origFileBase64.match("data:image/jpeg;base64,"))
        {
          return resizedFileBase64;
        }

        var rawImage = this.decode64(origFileBase64.replace("data:image/jpeg;base64,", ""));
        var segments = this.slice2Segments(rawImage);

        var image = this.exifManipulation(resizedFileBase64, segments);

        return this.encode64(image);

      };


      ExifRestorer.exifManipulation = function(resizedFileBase64, segments)
      {
        var exifArray = this.getExifArray(segments),
          newImageArray = this.insertExif(resizedFileBase64, exifArray),
          aBuffer = new Uint8Array(newImageArray);

        return aBuffer;
      };


      ExifRestorer.getExifArray = function(segments)
      {
        var seg;
        for (var x = 0; x < segments.length; x++)
        {
          seg = segments[x];
          if (seg[0] == 255 & seg[1] == 225) //(ff e1)
          {
            return seg;
          }
        }
        return [];
      };


      ExifRestorer.insertExif = function(resizedFileBase64, exifArray)
      {
        var imageData = resizedFileBase64.replace("data:image/jpeg;base64,", ""),
          buf = this.decode64(imageData),
          separatePoint = buf.indexOf(255,3),
          mae = buf.slice(0, separatePoint),
          ato = buf.slice(separatePoint),
          array = mae;

        array = array.concat(exifArray);
        array = array.concat(ato);
        return array;
      };



      ExifRestorer.slice2Segments = function(rawImageArray)
      {
        var head = 0,
          segments = [];

        while (1)
        {
          if (rawImageArray[head] == 255 & rawImageArray[head + 1] == 218){break;}
          if (rawImageArray[head] == 255 & rawImageArray[head + 1] == 216)
          {
            head += 2;
          }
          else
          {
            var length = rawImageArray[head + 2] * 256 + rawImageArray[head + 3],
              endPoint = head + length + 2,
              seg = rawImageArray.slice(head, endPoint);
            segments.push(seg);
            head = endPoint;
          }
          if (head > rawImageArray.length){break;}
        }

        return segments;
      };



      ExifRestorer.KEY_STR = "ABCDEFGHIJKLMNOP" +
      "QRSTUVWXYZabcdef" +
      "ghijklmnopqrstuv" +
      "wxyz0123456789+/" +
      "=";

      ExifRestorer.encode64 = function(input)
      {
        var output = "",
          chr1, chr2, chr3 = "",
          enc1, enc2, enc3, enc4 = "",
          i = 0;

        do {
          chr1 = input[i++];
          chr2 = input[i++];
          chr3 = input[i++];

          enc1 = chr1 >> 2;
          enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
          enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
          enc4 = chr3 & 63;

          if (isNaN(chr2)) {
            enc3 = enc4 = 64;
          } else if (isNaN(chr3)) {
            enc4 = 64;
          }

          output = output +
          this.KEY_STR.charAt(enc1) +
          this.KEY_STR.charAt(enc2) +
          this.KEY_STR.charAt(enc3) +
          this.KEY_STR.charAt(enc4);
          chr1 = chr2 = chr3 = "";
          enc1 = enc2 = enc3 = enc4 = "";
        } while (i < input.length);

        return output;
      };



      ExifRestorer.decode64 = function(input)
      {
        var output = "",
          chr1, chr2, chr3 = "",
          enc1, enc2, enc3, enc4 = "",
          i = 0,
          buf = [];

        // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
        var base64test = /[^A-Za-z0-9\+\/\=]/g;
        if (base64test.exec(input)) {
          alert("There were invalid base64 characters in the input text.\n" +
          "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
          "Expect errors in decoding.");
        }
        input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

        do {
          enc1 = this.KEY_STR.indexOf(input.charAt(i++));
          enc2 = this.KEY_STR.indexOf(input.charAt(i++));
          enc3 = this.KEY_STR.indexOf(input.charAt(i++));
          enc4 = this.KEY_STR.indexOf(input.charAt(i++));

          chr1 = (enc1 << 2) | (enc2 >> 4);
          chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
          chr3 = ((enc3 & 3) << 6) | enc4;

          buf.push(chr1);

          if (enc3 != 64) {
            buf.push(chr2);
          }
          if (enc4 != 64) {
            buf.push(chr3);
          }

          chr1 = chr2 = chr3 = "";
          enc1 = enc2 = enc3 = enc4 = "";

        } while (i < input.length);

        return buf;
      };


      return ExifRestorer;
    })();

    return ExifRestorer;
  });
  </script>
  <script type="text/javascript">
      angular.module('myApp')
  .directive('camera', function ($q, ExifRestorer) {
    // Fix for chrome
    //noinspection JSUnresolvedVariable
    window.URL = window.URL || window.webkitURL;

    /**
     * Calculate scale factor
     *
     * @param memImg
     * @returns {number}
     */
    var calcXFactor = function (memImg) {
      var maxSize = 800;
      if (memImg.width < maxSize && memImg.height < maxSize) {
        return 1;
      }

      return memImg.width > memImg.height ? maxSize / memImg.width : maxSize / memImg.height;
    };

    /**
     * Convert selected file for upload to some data URL
     * which we can set to src of any image tag
     *
     * @param files
     */
    var setPicture = function (files) {
      if (!(files.length === 1 && files[0].type.indexOf("image/") === 0)) {
        return;
      }

      // Promise for final image url to display and send to server
      var deferredImgSrc = $q.defer();
      // Promise for temp. memory image for resizing
      var memImgDefer = $q.defer();
      // Promise for file reader to read the original file data
      var binaryReaderDefer = $q.defer();

      var memImg = new Image();
      memImg.onload = function () {
        var imgCanvas = document.createElement("canvas"),
          imgContext = imgCanvas.getContext("2d");

        // Make sure canvas is as big as the picture
        var xfactor = calcXFactor(this);
        imgCanvas.width = (this.width * xfactor) >> 0;
        imgCanvas.height = (this.height * xfactor) >> 0;

        // Draw image into canvas element
        imgContext.drawImage(this, 0, 0, imgCanvas.width, imgCanvas.height);

        var targetImage = imgCanvas.toDataURL('image/jpeg', .80);

        // Send the resized image as promised
        memImgDefer.resolve(targetImage);
        memImg = null;
        imgCanvas = null;
        imgContext = null;
      };


      // Read image for exif
      var binaryReader = new FileReader();
      binaryReader.onloadend = function (e) {
        binaryReaderDefer.resolve(e.target.result);
      };

      //noinspection JSUnresolvedFunction
      memImg.src = URL.createObjectURL(files[0]);
      binaryReader.readAsDataURL(files[0]);


      $q.all([memImgDefer.promise, binaryReaderDefer.promise]).then(function (images) {
        var sourceImage = images[0];
        var targetImage = images[1];
        // Copy exif data
        ExifRestorer.restore(sourceImage, targetImage);

        deferredImgSrc.resolve(targetImage);
      });

      return deferredImgSrc.promise;
    };


    /**
     * Directive definition
     */
    return {
      restrict: 'E',
      template: '<input type="file" capture="camera" accept="image/*" id="camera" style="visibility: hidden;" />' +
      '<img>' +
      '<button class="btn btn-default" ng-click="takePhoto()">' +
      '<i class="fa fa-camera"></i> Take / Upload Photo' +
      '</button>',
      scope: {
        onSelect: '&'
      },
      link: function ($scope, element) {
        var input = element.find('input');

        input.on('change', function (event) {
          $scope.onSelect({
            photo: setPicture(event.target.files)
          });
        });

        $scope.takePhoto = function () {
          input[0].click();
        };

      }
    }
  });
  </script>
</body>
</html>