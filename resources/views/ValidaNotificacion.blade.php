<script type="text/javascript">

    

    @if(Session::get('notificacion'))
        var type = "{{ Session::get('tipo', 'info') }}";
        //alert("{{Session::get('mensaje')}}");
        switch (type) {
            case 'info':
                toastr["info"]("{{ Session::get('mensaje') }}", "{{Session::get('titulo')}}");
                break;
            case 'warning':
                toastr["warning"]("{{ Session::get('mensaje') }}", "{{Session::get('titulo')}}");
                break;
            case 'success': 
                toastr["success"]("{{ Session::get('mensaje') }}", "{{Session::get('titulo')}}");
                break;
            case 'error':
                toastr["error"]("{{ Session::get('mensaje') }}", "{{Session::get('titulo')}}");
                break;
        }
    @else
        @if(isset($notificacion))
        var type = "{{ $notificacion['tipo'] }}";
            switch (type) {
                case 'success':
                    toastr['success']("{{ $notificacion['mensaje'] }}");
                    break;
                case 'error':
                    toastr['error']("{{ $notificacion['mensaje'] }}");
                    break;
            }
        @endif
    @endif 

</script>