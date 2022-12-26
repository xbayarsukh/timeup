@extends('layouts.app')
@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxVucBtLP4XefoM4syoigBgXntwkVGxv8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0" style="display:flex;height:fit-content">
          <h6 style="width:fit-content;margin:2px">Арга хэмжээ засах</h6>
        </div>
        <div class="col-xl-10 col-lg-10 col-md-10 mx-auto mb-5">
        <div class="card z-index-0">
          
          <div class="card-body">
            {!! Form::open(['url' => 'admin/events/edit', 'method' => 'post', 'role' => 'form', 'files' => 'true', 'enctype' => 'multipart/form-data' ]) !!}
              <div class="mb-3">
                <select class="form-control" name="category" id="">
                  @foreach($category as $categories)
                  <option value="{{$categories->id}}" @if($categories->id == $event->ecat_id) selected="selected" @else @endif>{{$categories->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-3">
                <input type="text" name="title" class="form-control" placeholder="Гарчиг" value="{{$event->title}}">
              </div>
              <div class="mb-3">
                <input type="file" name="image" class="form-control" placeholder="Зураг">
                <img src="/events/img/{{ $event->image }}" alt="" width="70" height="70">
              </div>
              <div class="mb-3">
                <textarea name="description" id="editor">{{$event->description}}</textarea>
              </div>
              <div class="mb-3">
                <input type="text" name="where" class="form-control" placeholder="Хаана" value="{{$event->location}}">
              </div>
              <div style="background-color: #82d616; border-radius: 10px">
                <p style="padding:10px;color:white;font-size:11px">Улаан тэмдэглэгээг зөөж байршилаа сонгоно уу</p>
              </div>
              <div id="map" style="width:100%; height:400px;margin-bottom:40px;border-radius:10px"></div>
              <input type="hidden" id="lat" name="lat" value="{{$event->lat}}">
              <input type="hidden" id="long" name="long" value="{{$event->long}}">
              <div class="mb-3" >
                <div class="col-5 mb-3" style="float:left">
                  <input type="date" name="when" class="form-control" placeholder="Хэзээ" value="{{$event->date}}">
                </div>
                <div class="col-5 mb-3" style="float:right">
                  <input type="time" name="many_time" class="form-control" placeholder="Хэдээс" value="{{$event->time}}">
                </div>
              </div>
              <br></br>
              <hr style="background-color:black">
              <div class="text-center" style="display:flex">
                <input type="hidden" name="id" value="{{$event->id}}">
                <button type="submit" class="btn bg-gradient-dark w-20 my-4 mb-2" style="margin:auto">Хадгалах</button>
                <a href="{{url('admin/events')}}" class="btn bg-gradient-light w-20 my-4 mb-2" style="margin:auto">Болих</a>
              </div>
            {!! Form::close() !!}
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/super-build/ckeditor.js"></script>


<script>
    CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        addCss: '#editor{ border-radius: 10px}',
        toolbar: {
            items: [
                'exportPDF','exportWord', '|',
                'findAndReplace', 'selectAll', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo',
                '-',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        // Changing the language of the interface requires loading the language file using the <script> tag.
        // language: 'es',
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        placeholder: 'Дэлгэрэнгүй',
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        fontSize: {
            options: [ 10, 12, 14, 'default', 18, 20, 22 ],
            supportAllValues: true
        },
        htmlSupport: {
            allow: [
                {
                    name: /.*/,
                    attributes: true,
                    classes: true,
                    styles: true
                }
            ]
        },
        htmlEmbed: {
            showPreviews: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
        mention: {
            feeds: [
                {
                    marker: '@',
                    feed: [
                        '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                        '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                        '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                        '@sugar', '@sweet', '@topping', '@wafer'
                    ],
                    minimumCharacters: 1
                }
            ]
        },
        // The "super-build" contains more premium features that require additional configuration, disable them below.
        // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
        removePlugins: [
            // These two are commercial, but you can try them out without registering to a trial.
            // 'ExportPdf',
            // 'ExportWord',
            'CKBox',
            'CKFinder',
            'EasyImage',
            // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
            // Storing images as Base64 is usually a very bad idea.
            // Replace it on production website with other solutions:
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
            // 'Base64UploadAdapter',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
            // from a local file system (file://) - load this site via HTTP server if you enable MathType
            'MathType'
        ]
    });
</script>
<script>
  var geocoder = new google.maps.Geocoder();
var marker = null;
var map = null;
function initialize() {
      var $latitude = document.getElementById('lat');
      var $longitude = document.getElementById('long');
      var latitude = {{$event->lat}};
      var longitude = {{$event->long}};
      var zoom = 14;

      var LatLng = new google.maps.LatLng(latitude, longitude);

      var mapOptions = {
        zoom: zoom,
        center: LatLng,
        panControl: false,
        zoomControl: false,
        scaleControl: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }

      map = new google.maps.Map(document.getElementById('map'), mapOptions);
      if (marker && marker.getMap) marker.setMap(map);
      marker = new google.maps.Marker({
        position: LatLng,
        map: map,
        title: 'Намайг зөө!',
        draggable: true
      });

      google.maps.event.addListener(marker, 'dragend', function(marker) {
        var latLng = marker.latLng;
        $latitude.value = latLng.lat();
        $longitude.value = latLng.lng();
      });


    }
    $(document).ready(function (){
        initialize();
    });
    
</script>
@endsection