<head>

    <!--
    <title>Jquery select2 ajax autocomplete example code with demo</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-->
    <!--
    <script src="{{ URL::asset('assets/js/select2/google_ajax.js') }}"></script>
    <!-->
    <link href="{{ URL::asset('assets/js/select2/css_ajax.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('assets/js/select2/js_ajax.js') }}"></script>

    <script>
        function getAjaxItemList(id) {
            $(id).select2({
                placeholder: 'Select an item',
                ajax: {
                    url: '{{ url('pdc/getAllItems') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                let pack_size = (item.pack_size != null) ? '-' + item.pack_size : '';
                                return {
                                    text: item.sku_code + '-' + item.name + pack_size +'%'+ item.uom_name,
                                    id: item.id +'%'+ item.uom_name,
                                    uom: item.uom_name
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        }
    </script>
</head>
