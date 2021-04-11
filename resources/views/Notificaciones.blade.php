@if(Session::get('notificacion'))

    <script>
        toastr["{{Session::get('notificacion.tipo')}}"]("{{ Session::get('notificacion.mensaje') }}", "{{Session::get('notificacion.titulo')}}");
    </script>

@elseif(Session::get('sweetalert'))

    <script>
        swal({
            title: "{{ Session::get('sweetalert.titulo') }}",
            text: "{{ Session::get('sweetalert.mensaje') }}",
            type: "{{ Session::get('sweetalert.tipo') }}"
        });
    </script>

@endif